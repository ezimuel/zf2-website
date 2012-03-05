<?php

class AuthController extends Zend_Controller_Action
{
    
    /**
     * @var Zend_Auth
     */
    protected $_auth;

    /**
     * @var Application_Form_Auth
     */
    protected $_authForm;
    
    protected $_previousUrl = null;

    protected $_db;
    
    public function init()
    {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '' && (strpos($_SERVER['HTTP_REFERER'], '.com/auth/') === false)) {
            $url = preg_replace('#^http(s?)://' . preg_quote($_SERVER['HTTP_HOST']) . '#', '', $_SERVER['HTTP_REFERER']);
            $this->_previousUrl = $url;
            setcookie('auth-previous-url', $url, null, '/auth/');
        } elseif (isset($_COOKIE['auth-previous-url'])) {
            $this->_previousUrl = $_COOKIE['auth-previous-url'];
        } else {
            $this->_previousUrl = $this->view->baseUrl('auth');
        }
        
        
        
        $this->_auth = Zend_Auth::getInstance();
        ZfWeb_Plugins_Caching::$doNotCache = true;

        $bootstrap = $this->getInvokeArg('bootstrap');
        $this->_db = $bootstrap->getResource('multidb')->getDb('crowd');
    }
    
    public function indexAction()
    {
        if ($this->_auth->hasIdentity()) {
            if ($_POST) {
                $this->view->message = "You are already logged in.";
            }
            $this->view->user = $this->_auth->getIdentity();
            return;
        }
        
        $this->view->authForm = $form = $this->_getAuthForm();
        
        if ($_POST) {
            if ($form->isValid($_POST)) {
                
                $username = $form->getValue('username');
                $password = $form->getValue('password');
                
                $adapter = new ZfWeb_Auth_Pbkdf2(
                    $this->_db,
                    'cwd_user',
                    'user_name',
                    'credential'
                );
    
                $adapter->setIdentity($username);
                $adapter->setCredential($password);
                
                $result = $this->_auth->authenticate($adapter);

                if ($result->isValid()) {
                    $userInfo = $adapter->getResultRowObject();
                    $user = new User();
                    $user->username = $userInfo->user_name;
                    $user->name = $userInfo->first_name . ' ' . $userInfo->last_name;
                    $user->email = $userInfo->lower_email_address;
                    $this->_auth->getStorage()->write($user);
                    $this->view->user = $this->_auth->getIdentity();
                    return $this->_redirect($this->_previousUrl);
                }

                $this->view->message = current($result->getMessages());
            }
        }
        
        $this->view->previousUrl = $this->_previousUrl;
    }
    
    public function logoutAction()
    {
        $this->_auth->clearIdentity();
        
        if ($this->_previousUrl) {
            $this->_redirect($this->_previousUrl);
            return;
        }
        
        $this->_redirect('/auth/');
    }

    public function developerAction()
    {
        if (APPLICATION_ENV == 'production') {
            $this->_redirect('/taboo');
            return;
        }

        if ($_GET['action'] == 'make-me-user') {
            $user = new User();
            $user->username = (isset($_GET['username'])) ? $_GET['username'] : 'Anonymoose';
            $user->name     = (isset($_GET['name'])) ? $_GET['name'] : 'Anony Moose';
            $user->email    = (isset($_GET['email'])) ? $_GET['email'] : 'foo@bar.com';
            $this->_auth->getStorage()->write($user);
            return $this->_redirect('/?you-are-user-' . $user->username);
        }

    }

    /**
     * @return Zend_Form
     */
    protected function _getAuthForm()
    {
        if (null === $this->_authForm) {
            require_once dirname(__FILE__) . '/../forms/Auth.php';
            $this->_authForm = new Application_Form_Auth(array(
                'action' => '/auth/',
                'method' => 'post',
            ));
        }
        return $this->_authForm;
    }
}

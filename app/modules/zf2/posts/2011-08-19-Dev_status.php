<?php
$post = new stdClass;
$post->title  = '2011-08-19 Dev status update';
$post->author = (object) array(
    'name' => "Enrico Zimuel",
    'link' => 'http://www.zimuel.it',
);
$post->date = '2011-08-19 12:32';
$post->summary =<<<'EOS'
<p>
    The first weekly status update about the development of ZF2.
</p>
EOS;

$post->content =<<<'EOC'
<h2>Community Initiatives</h2>

<p>
    Obviously, community interaction has exploded. Since last week, we've had
    almost 400 messages in the <a
        href="http://zend-framework-community.634137.n4.nabble.com/ZF-Contributor-f680267.html">zf-contributors
        mailing list</a>, an IRC meeting, and the start of a dedicated "ZF2"
    area of the main website (if you're reading this, you're in it). 
</p>

<p>Topics that have been under heavy discussion include:</p>

<ul>
    <li>What will modules look like, and how will they be installed (and potentially distributed).</li>
    <li>Process: how should the proposal process work moving forward, and what ideas fit for it. One item we've agreed upon is that for architectural issues, posting to the mailing list, discussing in IRC, and creating RFC-style pages in the wiki is probably better.</li>
    <li>Visualizing development status: <a href="http://framework.zend.com/zf2/status">a page has been built</a>, based on the work of Evan Coury in his <a href="https://github.com/EvanDotPro/zf-status">zf-status</a> project. This should help folks identify what new changes and features exist that they may want to review.</li>
</ul>

<p>
    If you missed the IRC meeting, we have a <a
        href="http://framework.zend.com/zf2/blog/entry/2011-08-17-IRC-Meeting-Log">summary
    posted</a>.
</p>   

<h2>Development status</h2>

<p>
    
    
    The Zend Framework core team has decided to write, every week, a post on this blog to inform about the development status of ZF2.<br />
    The aim of this update is to have a new channel where the developers that are working on the ZF2 can share ideas with the community and inform people about the working progress of the project. Of course, we have the <a href="http://framework.zend.com/wiki/display/ZFDEV2/Home">ZF wiki</a>, the <a href="http://framework.zend.com/wiki/display/ZFDEV/Contributing+to+Zend+Framework#ContributingtoZendFramework-Subscribetotheappropriatemailinglists">mailing lists</a> and the IRC channels (#zftalk.dev, #zf2-meeting) but we think that this blog can be helpful as well.<br />
    This is the first post of the new ZF2 blog about the dev status update of ZF2. We hope you will find it useful.<br />
</p>

<p>
    In the last week the Zend Framework Core Team has been involved in the development of the new Zend\Http components.
    In particular we have redesigned the following classes:<br />
    <ul>
        <li>Zend\Http\Request</li>
        <li>Zend\Http\Response</li>
        <li>Zend\Http\Headers</li> 
        <li>Zend\Http\Client</li>    
    </ul><br />
    We implemented these components following the RFC specifications:<br /><br />
    <ul>
        <li><a href="http://tools.ietf.org/html/rfc2616">RFC2616</a>, for the HTTP 1.1</li>
        <li><a href="http://tools.ietf.org/html/rfc3986">RFC3986</a>, for the Uniform Resource Identifier (URI)</li>
        <li><a href="http://tools.ietf.org/html/rfc2069">RFC2069</a>, <a href="http://tools.ietf.org/html/rfc2617">RFC2617</a>, for the HTTP Authentication: Basic and Digest Access Authentication</li>
    </ul>
    <br />
    The new API provided is more convenient compared with the ZF1. We provided a full OO implementation of the
    Headers with specific features for each type (for instance we have Zend\Http\Header\Accept that implements the Accept header type).<br />
    These classes are implemented in the namespace Zend\Http\Header. In order to support not standard headers we built a
    generic header class, Zend\Http\Header\GenericHeader.
</p>
<p>
    The new Zend\Http\Client is basically a class that uses the Request, Response, Headers components to send request to a specific HTTP adapter.<br />
    Just to give you an idea of these new architecture, we reported an example of two different uses for the same use case:<br /><br />
    <b>First example</b>
    <pre class="highlight">
    $client= new Zend\Http\Client('http://www.test.com');
    $client->setMethod('POST');
    $client->setParameterPost(array('foo' => 'bar));
    
    $response= $client->send();
    
    if ($response->isSuccess()) {
        //  the POST was successfull
    }
    </pre>
    <b>Second example</b>
    <pre class="highlight">
    $request= new Zend\Http\Request();
    $request->setUri('http://www.test.com');
    $request->setMethod('POST');
    $request->setParameterPost(array('foo' => 'bar));
    
    $client= new Zend\Http\Client();
    $response= $client->send($request);
    
    if ($response->isSuccess()) {
        //  the POST was successfull
    }
    </pre><br />
    Moreover, we implemented a static version of the Zend\Http\Client to be able to write something simple code like that:<br />
    <pre class="highlight">
    $response= Zend\Http\ClientStatic::post('http://www.test.com',array('foo'=>'bar'));
    
    if ($response->isSuccess()) {
        //  the POST was successfull
    }
    </pre>
</p>    

EOC;

return $post;

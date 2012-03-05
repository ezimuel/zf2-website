<?php
$post = new stdClass;
$post->title  = '2011-08-17 IRC Meeting';
$post->author = (object) array(
    'name' => "Matthew Weier O'Phinney",
    'link' => 'http://weierophinney.net/matthew/',
);
$post->date = '2011-08-15 13:40';
$post->summary =<<<'EOS'
<p>
    The Zend Framework community is having the first of its bi-weekly IRC 
    meetings this coming Wednesday, 17 August 2011, at 17:00 UTC. Find out what 
    we'll discuss, and how you can participate.
</p>
EOS;

$post->content =<<<'EOC'
<p>
    The Zend Framework community is having the first of its bi-weekly IRC 
    meetings this coming Wednesday, 17 August 2011, at 17:00 UTC.
</p>

<p>
    The meeting will be held on Freenode IRC, in a new channel "#zf2-meeting". 
    As this is the first meeting, we'll be primarily discussing the structure
    of future meetings, as well as process and milestones for ZF2.
</p>

<p>
    This first meeting's agenda is located at:
</p>

<dl>
    <dd><a href="http://framework.zend.com/wiki/display/ZFDEV2/2011-08-17+Meeting+Agenda">http://framework.zend.com/wiki/display/ZFDEV2/2011-08-17+Meeting+Agenda</a></dd>
</dl>

<p>
    Those with the rights to edit pages in the wiki can add to the agenda; be 
    warned, however, that the idea is to keep the topics timeboxed to ensure
    that the essentials are covered, decisions are made, and actionable items
    discovered and assigned.
</p>

<p>
    Following the meeting, we will post the transcript, and link to it via this
    blog, along with a summary.
</p>
EOC;

return $post;

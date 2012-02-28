<?php
#readfile( "http://eprints.ecs.soton.ac.uk/23/index.page" );exit;

$url = $_GET['url'];
$win = $_GET['win'];

$printing = false;
$icons = "
<div style='float:right;padding-left:1em'>
<a id=\"winComment$win\" onclick='javascript:winComment($win)'>C</a>
<a id=\"winCollapse$win\" onclick='javascript:winCollapse($win)'>-</a>
<a style='display: none' id=\"winFull$win\" onclick='javascript:winFull($win)'>+</a>
</div>
<div style='float:left;padding-right:1em'>
<a id=\"winClose$win\" onclick='javascript:closeWindow($win)'>X</a>
</div>
";

print '<div class="pageWindow"><div class="title">youtube'.$icons.'</div>';
print '<div class="contentWrapper" id="winContentWrapper'.$win.'">';
print '<div class="content" id="winContent'.$win.'">';
preg_match( '/v=([^&?]*)/', $url, $r );
print '<iframe width="360" height="270" src="http://www.youtube.com/embed/'.$r[1].'" frameborder="0" allowfullscreen></iframe>';
print "</div>";
print "</div>";
print "</div>";

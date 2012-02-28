<?php
require_once( "sparqllib.php" );
$win = $_GET['win'];
$endpoint = $_GET['endpoint'];
$icons = "
<div style='float:right;padding-left:1em'>
<a id=\"winComment$win\" onclick='javascript:winComment($win)'>C</a>
<a id=\"winCollapse$win\" onclick='javascript:winCollapse($win)'>-</a>
<a id=\"winTerse$win\" onclick='javascript:winTerse($win)'>=</a>
<a style='display: none' id=\"winFull$win\" onclick='javascript:winFull($win)'>+</a>
</div>
<div style='float:left;padding-right:1em'>
<a id=\"winClose$win\" onclick='javascript:closeWindow($win)'>X</a>
</div>
";

print '<div class=""><div class="title">'.$endpoint.$icons.'</div>';
print '<div class="contentWrapper" id="winContentWrapper'.$win.'">';
print '<div class="content" id="winContent'.$win.'">';

print "<div>URI: <input style='width:300px' id='win${win}uri' value='' /> <a href='javascript:openSPARQLPage( $win, \"$endpoint\", document.getElementById(\"win${win}uri\").value, \"uri\"  )'>open</a></div>";
print "<div><a href='javascript:openSPARQLPage( $win, \"$endpoint\", \"\", \"graphs\"  )'>show some graphs</a></div>";


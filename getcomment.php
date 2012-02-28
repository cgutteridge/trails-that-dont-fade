<?php

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

print '<div class="commentWindow"><div class="title">Comment'.$icons.'</div>';
print '<div class="contentWrapper" id="winContentWrapper'.$win.'">';
print '<div class="content" id="winContent'.$win.'">';
print '<textarea id="wysiwyg'.$win.'" style="width:99%" ></textarea>';
print "</div>";
print "</div>";
print "</div>";
?>
<script type="text/javascript">
(function($) {
	$(document).ready(function() { $('#wysiwyg<?php print $win ?>').wysiwyg(); });
})(jQuery);
</script>


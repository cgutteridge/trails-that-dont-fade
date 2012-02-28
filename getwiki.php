<?php

$page = $_GET['page'];
$win = $_GET['win'];
$page=preg_replace( '/ /','_' ,$page);
$url = "http://en.wikipedia.org/wiki/$page";
$o = "";
$lines = file( $url );


$printing = false;
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
if( @$_GET['section'] ) 
{
	print '<div class="sectionWindow"><div class="title">'.$icons.preg_replace( '/_/',' ',$page).':<br />'.preg_replace( '/_/',' ',$_GET['section']).'</div>';
}
else
{
	print '<div class="pageWindow"><div class="title">'.$icons.preg_replace( '/_/',' ',$page).'</div>';
}
print '<div class="contentWrapper" id="winContentWrapper'.$win.'">';
print '<div class="content" id="winContent'.$win.'">';
foreach( $lines as $line )
{
	if( $printing && preg_match( '/"editsection"/', $line )) { break; }
	if( preg_match( '/<!-- \/bodycontent -->/', $line )) { break; }
	if( $printing && preg_match( '/<h2>/', $line ) && ! preg_match( '/<h2>Content/', $line )) { break; }
	if( $printing ) { 
		if( preg_match( '/<h2>Content/', $line ) )
		{
#			print '<hr />';
		}
		else
		{
			$line = preg_replace( '/href="\/wiki\/([^"#]*)"/','href="javascript:openWikiPage('.$win.',\'$1\');"', $line );
			$line = preg_replace( '/href="#([^"#]*)"/','href="javascript:openWikiSection('.$win.',\''.$page.'\',\'$1\');"', $line );
			print $line; 
		}
	}
	if( @$_GET['section'] ) 
	{
		$regex=  '/id="'.$_GET['section'].'"/';
		if( preg_match( $regex, $line )) { $printing= true; }
	}
	else
	{
		if( preg_match( '/<!-- bodycontent -->/', $line )) { $printing= true;}
	}
}
print "</div>";
print "</div>";
print "</div>";

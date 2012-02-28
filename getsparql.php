<?php
require_once( "sparqllib.php" );
$win = $_GET['win'];
$endpoint = $_GET['endpoint'];
$uri = $_GET['uri'];
$type = @$_GET['type'];
$title = $uri;
if( isset($type ) ) { $title = "$type: $title"; }
$icons = "
<div style='float:right;padding-left:1em'>
<a id=\"winComment$win\" onclick='javascript:winComment($win)'>C</a>
<a id=\"winTerse$win\" onclick='javascript:winTerse($win)'>=</a>
<a id=\"winCollapse$win\" onclick='javascript:winCollapse($win)'>-</a>
<a style='display: none' id=\"winFull$win\" onclick='javascript:winFull($win)'>+</a>
</div>
<div style='float:left;padding-right:1em'>
<a id=\"winClose$win\" onclick='javascript:closeWindow($win)'>X</a>
</div>
";

print '<div class=""><div class="title">'.$title.$icons.'</div>';
print '<div class="contentWrapper" id="winContentWrapper'.$win.'">';
print '<div class="content" id="winContent'.$win.'">';

$nextquery = 'uri';
if( $type == 'types' )
{
	$sparql = 'SELECT DISTINCT ?uri ?label WHERE {
  	GRAPH <'.$uri.'> { ?x a ?uri }
        OPTIONAL { ?uri <http://www.w3.org/2000/01/rdf-schema#label> ?label }
   	OPTIONAL { ?uri <http://purl.org/dc/terms/title> ?label }
	} ORDER BY ?uri';
	$nextquery = 'type';
}
if( $type == 'type' )
{
	$sparql = 'SELECT DISTINCT ?uri ?label WHERE {
  	?uri a  <'.$uri.'> .
        OPTIONAL { ?uri <http://www.w3.org/2000/01/rdf-schema#label> ?label }
   	OPTIONAL { ?uri <http://purl.org/dc/terms/title> ?label }
	} ORDER BY ?uri';
}
if( $type == 'props' )
{
	$sparql = 'SELECT DISTINCT ?uri ?label WHERE {
  	GRAPH <'.$uri.'> { ?x ?uri ?y }
        OPTIONAL { ?uri <http://www.w3.org/2000/01/rdf-schema#label> ?label }
   	OPTIONAL { ?uri <http://purl.org/dc/terms/title> ?label }
	} ORDER BY ?uri';
}

if( $type == 'graphs' )
{
	$sparql = 'SELECT DISTINCT ?graph ?label WHERE {
  		GRAPH ?graph { ?a ?b ?c }
  		OPTIONAL { ?graph <http://www.w3.org/2000/01/rdf-schema#label> ?label }
  		OPTIONAL { ?graph <http://purl.org/dc/terms/title> ?label }
	} LIMIT 100';
	$results = sparql_get( $endpoint, $sparql ) ;
	foreach( $results as $result )
	{
  		$graph = $result['graph'];
  		print "<div style='border-top: dashed #669 1px; margin-top:3px;padding-top:3px'>";
  		print "<a href='javascript:openSPARQLPage( $win, \"$endpoint\", \"$graph\", \"props\" );'>props</a> | ";
  		print "<a href='javascript:openSPARQLPage( $win, \"$endpoint\", \"$graph\", \"types\" );'>types</a> | ";
  		print "$graph</div>";
	}
}
elseif( $type == 'uri' )
{
	$sparql = 'SELECT DISTINCT ?uri ?pred ?label WHERE {
  	   <'.$uri.'> ?pred ?uri .
           OPTIONAL { ?uri <http://www.w3.org/2000/01/rdf-schema#label> ?label }
	} ORDER BY ?pred ?uri';

	$results = sparql_get( $endpoint, $sparql ) ;

	if( sizeof( $results ) )
	{
		print "<h3 style='background-color: #eef'>Relations TO this resource</h3>";
		$lastpred = "";	
		print "<dl>";
		foreach( $results as $result )
		{
  			$uri = $result['uri'];
			if( $lastpred != $result['pred'] )
			{
				$lastpred = $result['pred'];
				print "<dt style='font-weight: bold; margin-top:1em;'>$lastpred</dt>";
			}
 			print "<dd style='margin-top:0.5em'>";
			print "&rarr; ";
 			print "<a href='javascript:openSPARQLPage( $win, \"$endpoint\", \"$uri\", \"$nextquery\" );'>";
			if( @$result['label'] != '' )
			{
				print $result['label'];
			}
			else
			{
				print $uri;
			}
			print "</a>";
 			print "</dd>";
		}
		print "</dl>";
	}

	$sparql = 'SELECT DISTINCT ?uri ?pred ?label WHERE {
  	   ?uri ?pred  <'.$uri.'> .
           OPTIONAL { ?uri <http://www.w3.org/2000/01/rdf-schema#label> ?label }
	} ORDER BY ?pred ?uri';

	$results = sparql_get( $endpoint, $sparql ) ;

	if( sizeof( $results ) )
	{
		print "<h3 style='background-color: #eef'>Relations FROM this resource</h3>";
		$lastpred = "";	
		print "<dl>";
		foreach( $results as $result )
		{
  			$uri = $result['uri'];
			if( $lastpred != $result['pred'] )
			{
				$lastpred = $result['pred'];
				print "<dt style='font-weight: bold; margin-top:1em;'>$lastpred</dt>";
			}
 			print "<dd style='margin-top:0.5em'>";
			print "&larr; ";
 			print "<a href='javascript:openSPARQLPage( $win, \"$endpoint\", \"$uri\", \"$nextquery\" );'>";
			if( @$result['label'] != '' )
			{
				print $result['label'];
			}
			else
			{
				print $uri;
			}
			print "</a>";
 			print "</dd>";
		}
		print "</dl>";
	}










}
else
{

	$results = sparql_get( $endpoint, $sparql ) ;
	
	foreach( $results as $result )
	{
  		$uri = $result['uri'];
 		print "<div style='border-top: dashed #669 1px; margin-top:3px;padding-top:3px'>";
 		print "<a href='javascript:openSPARQLPage( $win, \"$endpoint\", \"$uri\", \"$nextquery\" );'>";
		if( @$result['label'] != '' )
		{
			print $result['label'];
		}
		else
		{
			print $uri;
		}
	
		print "</a>";
 		print "</div>";
	}

}

print '</div> </div> </div>';

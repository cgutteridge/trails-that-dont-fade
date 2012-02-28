<?php
$page = 'Project_Xanadu';
if( @$_GET['node'] ) { $page = $_GET['node']; }
?>
<html>
 <head>
   <title>Experimental Wikipedia Interface</title>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" media="all" />
   <script type="text/javascript" src='js/jquery-1.7.1.min.js' ></script>
   <script type="text/javascript" src='js/jquery-ui-1.8.18.custom.min.js' ></script>
   <script type="text/javascript" src='canvasutilities.js' ></script>
   <script type="text/javascript" src='dump.js' ></script>
<link rel="stylesheet" href="jwysiwyg/jquery.wysiwyg.css" type="text/css"/>
<script type="text/javascript" src="jwysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="jwysiwyg/controls/wysiwyg.image.js"></script>
<script type="text/javascript" src="jwysiwyg/controls/wysiwyg.link.js"></script>
<script type="text/javascript" src="jwysiwyg/controls/wysiwyg.table.js"></script>
   <script type="text/javascript">

function winComment( win )
{
	url = "getcomment.php?";
	openWindow( win, url, 'v' );
}
// like collapse with no anim
function winHide( win )
{
	$("#winContentWrapper"+win).css( 'display','none');
	$("#winCollapse"+win).css('display','none' );
	$("#winTerse"+win).css('display','inline' );
	$("#winFull"+win).css('display','inline' );
}
function winCollapse( win )
{
	$("#winContentWrapper"+win).hide( 'blind',500,function(){drawLines();} );
	$("#winCollapse"+win).css('display','none' );
	$("#winTerse"+win).css('display','inline' );
	$("#winFull"+win).css('display','inline' );
}
function winTerse( win )
{
	$("#winContentWrapper"+win).css('display','block');
	$("#winContentWrapper"+win).animate( {"height":"200px"}, 500,function(){drawLines();} );
	$("#winCollapse"+win).css('display','inline' );
	$("#winTerse"+win).css('display','none' );
	$("#winFull"+win).css('display','inline' );
}
function winFull( win )
{
	$("#winContentWrapper"+win).show( 'blind',500,function(){drawLines();} );
	$("#winCollapse"+win).css('display','inline' );
	$("#winTerse"+win).css('display','inline' );
	$("#winFull"+win).css('display','none' );
}
    //$(this).animate({"color":"#efbe5c","font-size":"52pt"}, 1000);

function drawLines()
{
  document.getElementById('background').style.backgroundColor = "#008888";
  var canvas = document.getElementById("background");
  var context = canvas.getContext("2d");
  context.beginPath();
  context.rect(0,0,4000,4000);
  context.fillStyle = "#8ED6FF";
  //context.strokeStyle = "#8ED6FF";
  context.lineWidth = 3;
  context.fill();
  context.beginPath();
  for (i in linkslist) 
  {
    joinWindows( linkslist[i][0], linkslist[i][1] );
  }
}
function blockMidPoint( block )
{
   pos = block.position();
   return { 
      'x': pos.left+ (block.width()/2), 
      'y': pos.top +(block.height()/2)};
}
function blockToAnchorPoint( blockA, blockB )
{
   midA = blockMidPoint( blockA );
   midB = blockMidPoint( blockB );
   posB = blockB.position();

   diffV = midB.y - midA.y;
   diffH = midB.x - midA.x;

   candidates = [];
   // fraction along the line
   if( midB.x < midA.x )
   {
       p = (posB.left+blockB.width() - midA.x) / diffH;
       candidates.push( { x: posB.left+blockB.width(), y: midA.y + p*diffV } );
   }
   if( midB.x > midA.x )
   {
       p = (posB.left - midA.x) / diffH;
       candidates.push( { x: posB.left, y: midA.y + p*diffV } );
   }

   if( midB.y < midA.y )
   {
       p = (posB.top+blockB.height() - midA.y) / diffV;
       candidates.push( { x: midA.x + p*diffH, y: posB.top+blockB.height() } );
   }
   if( midB.y > midA.y )
   {
       p = (posB.top - midA.y) / diffV;
       candidates.push( { x: midA.x + p*diffH, y: posB.top } );
   }

   
   
//alert( dump( candidates ) );
   for (i in candidates ) 
   {
      c = candidates[i];
      if( c.x<posB.left ) { continue; }
      if( c.x>posB.left+blockB.width() ) { continue; }
      if( c.y<posB.top ) { continue; }
      if( c.y>posB.top+blockB.height() ) { continue; }
      return c;
   }

   
   // find the intersects between middle(A)->middle(b) and the borders of blockB.
   
   // y = a.x + b
   // (y-b)/a = x


   return { 
      'x': pos.left+ (blockB.width()/2), 
      'y': pos.top };
}
function joinWindows( a, b )
{
  mid_a = blockMidPoint( $('#win'+a) );
  mid_b = blockToAnchorPoint( $('#win'+a),$('#win'+b) );
  var canvas = document.getElementById("background");
  var context = canvas.getContext("2d");
//alert( mid_a['x']+","+mid_a['y']+" -> "+mid_b['x']+","+mid_b['y'] );
  context.lineWidth = 3;
  context.fillStyle = "#6060ff";
  context.strokeStyle = "#6060ff";
  drawArrow(context, mid_a['x'], mid_a['y'], mid_b['x'], mid_b['y'],1,1,0.4,16);
//  context.moveTo(mid_a['x'], mid_a['y']);
 // context.lineTo(mid_b['x'], mid_b['y']);
}

//#background { background-color: yellow; }
   </script>
	<style type="text/css">
	body { background-color: #c0c0c0; margin: 0px; height: 100%; }
	.window { border: 1px solid #000000; background-color: #ffffff; 
position:absolute; left:5px; top:5px;
  -moz-box-shadow:    6px 6px 5px 3px rgba(0,0,0,0.3);
  -webkit-box-shadow: 6px 6px 5px 3px rgba(0,0,0,0.3);
  box-shadow:         6px 6px 5px 3px rgba(0,0,0,0.3);
	}
	.title { background-color: #333399; color: white;
	  padding:0em 0.5em 0em 0.5em; 
	  text-align:center;
          overflow-x: hidden;
    	}
	.content { padding: 5px 10px 10px 10px; font-size:80%; }
	.contentWrapper { width: 400px; overflow-y: auto;overflow-x: hidden}
        .sectionWindow .content { background-color: #eee; }
        .sectionWindow .title { background-color: #888; }
        .commentWindow .content { background-color: #eeee99; padding: 0px;}
        .commentWindow .contentWrapper { overflow: hidden; }
	</style>
</head>
 <body>
<canvas style='background-color: #999' id='background' width='4000' height='4000' ></canvas>
<div id='windows'></div>
<div id='tools' class='window'>
<div class='title'>Tools</div>
<div class='content'>
<div>Wikipedia: <input id='wikinode' value='Project Xanadu' /> <a href='javascript:openWikiPage( null, document.getElementById("wikinode").value )'>open</a></div>
<div>Youtube: <input id='youtube' value='http://www.youtube.com/watch?v=7_J7XOdB3zk' /> <a href='javascript:openYouTubePage( null, document.getElementById("youtube").value )'>open</a></div>
<div>SPARQL Endpoint: <input id='endpoint' value='http://sparql.data.southampton.ac.uk/' /> <a href='javascript:openEndpointPage( null, document.getElementById("endpoint").value )'>open</a></div>


</div>
</div>
</div>

<script>
$(document).ready(function($){
  drawLines();
  $('#tools').draggable({ handle: $(".title"), opacity: 0.8 });
  $("#wikinode").keyup(function(event){
    if(event.keyCode == 13){
        openWikiPage( null, document.getElementById("wikinode").value);
    }
  });
  $("#youtube").keyup(function(event){
    if(event.keyCode == 13){
        openYouTubePage( null, document.getElementById("youtube").value);
    }
  });
  $("#endpoint").keyup(function(event){
    if(event.keyCode == 13){
        openEndpointPage( null, document.getElementById("endpoint").value);
    }
  });
//  openEndpointPage( null, 'http://sparql.data.southampton.ac.uk/' );
  //$('#background').width(  $(document).width() );
  //$('#background').height(  $(document).height() );
} );
var winCounter = 0;
var linkslist = [];
function openWikiSection( fromWinID, page, section ) 
{ 
	url = "getwiki.php?page="+page+"&section="+section;
	openWindow( fromWinID, url, 'v' );
}
function openWikiPage( fromWinID, page ) 
{ 
	url = "getwiki.php?page="+page;
	openWindow( fromWinID, url );
}
function openYouTubePage( fromWinID, yturl ) 
{ 
	url = "getyoutube.php?url="+encodeURIComponent(yturl);
	openWindow( fromWinID, url );
}
function openEndpointPage( fromWinID, endpoint ) 
{ 
	url = "getendpoint.php?endpoint="+encodeURIComponent(endpoint);
	openWindow( fromWinID, url );
}
function openSPARQLPage( fromWinID, endpoint, uri, type ) 
{ 
	url = "getsparql.php?endpoint="+encodeURIComponent(endpoint)+"&uri="+encodeURIComponent(uri);
	if( type ) { url += "&type="+type; }
	openWindow( fromWinID, url );
}



function openWindow( fromWinID, url, dir )
{
	if( !dir ) { $dir = "h"; }
	winCounter++;
	url += "&win="+winCounter;
	$('#windows').append('<div style="" id="win'+winCounter+'" class="window"></div>' );
	var newWin = $('#win'+winCounter );
	var fromWin = $('#win'+fromWinID );
	if( fromWinID ) { 
		winHide( fromWinID );
		linkslist.push(  [ fromWinID, winCounter ] );
		pos = fromWin.position();
		if( dir == 'v' ) 
		{ 
			newWin.css('left', pos['left' ] );
			newWin.css('top', pos['top' ] + fromWin.height()+40);
		}
		else
		{
			newWin.css('left', pos['left' ] + fromWin.width()+40);
			newWin.css('top', pos['top' ] );
		}
	}
	else
	{
		newWin.css('left', 400);
		newWin.css('top', 40 );
	}
	var winID = winCounter;
	$.ajax({
  		url: url,
  		cache: false,
  		success: function(html){
    			//newWin.append("<p>"+winID+"</p>");
    			newWin.append(html);
			newWin.draggable({
				handle: $(".title"),
				opacity: 0.8,
				drag: function(event, ui) { drawLines(); },
				stop: function(event, ui) { drawLines(); }
			});
			//newWin.css( "border", "solid 2px green" );
			$("#winContentWrapper"+winID).resizable();
  			drawLines();
			pos = newWin.position();
			winWidth = $(window).width();
			$('body').animate({ 
				scrollTop: pos.top-40,
				scrollLeft: pos.left-winWidth/2+200,
			}, 500);
    			newWin.dblclick(function () { 
	
      				if( $("#winContentWrapper"+winID).css( 'display' ) == 'none' )
				{
					winFull(winID);
				}
				else
				{
					winCollapse(winID);
				}
    			});
  		}
	});
}
function closeWindow(win)
{
	$('#win'+win).hide( 'puff' );
	linkslist = linkslist.filter( function(v) { return v[0] != win && v[1] != win; } );
	drawLines();
}
</script>




 </body>
</html>

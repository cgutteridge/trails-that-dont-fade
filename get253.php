<?php

$url = @$_GET['url'];
$win = @$_GET['win'];
if( !isset( $url ) ) { $url = "http://www.ryman-novel.com/info/home.htm"; }


$f = join( '', file( $url ) );

preg_match( '/<TITLE>([^<]*)/i', $f, $r );
$title = $r[1];


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
print '<div class="pageWindow"><div class="title">253: '.$title.$icons.'</div>';
print '<div class="contentWrapper" id="winContentWrapper'.$win.'">';
print '<div class="content" id="winContent'.$win.'">';


$f = preg_replace( '/<img[^>]*>/i','',$f);
$f = preg_replace( '/.*<body[^>]*>/s','',$f);
$f = preg_replace( '/<\/body>.*$/s','',$f);
$f = preg_replace( '/(href)="([^"]*)"/ei', '"$1=\'javascript:open253Page($win, \"".resolve_href("'.$url.'","$2")."\");\'"'   , $f );
$f = preg_replace( '/(src)="([^"]*)"/ei', '"$1=\'".resolve_href("'.$url.'","$2")."\'"'   , $f );
print $f;

print "</div>";
print "</div>";
print "</div>";
exit;
function resolve_href ($base, $href) {
     
    // href="" ==> current url.
    if (!$href) {
        return $base;
    }

    // href="http://..." ==> href isn't relative
    $rel_parsed = parse_url($href);
    if (array_key_exists('scheme', $rel_parsed)) {
        return $href;
    }

    // add an extra character so that, if it ends in a /, we don't lose the last piece.
    $base_parsed = parse_url("$base ");
    // if it's just server.com and no path, then put a / there.
    if (!array_key_exists('path', $base_parsed)) {
        $base_parsed = parse_url("$base/ ");
    }

    // href="/ ==> throw away current path.
    if ($href{0} === "/") {
        $path = $href;
    } else {
        $path = dirname($base_parsed['path']) . "/$href";
    }

    // bla/./bloo ==> bla/bloo
    $path = preg_replace('~/\./~', '/', $path);

    // resolve /../
    // loop through all the parts, popping whenever there's a .., pushing otherwise.
        $parts = array();
        foreach (
            explode('/', preg_replace('~/+~', '/', $path)) as $part
        ) if ($part === "..") {
            array_pop($parts);
        } elseif ($part!="") {
            $parts[] = $part;
        }

    return (
        (array_key_exists('scheme', $base_parsed)) ?
            $base_parsed['scheme'] . '://' . $base_parsed['host'] : ""
    ) . "/" . implode("/", $parts);

}

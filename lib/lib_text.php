<?php

function bbDecode($string) {

	$find = array(
		"'\[b\](.*?)\[/b\]'is",
		"'\[u\](.*?)\[/u\]'is",
		"'\[i\](.*?)\[/i\]'is",
		"'\[s\](.*?)\[/s\]'is",
		"'\[code\](.*?)\[/code\]'is",
		"'\[quote\](.*?)\[/quote\]'is",
		"'\[quote=(.*?)\](.*?)\[/quote\]'is",
		"'\[span=(.*?)\](.*?)\[/span\]'i",
		"'\[div=(.*?)\](.*?)\[/div\]'is",
		"'\[h\](.*?)\[/h\]'i",
		"'\[url\](.*?)\[/url\]'i",
		"'\[url=(.*?)\](.*?)\[/url\]'i",
		"'\[video\](.*?)\[/video\]'i",
		"'\[video width=(.*?) height=(.*?)\](.*?)\[/video\]'i",
		"'\[img\](.*?)\[/img\]'i",
		"'\[img title=(.*?) rel=(.*?)\](.*?)\[/img\]'i",
		"'\[img title=(.*?)\](.*?)\[/img\]'i",
	);

	$replace = array(
		"<strong>\\1</strong>",
		"<u>\\1</u>",
		"<i>\\1</i>",
		"<del>\\1</del>",
		"<pre>\\1</pre>",
		"<q>\\1</q>",
		"<q><span class=\"cite\">\\1 a écrit</span><br />\\2</q>",
		"<span class=\"\\1\">\\2</span>",
		"<div class=\"\\1\">\\2</div>",
		"<b>\\1</b><br />",
		"<a href=\"\\1\">\\1</a>",
		"<a href=\"\\1\">\\2</a>",
		"<object width=\"480\" height=\"387\" class=\"center\"><param name=\"movie\" value=\"\\1\"></param><embed src=\"\\1\" type=\"application/x-shockwave-flash\" width=\"480\" height=\"387\"></embed></object>",
		"<object width=\"\\1\" height=\"\\2\" class=\"center\"><param name=\"movie\" value=\"\\3\"></param><embed src=\"\\3\" type=\"application/x-shockwave-flash\" width=\"\\1\" height=\"\\2\"></embed></object>",
		"<a href=\"\\1\" rel=\"prettyPhoto\"><img src=\"\\1\" alt=\"\" /></a>",
		"<img class=\"illustration\" src=\"\\3\" alt=\"\\1\" />",
		"<img src=\"\\2\" alt=\"\\1\" />",
	);

	$string = makeLinks(preg_replace ($find, $replace, $string));
	$string = nl2brPlus ($string);

	return $string;
}

// do nl2br except when in a <pre> tag
function nl2brPlus($string) {
	$string = str_replace("\n", "<br />", $string);
	if(preg_match_all('/\<pre\>(.*?)\<\/pre\>/', $string, $match)){
		foreach($match as $a){
			foreach($a as $b){
				$string = str_replace('<pre>'.$b.'</pre>', "<pre>".str_replace("<br />", "", $b)."</pre>", $string);
			}
		}
	}
	return $string;
}

# Transform URL and e-mails into links
function makeLinks($string) {
	$string = preg_replace_callback('/\s(http|https|ftp):(\/\/){0,1}([^\"\s]*)/i','splitUri',$string);
	return $string;
}

# Split links, require for makeLinks
function splitUri($matches) {
	$uri = $matches[1].':'.$matches[2].$matches[3];
	$t = parse_url($uri);
	$link = $matches[3];
				
	if (!empty($t['scheme'])) {
		return ' <a href="'.$uri.'">'.$link.'</a>';
	} else {
		return $uri;
	}
}

// parse la description pour ajouter les liens sur les tags
function parse_tags ($desc) {
	$desc_parse = preg_replace ('/#([\w\dÀÇÈÉÊËÎÏÔÙÚÛÜàáâçèéêëîïóùúûü]+)/i', '<a class="linktag" href="?addtag=\\1">\\1</a>', $desc);

	return $desc_parse;
}

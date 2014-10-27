<?php
class Utilities{
	public static function text2link($text){
        // force http: on www.
        

        // The Regular Expression filter
		 $reg_wwwUrl = "/(www)\.[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        $reg_httpUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        // Check if there is a url in the text
        if(preg_match($reg_httpUrl, $text, $url)) {
                   // make the urls hyper links
                   $text = preg_replace($reg_httpUrl, '<a href="'.$url[0].'" rel="nofollow">'.$url[0].'</a>', $text);
        } else if(preg_match($reg_wwwUrl, $text, $url)){
		 $text = preg_replace($reg_wwwUrl, '<a href="'.$url[0].'" rel="nofollow">'.$url[0].'</a>', $text);
		}    // if no urls in the text just return the text
                   return ($text);
	}
}
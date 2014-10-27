<?php
class Url{
	function __construct(){
		
	}
	
	public static function redirect($url, array $data=null){
		if(!is_null($data)){
			
			if(is_array($data)){
				
				foreach($data as $key=>$val){
					
				$var="_".$key;
				$_SESSION['_ap']["_url"][$var]=$val;
				
				}
				
			}else{
				echo "Sorry the data was not an array";
				exit();
				
			}
			
			
		}
		
		
		if(filter_var($url, FILTER_VALIDATE_URL)){
			header("location:".$url);
		}else{
			header("location:".BU.$url);	
		}
		ob_end_flush();
		exit();
		
	}
	
	
	public static function getData($var){
		if(isset($_SESSION['_ap']['_url'])){
			return $_SESSION['_ap']['_url']["_".$var];	
		}else{
			return false;
		}
	}
	
	public static function hasData($var){
		if(isset($var)){
			if(isset($_SESSION['_ap']['_url']['_'.$var])){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
	public static function clearAll(){
		if(isset($_SESSION['_ap'])){
			unset($_SESSION['_ap']);
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	public static function make($url=null){
		if(!is_null($url)){
			return BU.removeBeginSlashFromString($url);
		}
	}
	
	public static function getCurrent(){
		$host="http://".$_SERVER['HTTP_HOST'];
		$path=isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
		$url=$host.$path;
		return $url;
	}
	
	public static function getReferer(){
		if(isset($_SERVER['HTTP_REFERER'])){
			return $_SERVER['HTTP_REFERER'];
		}else{
			return false;
		}
	}

	public static function getSegment($index=null){
		global $_url;
		if(!is_null($index)){
			$index-=1;
			$url=explode("/", $_url);

			if(array_key_exists($index, $url)){
				return $url[$index];
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	public static function getUri(){
		global $_url;

		return removeBeginSlashFromString(removeEndSlashFromString($_url));
	}
}

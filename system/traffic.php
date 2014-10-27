<?php
function setReporting() {
	if (DEV_ENV == TRUE) {
		error_reporting(E_ALL);
		ini_set('display_errors', 'On');
	} else {
		error_reporting(E_ALL);
		ini_set('display_errors', 'Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
	}
}

function stripSlashesDeep($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

function removeMagicQuotes() {
if ( get_magic_quotes_gpc() ) {
	$_GET    = stripSlashesDeep($_GET   );
	$_POST   = stripSlashesDeep($_POST  );
	$_COOKIE = stripSlashesDeep($_COOKIE);
}
}


// this function is used for unregistered global variable
/*
function unregisterGlobals() {
	if (ini_get('register_globals')) {
		$array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
		foreach ($array as $value) {
			foreach ($GLOBALS[$value] as $key => $var) {
				if ($var === $GLOBALS[$key]) {
					unset($GLOBALS[$key]);
				}
			}
		}
	}
}*/

/*
*get url without any parameter //
*example:
*input:http://fb.me/uid=123
*return:http://fb.me/
*/

function getExactUrl($url){
	if(strpos($url, '?')>0){

		$pos=strpos($url, "?");
		$uri=substr($url, 0, $pos);

		return $uri;
	}

	return $url;
	
}


function parseClassString($str){
	$param=array();

	$string=explode('/', $str);

	$class=trim($string[0]);

	$funcString=explode(':', $string[1]);

	$func=trim($funcString[0]);

	if(isset($funcString[1])){
		$param=explode(',', $funcString[1]);
	}

	require_once ROOT.DS."app".DS."actions".DS.$class.".php";

	if(class_exists($class)){
		$class=ucfirst($class);
		$newInstance=new $class();

		call_user_func_array(array($newInstance, $func), $param);

	}


}



function urlDrive(){
	global $_url;
	global $_router;
	global $template;


	$_url=!empty($_url)?$_url:'/';
	$_url= $_url!='/'?removeEndSlashFromString(getExactUrl($_url)):$_url;


		$pre=false;
		$post=false;
		$skin='';
	
	$pg='';

	/*if(array_key_exists($_url, $router)){
		$pg=$router[$_url];
	}else{
		$pg=$_url;
	}
	
	if(array_key_exists($_url, $template)){
		$templates=$template[$_url];
	}*/
	if(array_key_exists($_url, $_router)){

		if(is_array($_router[$_url])){
			// checking is the page key exist
			if(isset($_router[$_url]['page'])){
				$pg=$_router[$_url]['page'];
			}

			//checking is the skin key exist

			if(isset($_router[$_url]['skin'])){

				$skin=!$_router[$_url]['skin']?$_router[$_url]['skin']:"skins".DS.$_router[$_url]['skin'];
			}
		}
	}else{
		$pg=$_url;
	}
	
	// if DBENABLE is true then database connection will established
	if(DBENABLE===true){
		
	$connection=new Crud;
		
	}
	
	$route=new Router();

		if(isset($_router[$_url]['pre'])){
				parseClassString($_router[$_url]['pre']);
			}

			if(isset($_router[$_url]['action'])){
				parseClassString($_router[$_url]['action']);
			}

			if(isset($_router[$_url]['page'])){
			call_user_func_array(array($route, "pageLoad"), array($pg, $skin));
			}

		if(isset($_router[$_url]['post'])){
				parseClassString($_router[$_url]['post']);
			}
	
	if(DBENABLE===true){
		
	mysqli_close(Crud::$_db);
		
	}
	
	
	
	
	
}


// This function used for class auto load...
function __autoload($class) {
	if (file_exists(ROOT . DS . "system" . DS."core".DS . strtolower($class) . ".sys.php")) {
		require_once (ROOT . DS . "system" . DS."core". DS . strtolower($class) . ".sys.php");
	}elseif (file_exists(ROOT . DS . "system" . DS."vendor".DS . strtolower($class) . ".php")) {
		require_once (ROOT . DS . "system" . DS."vendor". DS . strtolower($class) . ".php");
	}
}

setReporting();
removeMagicQuotes();
//unregisterGlobals();
urlDrive();
?>
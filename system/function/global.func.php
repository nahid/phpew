<?php


function baseUrl(){
	return BU;
}

function assets($file=''){
	global $_assetsDir;
	if(realpath(ROOT.DS.$_assetsDir)){
		return BU.str_replace("\\", "/", $_assetsDir).$file;
	
	}
	return false;
}

function basePath(){
	return ROOT.DS;
}



function systemPath(){
	global $_systemDir;
	if(realpath(ROOT.DS.$_systemDir)){
		return ROOT.DS.$_systemDir;
	}

	return false;
}



function appPath(){
	global $_appDir;
	if(realpath(ROOT.DS.$_appDir)){
		return ROOT.DS.$_appDir;
	}

	return false;
}



function clearSessionData(){
	if(isset($_SESSION['_ap'])){
		unset($_SESSION['_ap']);
	}
}

function removeBeginSlashFromString($string){
		if(isset($string)){
			if(substr(ltrim($string, ' '), 0, 1)=='/'){
				$newstring=substr_replace(ltrim($string, ' '), '', 0,1);
				return $newstring;
			}else{
				return $string;
			}
		}
	}

function removeEndSlashFromString($string){
		if(isset($string)){
			if(substr(rtrim($string, ' '), -1, 1)=='/'){
				$newstring=substr_replace(rtrim($string, ' '), '', -1,1);
				return $newstring;
			}else{
				return $string;
			}
		}
	}


function isDirectAccess($msg="Unauthorized Access!"){
	$getCSRFToken=@$_SESSION['_ap']['csrf']?$_SESSION['_ap']['csrf']:false;

	if($getCSRFToken){
		if($getCSRFToken!==CSRFHASH){
			die($msg);
		}
	}else{
		die($msg);
	}
}
	


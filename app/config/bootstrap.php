<?php
global $_ds_, $_root_;


//global constant for root directory
define("ROOT", $_root_);

//global constant for directory separator
define("DS", $_ds_);

require_once('basic.php');

if(!isset($_SESSION['_ap']['csrf'])){
	$_SESSION['_ap']['csrf']=CSRFHASH;
}


require_once(ROOT.DS."app".DS."config".DS."mimetype.php");
require_once(ROOT.DS."system".DS."function".DS."global.func.php");
require_once('database.php');

//require_once (ROOT . DS . "public" . DS . "global.func.php");
require_once (ROOT . DS . "app" . DS . "router.php");
require_once (ROOT . DS . "system" . DS . "traffic.php");




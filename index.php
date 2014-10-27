<?php
ob_start();
session_start();
$_url=@$_GET['_url_'];

$_ds_=DIRECTORY_SEPARATOR;
$_root_=dirname(__FILE__);


/*
app directory path. you can change your app path from here
*/
$_appDir="app".$_ds_;


/*
system directory path. you can change your system directory path from here
*/
$_systemDir="system".$_ds_;



/*
assets directory path. you can change your assets directory path from here
*/
$_assetsDir="assets".$_ds_;



require_once($_root_.$_ds_.$_appDir.'config'.$_ds_.'bootstrap.php');
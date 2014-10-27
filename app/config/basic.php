<?php

//set development environment
define("DEV_ENV",TRUE);

//base url
define('BU',"http://localhost/phpew/");


//set url separator
define('US', '/');

//default home page setting
define('HOMEPAGE', 'home');

//here you CSRF HASH token
define('CSRFHASH','d0a91ccf1fa862ea3d4d5d9c929a8b6d');


/*
	if you want to escape page direct access you have to uncomment below line
	and use the example code in every single pages

	example: if(!defined('escapeDirectAccess')) die('Your desire message');
*/
	
//define('escapeDirectAccess', true);



//Authority mail
define('AUTH_EMAIL','info@nahid.co');
define('AUTH_NAME', 'Mehedi Hasan Nahid');

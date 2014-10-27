<?php
/*
 * In $router set your url as an alias, and asaign file based on path for route 
 *key=url and value=page
 */
 
$_router=array(
	'/'=>array('page'=>'home'),
	'i/am/nahid'=>array('page'=>'nahid',  'pre'=>'test/alert:nahid,codesum'),
	'dipok/page'=>array('page'=>'dipok', "pre" => "dipok/show:10"),
	'dhaka/bangladesh'=>array('page'=>'shanto', 'skin'=>'master'),
	'login/process'=>array('page'=>'login', 'skin'=>false),
	'user/logout'=>array('page'=>'logout', 'skin'=>false),
	'file/download'=>array('page'=>'subir', 'skin'=>false),
	'barisal/city'=>array('page'=>'sawkot', 'pre'=>'dates/todays:2013-10-8'),
	'user/naim'=>array('page'=>'naim')

);


/*
 * set which url will got template
 */
 
/*$template=array(
	'new/user'=>true,
	'i/am/nahid'=>false
);*/

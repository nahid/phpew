<?php
//if(!defined('escapeDirectAccess')) die('Not allow direct access');
echo Url::getCurrent();

if(@$_POST['submit']){
 $rules=array(
	'name'=>'required&not_in:1,3,5,7',
	'username'=>'required&min:5&unique:user,username',
	'email'=>'required&email',
	'password'=>'required&same:repassword'
	);

Validator::validate($_POST, $rules);

if(Validator::hasErrors()){
		foreach (Validator::errorsAll() as $err) {
		echo $err."<br/>";
	}
}



}

?>
<form action="<?php //echo Url::make('login/process'); ?>" method="post">

<input type="text" name="name"/><br/>
<?php
if(Validator::hasErrors()){
	foreach (Validator::getErrors('name') as $err) {
		echo $err."<br/>";
	}
}
?>
<input type="text" name="username"/><br/>
<?php
if(Validator::hasErrors()){
	foreach (Validator::getErrors('username') as $err) {
		echo $err."<br/>";
	}
}
?>
<input type="text" name="email"/><br/>
<?php
if(Validator::hasErrors()){
	foreach (Validator::getErrors('email') as $err) {
		echo $err."<br/>";
	}
}
?>

<input type="password" name="password"><br/>
<?php
if(Validator::hasErrors()){
	foreach (Validator::getErrors('password') as $err) {
		echo $err."<br/>";
	}
}
?>
<input type="password" name="repassword"><br/>



<input type="submit" name="submit" value="Submit">

</form>

<?php
/*echo basename($_SERVER['HTTP_REFERER']);
echo Url::getSegment(2);*/

/*$url="http://nahid.co";
$reqUrl="http://nahid.co/auth/login";

if(!substr_compare($reqUrl, $url, 0, strlen($url))){
	echo "Yes";
}else{echo "no"; }


echo substr_compare($reqUrl, $url, 0, strlen($url));*/


?>
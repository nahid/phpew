<?php
$user=@$_POST['username'];
$pwd=@$_POST['password'];



$login=Auth::login('user', array('username'=>$user, 'password'=>$pwd));

if($login){
	Auth::setData(array('name'=>'Nahid', 'web'=>'http://nahid.co'));

	Url::redirect('home');
	//echo Auth::getData('email');
}


/*$rules=array(
	'name'=>'required&min:5',
	'username'=>'required&max:10&unique:user,username',
	'password'=>'required&same:repassword',
	'email'=>'required&email'
	);

Validator::validate($_POST, $rules);

if(Validator::hasErrors()){
	foreach (Validator::errorsAll() as $err) {
		echo $err."<br/>";
	}
}*/

?>
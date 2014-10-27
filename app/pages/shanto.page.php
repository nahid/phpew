<?php
if(@$_POST['submit']){
	$rules=array(
		'name'=>'required&max:10',
		'username'=>'required&unique:user,username',
		'password'=>'required&same:repassword',
		'email'=>'in:1,3,5'
		);

	Validator::validate($_POST, $rules);

	if(Validator::hasErrors()){
		Url::redirect('i/am/nahid');
	}
}

?>

<form action="" method="post">
<label>Name</label><br/>
<input type="text" name="name"><br/>
<label>Username</label><br/>
<input type="text" name="username"><br/>
<label>Password</label><br/>
<input type="password" name="password"><br/>
<label>Repassword</label><br/>
<input type="password" name="repassword"><br/>
<label>Email</label><br/>
<input type="text" name="email"><br/><br/>
<input type="submit" name="submit" value="Submit">
</form>
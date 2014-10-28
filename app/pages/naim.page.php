<h1>Calculator</h1>
<form action="" method="post">
<label>Enter First Value</label><br/>
<input type="text" name="val1" /><br/>
<label>Enter Second Value</label><br/>
<input type="text" name="val2" /><br/><br/>
<input type="submit" name="submit" value="Resutl"/>
</form>
<?php
if(@$_POST['submit']){
	$rules=array(
		'val1'=>'required&numeric',
		'val2'=>'required&numeric'
		);

	$valid=Validator::validate($_POST, $rules);

	if($valid->hasErrors()){
		foreach($valid->errorsAll() as $err){
			echo $err."<br/>";
		}
	}else{
		$v1=@$_POST['val1'];
		$v2=@$_POST['val2'];

		echo "The result is : ". ($v1+$v2);
	}
}
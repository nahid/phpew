<h1>Welcome Sawkot Vai</h1>

<?php
if(Validator::hasErrors()){
	foreach (Validator::errorsAll() as $err) {
		echo $err."<br/>";
	}
}

//Images::load('files')->to('uploads/images/')->save(array(''))
?>
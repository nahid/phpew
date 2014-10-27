<?php
/*
* @author: Mehedi Hasan Nahid
* @copyright: nahid.co 
* @licence: open source (Free Use)
* @param array $errors: used for store all errors from validation
* @param array $inputs: store all inputs that will validate

*/
class Validator{
	protected static $errors=array();
	protected static $inputs=array();

	protected static $_instance = null;

	protected static function _apInstance() {
		if (self::$_instance === null) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	protected static function requiredValidation($input, $name){
		if(empty($input)){
			self::$errors[$name][]=$name." is required field";
			return false;
		}else{
			return true;
		}
	}

	protected static function minValidation($input, $param, $name){
		$length=strlen($input);
		$min=(int)$param;
		if($length<$min){
			self::$errors[$name][]="The minimum length is for ".$name." is ".$param;
			return false;
		}else{
			return true;
		}
	}


	protected static function maxValidation($input, $param, $name){
		$length=strlen($input);
		$max=(int)$param;
		if($length>$max){
			self::$errors[$name][]="The maximum length is for ".$name." is ".$param;
			return false;
		}else{
			return true;
		}
	}
	

	protected static function fileValidation($input, $name){
		if(!isset($_FILES[$name])){
			self::$errors[$name][]=$name." is contains no file";
			return false;
		}else{
			return true;
		}
	}

	protected static function dateValidation($input, $name){
		if(strtotime($input)===false){
			self::$errors[$name][]=$name." is not a valid date";
			return false;
		}else{
			return true;
		}
	}

	protected static function date_maxValidation($input, $param, $name){
		if(strtotime($input)>=strtotime($param)){
			self::$errors[$name][]=$name." is greater than date ".$param;
			return false;
		}else{
			return true;
		}
	}

	protected static function date_minValidation($input, $param, $name){
		if(strtotime($input)<=strtotime($param)){
			self::$errors[$name][]=$name." is smaller than date ".$param;
			return false;
		}else{
			return true;
		}
	}

	protected static function inValidation($input, $param, $name){
		$list=explode(',', $param);
		if(!in_array($input, $list)){
			self::$errors[$name][]=$name." is not allowed";
			return false;
		}else{
			return true;
		}
	}

	protected static function not_inValidation($input, $param, $name){
		$list=explode(',', $param);
		if(in_array($input, $list)){
			self::$errors[$name][]=$name.' is not allowed. Its contains '.$input;
			return false;
		}else{
			return true;
		}
	}

	protected static function imageValidation($input, $name){
		if(isset($_FILES[$name])){
			$supportedImage=array('jpg', 'jpeg', 'bmp', 'png', 'gif');
			$givenExt=pathinfo($input);
			$ext=@$givenExt['extension'];
			if(!in_array($ext, $supportedImage)){
				self::$errors[$name][]=$name." is contains no image";
				return false;
			}else{
				return true;
			}
		}else{
			self::$errors[$name][]=$name." is contains no image";
			return false;

		}
	}

	protected static function file_typeValidation($input, $param, $name){
		if(isset($_FILES[$name])){
			$supportedExt=explode(',', $param);
			$givenExt=pathinfo($input);
			$ext=@$givenExt['extension'];
			if(!in_array($ext, $supportedExt)){
				self::$errors[$name][]=$name." is contains no supported file type";
				return false;
			}else{
				return true;
			}
		}else{
			return false;

		}
	}


	protected static function sameValidation($input, $param, $name){
		if($input!==self::$inputs[$param]){
			self::$errors[$name][]=$name." is not match to ". $param;
			return false;
		}else{
			return true;
		}
	}

	protected static function differentValidation($input, $param, $name){
		if($input===self::$inputs[$param] OR $input==self::$inputs[$param]){
			self::$errors[$name][]=$name." is match to ". $param;
			return false;
		}else{
			return true;
		}
	}

	protected static function emailValidation($input, $name){
		
		if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
    	return true;
		}else{
			self::$errors[$name][]=$name." is not valid Email format!";
			return false;
		}

	}

	protected static function urlValidation($input, $name){
		if(filter_var($input, FILTER_VALIDATE_URL)){
			return true;
		}else{
			self::$errors[$name][]=$name." is not valid URL format!";
			return false;
		}
	}


	protected static function numericValidation($input, $name){
		if(is_numeric($input)){
			return true;
		}else{
			self::$errors[$name][]=$name." is not numeric value!";
			return false;	
		}
	}

	protected static function integerValidation($input, $name){
		if(is_numeric($input) AND strpos($input, '.')===false){
			if(is_integer((int)$input)){
				return true;
			}else{
				self::$errors[$name][]=$name." is not interger value!";
				return false;		
			}
			
		}else{
			self::$errors[$name][]=$name." is not interger value!";
			return false;	
		}
	}

	protected static function rangeValidation($input, $param, $name){
		$range=explode(",", $param);
		$length=strlen($input);
		if(($length>=$range[0]) && ($length<=$range[1])){
			return true;
		}else{
			self::$errors[$name][]=$name." must be between ".$range[0]." and ".$range[1];
			return false;
		}
	}

	protected static function patternValidation($input, $param, $name){
		if(preg_match($param, $input)){
			return true;
		}else{
			self::$errors[$name][]=$name." is not valid";
			return false;
		}
	}

	protected static function uniqueValidation($input, $param, $name){
		if($input==''){
			return false;
		}

		$dbs=explode(",", $param);

		//$query=Crud::select($dbs[0],"{$dbs[1]}", "{$dbs[1]}='{$input}'");

		//$query=mysql_query("SELECT {$dbs[1]} FROM {$dbs[0]} WHERE {$dbs[1]} ='{$input}'");
		$query=Crud::table($dbs[0])
		->where($dbs[1],'=', $input)
		->get(array($dbs[1]));

		if($query->getCount()>0){
			self::$errors[$name][]=$input." is already exist";
			return false;
		}else{
			return true;
		}
	}

	protected static function existValidation($input, $param, $name){
		if($input==''){
			return false;
		}

		$dbs=explode(",", $param);

		//$query=Crud::select($dbs[0],"{$dbs[1]}", "{$dbs[1]}='{$input}'");

		//$query=mysql_query("SELECT {$dbs[1]} FROM {$dbs[0]} WHERE {$dbs[1]} ='{$input}'");
		$query=Crud::table($dbs[0])
		->where($dbs[1],'=', $input)
		->get(array($dbs[1]));
		
		if($query->getCount()>0){
			return true;
		}else{
			self::$errors[$name][]="Sorry! ".$input." was not found!";
			return false;
		}
	}




	public static function validate(array $inputs, array $rules){

		//chech the param are exactly array
		if(is_array($inputs) && is_array($rules)){
			self::$inputs=$inputs;

			//contact the all elements of rules array
			foreach ($rules as $key => $val) {

			//split the variable $val to find out all rules 
				//and store all rules in $getRule variable

				$rule=explode("&", $val);
				foreach ($rule as $getRule) {

					//split the variable $getRules to find out its additional paramenter
					$param=explode(':', $getRule);

					$input=isset($inputs[$key])?$inputs[$key]:$_FILES[$key]['name'];
					
					if(count($param)>1){
						
						$method=$param[0]."Validation";
						self::$method($input,$param[1], $key);
					}else{
						$method=$getRule."Validation";
						self::$method($input, $key);
					}
				}
			}

			if(isset(self::$errors)){
				$_SESSION['_ap']['_validation']=self::$errors;
			}

			return self::_apInstance();
		}
	}

/*
*this function return is Error is occurd or not
*/
	public static function hasErrors(){
		if(!empty(self::$errors)){
			if(is_array(self::$errors)){
			if(count(self::$errors)>=1){
				return true;
			}else{
				return false;
			}
		}
		}elseif(isset($_SESSION['_ap']['_validation'])){
			if(count($_SESSION['_ap']['_validation'])>=1){
				return true;
			}else{
				return false;
			}
		}
		

}
/*
* this function is gather all errors in given field 
* if the error are occurd
*/
	public static function getErrors($fieldName){
		$errors=array();

		if(!empty(self::$errors)){
			if(array_key_exists($fieldName, self::$errors)){
			foreach(self::$errors[$fieldName] as $error){
			$errors[]=$error;
				}

				
			}
		}elseif(isset($_SESSION['_ap']['_validation'])){
			if(array_key_exists($fieldName, $_SESSION['_ap']['_validation'])){
				foreach ($_SESSION['_ap']['_validation'][$fieldName] as $err) {
					$errors[]=$err;
				}
			}
		}
		
	return $errors;
	}


/*
* this function is gather all errors in the validation
* if the error are occurd
*/

	public static function errorsAll(){
		$errors=array();
		if(!empty(self::$errors)){
			if(is_array(self::$errors)){
			foreach(self::$errors as $key=>$val){
				foreach (self::$errors[$key] as $err) {
					$errors[]=$err;
				}
			}
			}
		}elseif(isset($_SESSION['_ap']['_validation'])){
			foreach ($_SESSION['_ap']['_validation'] as $key => $val) {
				foreach ($_SESSION['_ap']['_validation'][$key] as $err) {
					$errors[]=$err;
				}
			}

			
		}
		return $errors;
	}


}
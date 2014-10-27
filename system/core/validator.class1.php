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


	protected function required($input, $name){
		if(empty($input)){
			self::$errors[$name][]=$name." is required field";
			return false;
		}else{
			return true;
		}
	}

	protected function min($input, $param, $name){
		$length=strlen($input);
		$min=(int)$param;
		if($length<$min){
			self::$errors[$name][]="The minimum length is for ".$name." is ".$param;
			return false;
		}else{
			return true;
		}
	}

	protected function max($input, $param, $name){
		$length=strlen($input);
		$max=(int)$param;
		if($length>$max){
			self::$errors[$name][]="The maximum length is for ".$name." is ".$param;
			return false;
		}else{
			return true;
		}
	}


	protected static function same($input, $param, $name){
		if($input!==self::$inputs[$param]){
			self::$errors[$name][]=$name." is not match to ". $param;
			return false;
		}else{
			return true;
		}
	}

	protected function email($input, $name){
		
		if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
    	return true;
		}else{
			self::$errors[$name][]=$name." is not valid Email format!";
			return false;
		}

	}

	protected function url($input, $name){
		if(filter_var($input, FILTER_VALIDATE_URL)){
			return true;
		}else{
			self::$errors[$name][]=$name." is not valid URL format!";
			return false;
		}
	}


	protected function numeric($input, $name){
		if(is_numeric($input)){
			return true;
		}else{
			self::$errors[$name][]=$name." is not numeric value!";
			return false;	
		}
	}

	protected function range($input, $param, $name){
		$range=explode(",", $param);
		if(((int)$input>=$range[0]) && ($input<=(int)$range[1])){
			return true;
		}else{
			self::$errors[$name][]=$name." must be between ".$range[0]." and ".$range[1];
			return false;
		}
	}

	protected function pattern($input, $param, $name){
		if(preg_match($param, $input)){
			return true;
		}else{
			self::$errors[$name][]=$name." is not valid";
			return false;
		}
	}

	protected function unique($input, $param, $name){
		$dbs=explode(",", $param);

		$query=Crud::select($dbs[0],"{$dbs[1]}", "{$dbs[1]}='{$input}'");
		if(mysql_num_rows($query)>0){
			self::$errors[$name][]=$input." is already exist in ".$name;
			return false;
		}else{
			return true;
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
					if(count($param)>1){
						self::$param[0]($inputs[$key],$param[1], $key);
					}else{
						self::$getRule($inputs[$key], $key);
					}
				}
			}
		}
	}

/*
*this function return is Error is occurd or not
*/
	public static function hasErrors(){
		if(is_array(self::$errors)){
			if(count(self::$errors)>=1){
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
		if(array_key_exists($fieldName, self::$errors)){
		foreach(self::$errors[$fieldName] as $error){
			$errors[]=$error;
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

		if(is_array(self::$errors)){
			foreach(self::$errors as $key=>$val){
				foreach (self::$errors[$key] as $err) {
					$errors[]=$err;
				}
			}

		return $errors;
		}
	}


}
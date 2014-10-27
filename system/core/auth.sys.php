<?php
class Auth extends Crud{
	function _construct(){
		
	}

	public static function login($table, $conditionData){
		$condion='';
		foreach($conditionData as $key => $val){
			if($condion==''){
				$condion=$key."=".self::makeType($val);
			}else{
				$condion.=" AND ".$key."=".self::makeType($val);
			}

		
		}
		self::$_query=self::$_db->query('SELECT * FROM '.TBL_PREFIX.$table." WHERE ".$condion);
		$counts=self::$_query->num_rows;

		if($counts>=1){
			$data=self::$_query->fetch_assoc();
			
			$fields=self::table($table)->getFields();

			foreach($fields->result() as $field){
			$_SESSION['_ap_']['_auth']['_'.$field->Field]=$data[$field->Field];
			}

			$_SESSION['_ap_']['_auth']['_token_']=md5(uniqid(1));

			return true;
			
		}else{
			return false;
		}
		

		
	}

	public static function getData($key){
		if(isset($_SESSION['_ap_']['_auth']['_'.$key])){
			return $_SESSION['_ap_']['_auth']['_'.$key];
		}else{
			return false;
		}
	}

	public static function hasData($key){
		if(isset($_SESSION['_ap_']['_auth']['_'.$key])){
			return true;
		}else{
			return false;
		}
	}

	public static function check(){
		if(isset($_SESSION['_ap_']['_auth']['_token_'])){
			return true;
		}else{
			return false;
		}
	}


	public static function setData($index=null, $val=''){
		if(($index!=null AND $val!='') or !is_array($index)){
			$_SESSION['_ap_']['_auth']['_'.$index]=$val;
			return true;
		}else if(is_array($index)){
			foreach($index as $key=>$val){
				$_SESSION['_ap_']['_auth']['_'.$key]=$val;
			}
			return true;
		}else{
			return false;
		}

	}


	public static function getToken(){
		if(isset($_SESSION['_ap_']['_auth']['_token_'])){
			return $_SESSION['_ap_']['_auth']['_token_'];
		}else{
			return false;
		}
	}

	public static function logout(){
		if(isset($_SESSION['_ap_'])){
			unset($_SESSION['_ap_']);
			return true;
		}else{
			return false;
		}
	}
}
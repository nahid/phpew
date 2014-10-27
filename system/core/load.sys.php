<?php
class Load{
	protected static $_obj='';
	protected static $_newinstance = null;

	protected static function _apInstance() {
		if (self::$_newinstance === null) {
			self::$_newinstance = new self;
		}

		return self::$_newinstance;
	}

	public static function lib($class=null){
		if(is_null($class)){
			return false;
		}

		try{
			if(file_exists(ROOT.DS."system".DS."vendor".DS.$class.".vnd.php")){
				require ROOT.DS."system".DS."vendor".DS.$class.".vnd.php";
			}else if(file_exists(ROOT.DS."system".DS."helper".DS.$class.".hlp.php")){
				require ROOT.DS."system".DS."helper".DS.$class.".hlp.php";
			}else{
				throw new Exception("Unable to import library!");
			}

			$class=ucfirst($class);
			self::$_obj=new $class();
			return self::$_obj;
		}catch(Exception $e){
			echo $e->getMessage(),"\n";
		}
		
	}

	public static function page($page=null, array $data=null){
		if(is_null($page)){
			return false;
		}

		if(!is_null($data)){
			foreach ($data as $key => $value) {
				$$key=$value;
			}
		}
		
		try{

			if(file_exists(ROOT.DS."app".DS."pages".DS.$page.".page.php")){
				require ROOT.DS."app".DS."pages".DS.$page.".page.php";
			}elseif(file_exists(ROOT.DS."app".DS."pages".DS.$page.".php")){
				require ROOT.DS."app".DS."pages".DS.$page.".php";
			}else{
				throw new Exception("Unable to load page!", 1);	
			}
				return true;
		}catch(Exception $e){
			echo $e->getMessage(), "\n";
		}


	}
}
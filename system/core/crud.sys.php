<?php
class Crud {
	public static $sql;

	/*constructor for Crud class
	 * $host : Local/Remote server
	 * $user : Database username, in local server default(root)
	 * $pwd : Password for Database system, in local server password default(null)
	 * $db : MySQL Database Name
	 *
	 * @retuen : database selection
	 */

	public static $_db;

	protected static $_sql = 'SELECT * FROM ';
	protected static $_query = null;
	protected static $_table = '';
	protected static $_result = null;
	protected static $_fields = array();
	protected static $_select='';
	protected static $_where = '';
	protected static $_sort='';
	
	
	

	protected static $_instance = null;

	function __construct($host = null, $user = null, $pwd = null, $db = null) {
		$server = is_null($host) ? HOST : $host;
		$username = is_null($user) ? USER : $user;
		$password = is_null($pwd) ? PWD : $pwd;
		$database = is_null($db) ? DB : $db;

		// connection for database server by using username and password

		self::$_db = new mysqli($server, $username, $password, $database);

		if (self::$_db -> connect_errno > 0) {
			die('Unable to connect with Database!');
		}

		self::$_db->query('SET CHARACTER SET utf8');
		self::$_db->query("SET SESSION collation_connection ='utf8_general_ci'");
	}

	protected static function _apInstance() {
		if (self::$_instance === null) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	protected static function makeType($var) {
		$numtype = array("integer", "double", "boolean");

		if (isset($var)) {
			$type = gettype($var);
			if (in_array($type, $numtype)) {
				return $var;
			} elseif ($type == "string") {

				return "'" . $var . "'";
			}
		}
	}

	protected static function makeSqlString(array $value) {
		if (is_array($value)) {
			$vals = '';
			foreach ($value as $key => $val) {
				end($value);
				if ($key === key($value)) {
					$vals .= self::makeType($val);
				} else {
					$vals .= self::makeType($val) . ', ';
				}
			}

			return $vals;
		}
	}

	/*

	 protected static function makeSqlSelectString(array $value){
	 if (is_array($value)) {
	 $vals = '';
	 foreach ($value as $key => $val) {
	 end($value);
	 if ($key === key($value)) {
	 $vals .= $val;
	 } else {
	 $vals .= $val . ', ';
	 }
	 }

	 return $vals;
	 }
	 }

	 */

	public static function table($table='') {
		try{
			if($table=='' OR empty($table)){
			 throw new Exception("Unexpected blank table, please try with table name<br/>", 1);
			 
			}	
		}catch(Exception $e){
			echo $e->getMessage(), "\n";
		}

		self::$_table = TBL_PREFIX . $table;
		self::$_sql.=self::$_table;
		return self::_apInstance();
	}

	public static function save(array $data){
		if(empty($data)){
			return false;
		}

		if(self::$_where==''){
			$fields=implode(',', array_keys($data));
			$values=self::makeSqlString($data);

			self::$_sql="INSERT INTO ".self::$_table."(".$fields.") VALUES(".$values.")";
		}else{
			$sqls='';
			foreach($data as $key=>$val){
				end($data);
				if($key===key($data)){
					$sqls.=$key."=".self::makeType($val);
				}else{
					$sqls.=$key."=".self::makeType($val).', ';
				}
			}

			self::$_sql="UPDATE ".self::$_table." SET ". $sqls. self::$_where;
		}

		self::$_query=self::$_db->query(self::$_sql);

		return self::$_query;
	}

	public static function delete(){
		if(self::$_where==''){
			return false;
		}

		self::$_sql="DELETE FROM ".self::$_table. self::$_where;

		self::$_query=self::$_db->query(self::$_sql);

		return self::$_query;
	}

	public function where($fields = '', $condition = '', $value = '') {
		if ($fields == '' OR $condition == '') {
			return false;
		}

		self::$_where .= self::$_where == '' ? " WHERE " . $fields . $condition . self::makeType($value) : " AND " . $fields . $condition . self::makeType($value);
		
		self::$_sql.=self::$_where;
		return $this;
	}

	public function orWhere($fields = '', $condition = '', $value = '') {
		if ($fields == '' OR $condition == '') {
			return false;
		}

		self::$_where .= self::$_where == '' ? " WHERE " . $fields . $condition . self::makeType($value) : " OR " . $fields . $condition . self::makeType($value);
		
		self::$_sql.=self::$_where;
		return $this;
	}

	public function all() {
		$result=array();
		
		if (self::$_where == '') {
			self::$_sql = "SELECT * FROM " . self::$_table.self::$_sort;
		} else {
			self::$_sql = "SELECT * FROM " . self::$_table . self::$_where.self::$_sort;
		}

		self::$_query = self::$_db -> query(self::$_sql);
		$x=array();
		while ($res = self::$_query -> fetch_object()) {
			$result[]=$res;
		}
		self::$_result=$result;

		return self::_apInstance();

	}

	public function get(array $fields) {
		$result=array();
		self::$_fields = implode(',', $fields);
		if (self::$_where == '') {
			self::$_sql = "SELECT " . self::$_fields . " FROM " . self::$_table.self::$_sort;
		} else {
			self::$_sql = "SELECT " . self::$_fields . " FROM " . self::$_table . self::$_where.self::$_sort;
		}

		self::$_query = self::$_db -> query(self::$_sql);
		while ($res = self::$_query -> fetch_object()) {
			$result[] = $res;
		}

		self::$_result=$result;

		return self::_apInstance();
	}
	
	public static function sortAs($field='', $order="ASC"){
		if($field==''){
			return false;
		}
		
		self::$_sort=" ORDER BY ".$field;
		self::$_sort.=" ". strtoupper($order);
		return self::_apInstance();
	}
	
	
	public static function getCount(){
		if(self::$_query===null){
		self::$_query=self::$_db->query(self::$_sql);
			
		}
		
		return self::$_query->num_rows;
	}
	
	
	public static function result(){
		if(is_null(self::$_result)){
			return false;
		}
		
		return self::$_result;
	}

	public static function nextId(){
		if(self::$_table==='' or is_null(self::$_table)){
			
			return false;

		}
		

		self::$_sql="SHOW TABLE STATUS WHERE name='".self::$_table."'";
		self::$_query=self::$_db->query(self::$_sql);
		
		self::$_result=self::$_query->fetch_object();
		try{
			if(!self::$_result){
				throw new Exception("Something went wrong! Please check your code<br/>", 1);
				
			}else{
				self::$_result=self::$_result->Auto_increment;
				return self::_apInstance();
			}
		}catch(Exception $e){
			echo $e->getMessage(), "\n";
		}
		
	}

	public static function getTables(){
		self::$_sql="SHOW TABLES";

		self::$_query = self::$_db -> query(self::$_sql);
		while ($res = self::$_query -> fetch_row()) {
			self::$_result[] = $res[0];
		}

		return self::_apInstance();
	}


	public static function getFields(){
		$result=array();

		if(self::$_table==''){
			return false;
		}

		self::$_sql="SHOW COLUMNS IN ".self::$_table;
		self::$_query = self::$_db -> query(self::$_sql);
		while ($res = self::$_query -> fetch_object()) {
			$result[]=$res;
		}

		self::$_result=$result;

		return self::_apInstance();
	}




	public function getQueryString(){
		if(self::$_sql==''){
			return false;
		}

		return self::$_sql;
	}


	
	


}

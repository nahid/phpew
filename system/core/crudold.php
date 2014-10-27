<?php
class Crud {
	public static $sql;

	/*constructor for Crud class
	 * $host	: Local/Remote server
	 * $user	: Database username, in local server default(root)
	 * $pwd		: Password for Database system, in local server password default(null)
	 * $db 		: MySQL Database Name
	 *
	 * @retuen 	: database selection
	 */
		function __construct($host = null, $user = null, $pwd = null, $db = null) {
		$server = is_null($host) ? HOST : $host;
		$username = is_null($user) ? USER : $user;
		$password = is_null($pwd) ? PWD : $pwd;
		$database = is_null($db) ? DB : $db;

		// connection for database server by using username and password

		$con = mysql_connect($server, $username, $password) or die("Database connection failed!");
		if ($con) {

			// select database that you wants

			$selDb = mysql_select_db($database) or die("Invalid database source!");
			mysql_query('SET CHARACTER SET utf8');
			mysql_query("SET SESSION collation_connection ='utf8_general_ci'") or die (mysql_error()); 
		}

		if ($selDb) {
			return $selDb;
		}

	}

	private static function make_type($var) {
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

	private static function make_sql_string(array $value) {
		if (is_array($value)) {
			$vals = '';
			foreach ($value as $key => $val) {
				end($value);
				if ($key === key($value)) {
					$vals .= self::make_type($val);
				} else {
					$vals .= self::make_type($val) . ', ';
				}
			}

			return $vals;
		}
	}

	public static function insert($tbl, array $value) {
		if (is_array($value)) {
			$field = implode(',', array_keys($value));
			$vals = self::make_sql_string($value);

			if (isset($field) and isset($vals)) {
				$sql = "INSERT INTO " . TBL_PREFIX . $tbl . "(" . $field . ") VALUES (" . $vals . ")";
				$query = mysql_query($sql);
			}

			return $query;
		}
	}

	public static function selectAll($tbl, $condition = null) {
		if ($condition == null) {
			$sql = mysql_query("select * from " . TBL_PREFIX ."{$tbl}");
		} else {
			$sql = mysql_query("select * from " . TBL_PREFIX ."{$tbl} where {$condition}");
		}
		return $sql;
	}

	public static function select($tbl, $field, $condition = null) {
		if ($condition == null) {
			$sql = mysql_query("select {$field} from " . TBL_PREFIX ."{$tbl}");
		} else {
			$sql = mysql_query("select {$field} from " . TBL_PREFIX ."{$tbl} where {$condition}");
		}
		return $sql;
	}

	public static function update($tbl, array $string, $condition=null) {
		$str='';
		if (is_array($string)) {
			foreach($string as $key=>$val){
				end($string);
				if ($key === key($string)) {
					$str.=$key."=".self::make_type($val);
				} else {
					$str.=$key."=".self::make_type($val) . ', ';
				}
				
			}
			$condition=is_null($condition)?"":" WHERE {$condition}";
			$sql = mysql_query("update ".TBL_PREFIX."{$tbl} set {$str}{$condition}");
		}
		
		return $sql;
	}

	public static function delete($tbl, $condition = null) {
		if ($condition == null) {
			$sql = mysql_query("delete from " . TBL_PREFIX ."{$tbl}");
		} else {
			$sql = mysql_query("delete from " . TBL_PREFIX ."{$tbl} where {$condition}");
		}
		return $sql;
	}
	
	
	public static function next_auto_id($tbl){
	$sql=mysql_query("SHOW TABLE STATUS WHERE name='".TBL_PREFIX."{$tbl}'");
		
		$a_i=mysql_fetch_object($sql);
		
		return $a_i->Auto_increment;

	}

	public static function valid() {
		$sql = self::$sql;
		$valid = mysql_num_rows($sql);
		if ($valid > 0) {
			return true;
		} else {
			return false;
		}

	}

	public static function query($sql) {
		$query = mysql_query($sql);
		return $query;
	}


	public static function backupTables($tables = '*')
{

    
    //get all of the tables
    if($tables == '*')
    {
        $tables = array();
        $result = mysql_query('SHOW TABLES');
        while($row = mysql_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }
    else
    {
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }
    
    //cycle through
    foreach($tables as $table)
    {
        $result = mysql_query('SELECT * FROM '.$table);
        $num_fields = mysql_num_fields($result);
        
        $return.= 'DROP TABLE '.$table.';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";
        
        for ($i = 0; $i < $num_fields; $i++) 
        {
            while($row = mysql_fetch_row($result))
            {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++) 
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }
    
    //save file
  
//add below code to download it as a sql file
Header('Content-type: application/octet-stream');
Header('Content-Disposition: attachment; filename=db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql');
echo $return;
}

function backupTable($tables = '*')
{
  //get all of the tables
  if($tables == '*')
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');

    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];

    }
  }
  else
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }

  //cycle through
  foreach($tables as $table)
  {
    $return="";
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
    //print_r($num_fields);exit;
    $return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";

    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysql_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
         // $row[$j] = preg_replace("\n","\\n",$row[$j]);

          $row[$j] = preg_replace("/(\n){2,}/", "\\n", $row[$j]); 

          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";

  }

  //save file
  //add below code to download it as a sql file
Header('Content-type: application/octet-stream');
Header('Content-Disposition: attachment; filename=db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql');
echo $return;

}

}
?>
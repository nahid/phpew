<?php
/*
class PrivilegedUser extends Role
{
    private $roles;

    public function __construct() {
        parent::__construct();
    }

    // override User method
    public static function getByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username";
		
        $sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":username" => $username));
        $result = $sth->fetchAll();

        if (!empty($result)) {
            $privUser = new PrivilegedUser();
            $privUser->user_id = $result[0]["user_id"];
            $privUser->username = $username;
            $privUser->password = $result[0]["password"];
            $privUser->email_addr = $result[0]["email_addr"];
            $privUser->initRoles();
            return $privUser;
        } else {
            return false;
        }
    }

    // populate roles with their associated permissions
    protected function initRoles() {
        $this->roles = array();
        $sql = "SELECT t1.role_id, t2.role_name FROM user_role as t1
                JOIN roles as t2 ON t1.role_id = t2.role_id
                WHERE t1.user_id = :user_id";
        $sth = $GLOBALS["DB"]->prepare($sql);
        $sth->execute(array(":user_id" => $this->user_id));

        while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->roles[$row["role_name"]] = Role::getRolePerms($row["role_id"]);
        }
    }

    // check if user has a specific privilege
    public function hasPrivilege($perm) {
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
}
*/
class Privilegeduser{

	public static function isAccess($role, $area) {
		$crud = new Crud(HOST, USER, PWD, DB);
		if(@$_SESSION['login']){
			$sql = Crud::query("select perm_id from tbl_permissions where perm_desc='{$area}'");

		$getPerm = mysql_fetch_assoc($sql);

		$chkperm = mysql_num_rows($sql);

		$sql = Crud::query("select role_id from tbl_roles where role_name='{$role}'");

		$chkrole = mysql_num_rows($sql);

		$getRole = mysql_fetch_assoc($sql);


		if ($chkperm >0 and $chkrole >0) {
			$sql = Crud::query("select role_id, perm_id  from tbl_role_perm where role_id={$getRole['role_id']} and perm_id={$getPerm['perm_id']}");
			if (mysql_num_rows($sql) > 0) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		}else{
			return false;
		}
	}

}
?>
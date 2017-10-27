<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Role.php';

class PrivilegedUser extends User
{
    private $roles;

    public function __construct()
    {
        parent::__construct();
    }

    // override User method
    public static function getByUsername($username)
    {
        $db = new Database();

        $sql = "SELECT user_id, username, email, created_on FROM users WHERE username = :username";
        $sth = $db->conn->prepare($sql);
        $sth->execute(array(":username" => $username));
        $result = $sth->fetchAll();

        if (!empty($result)) {
            $privUser = new PrivilegedUser();
            $privUser->user_id = $result[0]["user_id"];
            $privUser->username = $username;
            $privUser->email = $result[0]["email"];
            $privUser->created_on = $result[0]["created_on"];
            $privUser->initRoles();
            return $privUser;
        }
        return false;
    }

    // populate roles with their associated permissions
    protected function initRoles()
    {
        $db = new Database();

        $this->roles = array();
        $sql = "SELECT t1.role_id, t2.role_name FROM user_role AS t1
                JOIN roles AS t2 ON t1.role_id = t2.role_id
                WHERE t1.user_id = :user_id";
        $sth = $db->conn->prepare($sql);
        $sth->execute(array(":user_id" => $this->user_id));

        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $this->roles[$row["role_name"]] = Role::getRolePerms($row["role_id"]);
        }
    }

    // check if user has a specific privilege
    public function hasPrivilege($perm)
    {
        foreach ($this->roles as $role) {
            foreach ($role as $key => $value) {
                if (isset($value[$perm])) {
                    return true;
                }
            }
        }
        return false;
    }

    // check if a user has a specific role
    public function hasRole($role_name)
    {
        return isset($this->roles[$role_name]);
    }

    // insert a new role permission association
    public static function insertPerm($role_id, $perm_id)
    {
        $db = new Database();

        $sql = "INSERT INTO role_perm (role_id, perm_id) VALUES (:role_id, :perm_id)";
        $sth = $db->conn->prepare($sql);
        return $sth->execute(array(":role_id" => $role_id, ":perm_id" => $perm_id));
    }

    // delete ALL role permissions
    public static function deletePerms()
    {
        $db = new Database();

        $sql = "TRUNCATE role_perm";
        $sth = $db->conn->prepare($sql);
        return $sth->execute();
    }
}
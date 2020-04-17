<?php
require_once 'Database.php';

class Role
{
    public $permissions;

    protected function __construct()
    {
        $this->permissions = array();
    }

    // return a role object with associated permissions
    public static function getRolePerms($role_id)
    {
        $db = new Database();

        $role = new Role();
        $sql = "SELECT t2.perm_desc FROM role_perm AS t1
                JOIN permissions AS t2 ON t1.perm_id = t2.perm_id
                WHERE t1.role_id = :role_id";
        $sth = $db->conn->prepare($sql);
        $sth->execute(array(":role_id" => $role_id));

        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $role->permissions[$row["perm_desc"]] = true;
        }
        return $role;
    }

    // check if a permission is set
    public function hasPerm($permission)
    {
        return isset($this->permissions[$permission]);
    }

    // check if role already exist
    private static function hasRole($role_name)
    {
        $db = new Database();

        $sql = "SELECT count(role_id) AS role_count, role_id FROM roles WHERE role_name = :role_name";
        $sth = $db->conn->prepare($sql);
        $sth->execute(array(":role_name" => $role_name));

        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            if ($row["role_count"] > 0) {
                return true;
            }
        }
        return false;
    }

    // insert a new role
    public static function insertRole($role_name)
    {
        if (!self::hasRole($role_name)) {
            $db = new Database();

            $sql = "INSERT INTO roles (role_name) VALUES (:role_name)";
            $sth = $db->conn->prepare($sql);
            return $sth->execute(array(":role_name" => $role_name));
        }
        return false;
    }

    // insert array of perms for specified role id
    public static function insertRolePerms($role_id, $perm_ids) {
        $db = new Database();

        $values = array();
        foreach ($perm_ids as $perm_id) {
            $_value = "(" . $role_id . "," . $perm_id . ")";
            array_push($values, $_value);
        }
        $values_ = implode(",", $values);

        $sql = "INSERT INTO role_perm (role_id, perm_id) VALUES " . $values_;
        $sth = $db->conn->prepare($sql);
        $sth->execute();
        return $sth->rowCount();
    }

    // insert array of roles for specified user id
    public static function insertUserRoles($user_id, $roles)
    {
        $db = new Database();

        $values = array();
        foreach ($roles as $role_id) {
            $_value = "(" . $user_id . "," . $role_id . ")";
            array_push($values, $_value);
        }
        $values_ = implode(",", $values);

        $sql = "INSERT INTO user_role (user_id, role_id) VALUES " . $values_;
        $sth = $db->conn->prepare($sql);
        $sth->execute();
        return $sth->rowCount();
    }

    // delete array of roles, and all associations
    public static function deleteRoles($roles)
    {
        $db = new Database();

        $sql = "DELETE t1, t2, t3 FROM roles AS t1
            JOIN user_role AS t2 ON t1.role_id = t2.role_id
            JOIN role_perm AS t3 ON t1.role_id = t3.role_id
            WHERE t1.role_id = :role_id";
        $sth = $db->conn->prepare($sql);
        $sth->bindParam(":role_id", $role_id, PDO::PARAM_INT);
        foreach ($roles as $role_id) {
            $sth->execute();
        }
        return true;
    }

    // delete ALL roles for specified user id
    public static function deleteUserRoles($user_id)
    {
        $db = new Database();

        $sql = "DELETE FROM user_role WHERE user_id = :user_id";
        $sth = $db->conn->prepare($sql);
        return $sth->execute(array(":user_id" => $user_id));
    }
}
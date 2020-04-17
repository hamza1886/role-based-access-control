<?php
require_once 'Database.php';

class Permission
{

    // check if permission already exist
    private static function hasPerm($perm_desc)
    {
        $db = new Database();

        $sql = "SELECT count(perm_id) AS perm_count, perm_id FROM permissions WHERE perm_desc = :perm_desc";
        $sth = $db->conn->prepare($sql);
        $sth->execute(array(":perm_desc" => $perm_desc));

        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            if ($row["perm_count"] > 0) {
                return true;
            }
        }
        return false;
    }

    // insert a new permission
    public static function insertPerm($perm_desc)
    {
        if (!self::hasPerm($perm_desc)) {
            $db = new Database();

            $sql = "INSERT INTO permissions (perm_desc) VALUES (:perm_desc)";
            $sth = $db->conn->prepare($sql);
            return $sth->execute(array(":perm_desc" => $perm_desc));
        }
        return false;
    }

    // delete array of permissions
    public static function deletePerms($permissions)
    {
        $db = new Database();

        $sql = "DELETE t1 FROM permissions AS t1 WHERE t1.perm_id = :perm_id";
        $sth = $db->conn->prepare($sql);
        $sth->bindParam(":perm_id", $perm_id, PDO::PARAM_INT);
        foreach ($permissions as $perm_id) {
            $sth->execute();
        }
        return true;
    }

}
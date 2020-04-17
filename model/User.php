<?php
require_once 'Database.php';

class User
{
    public $user_id;
    public $username;
    public $email;
    public $created_on;

    public function __construct()
    {

    }

    public static function add($username, $password, $email)
    {
        $db = new Database();

        $sql = "SELECT count(user_id) AS count, user_id FROM users WHERE username = :username";
        $sth = $db->conn->prepare($sql);
        $sth->execute(array(":username" => $username));
        $result = $sth->fetchAll();

        if (!empty($result) && $result[0]["count"] === 0) {
            $sql2 = "INSERT INTO users (username, password, email) VALUES (:username, SHA2(:password, 512), :email)";
            $sth2 = $db->conn->prepare($sql2);
            $sth2->execute(array(":username" => $username, ":password" => $password, ":email" => $email));
            return $sth->rowCount();
        } else {
            return false;
        }
    }

    public static function deleteByUsername($username)
    {
        $db = new Database();

        $sql = "DELETE FROM users WHERE username = :username";
        $sth = $db->conn->prepare($sql);
        $sth->execute(array(":username" => $username));
        return $sth->rowCount();
    }

    public static function deleteByEmail($email)
    {
        $db = new Database();

        $sql = "DELETE FROM users WHERE email = :email";
        $sth = $db->conn->prepare($sql);
        $sth->execute(array(":email" => $email));
        return $sth->rowCount();
    }

    protected static function getByUsername($username)
    {
        $db = new Database();

        $sql = "SELECT user_id, username, email, created_on FROM users WHERE username = :username";
        $sth = $db->conn->prepare($sql);
        $sth->execute(array(":username" => $username));
        $result = $sth->fetchAll();

        if (!empty($result)) {
            $user = new User();
            $user->user_id = $result[0]["user_id"];
            $user->username = $username;
            $user->email = $result[0]["email"];
            return $user;
        } else {
            return false;
        }
    }

    public static function validate($email, $password)
    {
        $db = new Database();

        $sql = "SELECT user_id, username, email, created_on FROM users WHERE email = '$email' AND password = SHA2('$password', 512)";
        $sth = $db->conn->prepare($sql);
        $sth->execute(array(":email" => $email, ":password" => $password));
        $result = $sth->fetchAll();

        if (!empty($result)) {
            $user = new User();
            $user->user_id = $result[0]["user_id"];
            $user->username = $result[0]["username"];
            $user->email = $result[0]["email"];
            $user->created_on = $result[0]["created_on"];
            return $user;
        }
        return false;
    }
}

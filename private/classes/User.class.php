<?php
/**
 * Class user of admin panel
 */

class User
{
    function userLogin($username, $password)
    {
        require_once 'Db.class.php';
        $username = htmlentities($_POST['username']);
        $password = hash('sha1', ($_POST['password']));
        if (!empty($username) && !empty($password)) {
            $db = new Db;
            $db = $db->getConnected();
            $query = $db->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->execute();
            $row = $query->fetch(PDO::FETCH_OBJ);
            $query = null;
            if (!empty($row->username)) {
                $_SESSION['Auth'] = array(
                    'id' => $row->id,
                    'username' => $row->username,
                    'password' => $row->password,
                    'role' => $row->role
                );
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
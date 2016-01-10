<?php
/**
 * Connect to database with PDO
 */

class Db
{
    function getConnected()
    {
        $init = new Init;
        try {
            $db_pdo = new PDO('mysql:host=' . $init::_DB_DSN . ';dbname=' . $init::_DB_NME, $init::_DB_USR, $init::_DB_PWD);
        } catch (PDOException $e) {
            $er = $e->getMessage();
            echo '<div style="text-align:center;font-size:25px;font-family:calibri;opacity:0.6">Database connexion error</div>';
            exit();
        }
        $db_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db_pdo;
    }
}
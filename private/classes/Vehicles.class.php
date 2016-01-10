<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/01/2016
 * Time: 17:36
 */

class Vehicles {
    function deleteVehicle($id){
        require_once '../../public/config.php';
        require_once 'Auth.class.php';
        require_once 'Db.class.php';

        if ((Auth::isModo() == false && Auth::isAdmin() == false)){
            header('HTTP/1.0 401 Unauthorized');
            exit('Grant access required !');
        }

        $db = new Db;
        $db = $db->getConnected();

        if(is_numeric($id) == false){
            header('HTTP/1.0 401 Unauthorized');
            exit('Not a number !');
        }

        $query = $db->prepare("DELETE FROM vehicles WHERE id = :id");
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $query = null;

        echo json_encode(array("id" => $id, "status" => "ok"));
    }
}
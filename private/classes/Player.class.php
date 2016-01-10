<?php
/**
 * Class player of server
 */

class Player
{
    function getListing($min, $max)
    {
        require_once 'Db.class.php';
        $db = new Db;
        $db = $db->getConnected();
        $query = "SELECT DISTINCT name, playerid, donatorlvl, cash, bankacc, duredon, coplevel, adminlevel FROM players ORDER BY rand() LIMIT ".$min.", ".$max;
        $query = $db->query($query);

        /* SEEMS NOT WORKING (PDO / MYSQL VERSION ?)
        $query = $db->query("SELECT DISTINCT name, playerid, donatorlvl, cash, bankacc, duredon, coplevel, adminlevel FROM players ORDER BY rand() LIMIT :min, :max");
        $query->bindValue(':min', intval($min), PDO::PARAM_INT);
        $query->bindValue(':max', intval($max), PDO::PARAM_INT);
        */

        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    function getInfos($id)
    {
        require_once 'Db.class.php';
        $db = new Db;
        $db = $db->getConnected();

        $query = $db->prepare("SELECT * FROM players WHERE playerid = :pid");
        $query->bindParam(':pid', $id, PDO::PARAM_INT);
        $query->execute();
        $datas = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = null;

        $query = $db->prepare("SELECT * FROM vehicles WHERE pid = :pid");
        $query->bindParam(':pid', $id, PDO::PARAM_INT);
        $query->execute();
        $vehicles = $query->fetchAll(PDO::FETCH_ASSOC);
        $query = null;

        if(empty($vehicles)){$vehicles = null;}

        // Pseudo
        $reg = array("\"", "`", "[", "]", "Error: No unit ,", "Error: No unit");
        $pseudo = str_replace($reg, " ", $datas[0]['aliases']);

        // Licenses
        $reg = array("\"", "`", "[", "]");
        $licences = str_replace($reg, "", $datas[0]['civ_licenses']);
        $licences = preg_split("/,/", $licences);
        $liformat = array();

        for($i = 0; $i < count($licences); $i++) {
            // Pair
            if ($i % 2 == 0) {
                $arr_pair[] = $licences[$i];
            } else {
                $arr_imp[] = $licences[$i];

            }
        }

        foreach ($arr_pair as $name) {
            $liformat[] = array("name" => $name, "status" => array_combine($arr_pair,$arr_imp)[$name]);
        }

        $datas = [
            "aliases" => $pseudo,
            "other" => $datas,
            "licenses" => $liformat,
            "vehicles" => $vehicles
        ];

        return $datas;
    }

    function getSearch($search)
    {
        if(!empty($search)){
            require_once 'Db.class.php';
            $db = new Db;
            $db = $db->getConnected();

            $query = $db->prepare("SELECT DISTINCT  name, playerid, donatorlvl, cash, bankacc, duredon, coplevel, adminlevel FROM players WHERE name LIKE :search OR playerid LIKE :search OR aliases LIKE :search");
            $query->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
            $query->execute();
            $datas = $query->fetchAll(PDO::FETCH_ASSOC);
            $query = null;


        }else{
            $datas = null;
        }

        return $datas;
    }

    function updateLicenses($status, $pid, $id){
        require_once '../../public/config.php';
        require_once 'Auth.class.php';
        require_once 'Db.class.php';

        if ((Auth::isModo() == false && Auth::isAdmin() == false)){
            header('HTTP/1.0 401 Unauthorized');
            exit('Grant access required !');
        }

        $db = new Db;
        $db = $db->getConnected();

        if(is_numeric($status) == false || is_numeric($pid) == false){
            header('HTTP/1.0 401 Unauthorized');
            exit('Not a number !');
        }

        if($status == 0){
            $status = $status + 1;
        }else{
            $status = $status - 1;
        }

        // Get civ_licenses content for PID
        $query = $db->prepare("SELECT civ_licenses FROM players WHERE playerid =  :pid");
        $query->bindValue(':pid', $pid, PDO::PARAM_INT);
        $query->execute();
        $rows = $query->fetch(PDO::FETCH_OBJ);
        $query = null;

        // Parse regex
        $suppr = array("\"", "`", "[", "]");
        $lineLicenses = str_replace($suppr, "", $rows->civ_licenses);
        $arrayLicenses = preg_split("/,/", $lineLicenses);
        $totarrayLicenses = count($arrayLicenses);
        $y=0;
        $n=0;

        // Build content of SQL query for civ_licenses on table players
        for($i=1; $y < $totarrayLicenses; $i++){
            // Start
            if($n == $id && $y == 0){
                $fdp_arma[] = "\"[[`".$arrayLicenses[$y]."`,".$status."],";
            }elseif($n == 0 && $id !== $n){
                $fdp_arma[] = "\"[[`".$arrayLicenses[$y]."`,".$arrayLicenses[$i]."],";
            }

            // Middle
            if($n == $id && $n !== 0 && $y !== ($totarrayLicenses-2)){
                $fdp_arma[] = "[`".$arrayLicenses[$y]."`,".$status."],";
            }elseif($n !== $id && $y !== 0 && $y !== ($totarrayLicenses-2)){
                $fdp_arma[] = "[`".$arrayLicenses[$y]."`,".$arrayLicenses[$i]."],";
            }

            // End
            if($n == $id && $y == ($totarrayLicenses-2)){
                $fdp_arma[] = "[`".$arrayLicenses[$y]."`,".$status."]]\"";
            }elseif($n !== $id && $y == ($totarrayLicenses-2)){
                $fdp_arma[] = "[`".$arrayLicenses[$y]."`,".$arrayLicenses[$i]."]]\"";
            }

            $y=$y+2;
            $i=$i+1;
            $n=$n+1;
        }

        // Array to string
        $civ_licenses = implode($fdp_arma);

        $query = $db->prepare("UPDATE players SET civ_licenses = :licenses WHERE playerid = :pid");
        $query->bindParam(':licenses', $civ_licenses, PDO::PARAM_STR);
        $query->bindValue(':pid', $pid, PDO::PARAM_INT);
        $query->execute();
        $query = null;

        // Return ajax
        echo json_encode(array('status' => $status, 'id' => $id, 'pid' => $pid));
    }
}
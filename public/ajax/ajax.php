<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 10/01/2016
 * Time: 00:31
 */

require_once '../../private/classes/Auth.class.php';
require_once '../../private/classes/Player.class.php';

// Security
if ((Auth::isModo() == false && Auth::isAdmin() == false)){
    header('HTTP/1.0 401 Unauthorized');
    exit('Grant access required !');
}

// Routes
switch($_GET['op']) {
    case 'update_civ_licenses':
        $p = new Player();
        $p->updateLicenses($_POST['status'], $_POST['pid'], $_POST['id']);
        break;
}
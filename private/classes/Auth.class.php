<?php
/**
 * Class authentication
 */
session_start();

class Auth
{
    static function isLogged()
    {
        if (isset($_SESSION['Auth']['id']) && isset($_SESSION['Auth']['username']) && isset($_SESSION['Auth']['password']) && isset($_SESSION['Auth']['role'])) {
            return true;
        } else {
            return false;
        }
    }

    static function isAdmin()
    {
        if (isset($_SESSION['Auth']['id']) && isset($_SESSION['Auth']['username']) && isset($_SESSION['Auth']['password']) && isset($_SESSION['Auth']['role'])) {
            if ($_SESSION['Auth']['role'] == 3) {
                return true;
            } else {
                return false;
            }
        }
    }

    static function isModo()
    {
        if (isset($_SESSION['Auth']['id']) && isset($_SESSION['Auth']['username']) && isset($_SESSION['Auth']['password']) && isset($_SESSION['Auth']['role'])) {
            if ($_SESSION['Auth']['role'] == 2) {
                return true;
            } else {
                return false;
            }
        }
    }

    static function isGuest()
    {
        if (isset($_SESSION['Auth']['id']) && isset($_SESSION['Auth']['username']) && isset($_SESSION['Auth']['password']) && isset($_SESSION['Auth']['role'])) {
            if ($_SESSION['Auth']['role'] == 1) {
                return true;
            } else {
                return false;
            }
        }
    }
}
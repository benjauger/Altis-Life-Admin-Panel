<?php
/*
 * Altis Life Admin Panel
 * Made with love by @bloodmotion (@gamewave)
 * Based on Slim PHP framework & Twig tpl engine
 * Hack it, use it and improve it freely ;-)
 *
 */

/**
 * Step 1: Launch a Composer pre-require
 */
require_once '../vendor/autoload.php';

/**
 * Step 2 : Get the current configuration
 */
require_once 'config.php';

/**
 * Step 3 : Check authentication status
 */
require_once '../private/classes/Auth.class.php';

/**
 * Step 4: Instantiate a Slim app and his config
 */
require_once '../private/init.php';

/**
 * Step 5 : Init Twig template engine
 */
require_once '../private/tpl.php';

/**
 * Step 6: Define the Slim application routes
 */
require_once '../private/routes.php';

/**
 * Step 7: Run the Slim application
 */
$app->run();
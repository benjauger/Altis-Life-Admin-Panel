<?php
/**
 * Get the value from config file
 */
$init = new Init;

/**
 * Set configuration to Slim
 */
$configuration = [
    'settings' => [
        // Developement value, set to false on production (cf config.php) /!\
        'displayErrorDetails' => $init::_SLIM_ERR,
    ],
];
$c = new Slim\Container($configuration);

/**
 * Instantiate a Slim application
 */
$app = new Slim\App($c);
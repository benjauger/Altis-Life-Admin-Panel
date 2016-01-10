<?php
/**
 * Init the twig templating engine
 */

// Get the config
$init = new Init;

// Get container
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new Slim\Views\Twig('tpl/', [
        'cache' => false // $init::_TWIG_CHE not working - set '../private/cache/' to active twig cache
    ]);
    $view->addExtension(new Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
    return $view;
};

// Custom vars
$twig = $container->view->getEnvironment();

$twig->addGlobal('current_url', $_SERVER["REQUEST_URI"]);
$twig->addGlobal('is_logged', Auth::isLogged());
if(isset($_SESSION['Auth']['role'])){
    $twig->addGlobal('logged_role', $_SESSION['Auth']['role']);
}else{
    $twig->addGlobal('logged_role', null);
}

// Cop level
$twig->addGlobal('at_cop', array(
    '0' => $init::_AT_COP_0,
    '1' => $init::_AT_COP_1,
    '2' => $init::_AT_COP_2,
    '3' => $init::_AT_COP_3,
    '4' => $init::_AT_COP_4,
    '5' => $init::_AT_COP_5,
    '6' => $init::_AT_COP_6,
    '7' => $init::_AT_COP_7
));
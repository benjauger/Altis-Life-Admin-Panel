<?php
/**
 * Routes
 */

// Home page
$app->get('/', function ($request, $response, $args) {
    if (!Auth::isLogged()) {
        return $response->withRedirect('/login');
    } else {
        require_once '../private/classes/Player.class.php';

        $datas = new Player;
        $datas = $datas->getListing(0,10);

        return $this->view->render($response, 'index.html', [
            'head_title' => "Home",
            'logged_status' => true,
            'datas' => $datas
        ]);
    }
});

// Login page
$app->map(['GET', 'POST'], '/login', function ($request, $response, $args) {
    if (!Auth::isLogged()) {
        if ($request->isPost()) {
            require_once '../private/classes/User.class.php';
            $co = new User;
            $return = $co->userLogin($_POST['username'], $_POST['password']);
            if ($return == true) {
                return $response->withRedirect('/');
            } else {
                return $this->view->render($response, 'login.html', [
                    'head_title' => "Login",
                    'login_error' => true

                ]);
            }
        } else {
            return $this->view->render($response, 'login.html', [
                'head_title' => "Login"
            ]);
        }
    } else {
        return $response->withRedirect('/');
    }
})->setName('login');

// Logout page
$app->get('/logout', function ($request, $response, $args) {
    if (Auth::isLogged()) {
        $_SESSION['Auth'] = array();
        session_destroy();
        return $response->withRedirect('/login');
    }else{
        return $response->withRedirect('/login');
    }
})->setName('login');

// Player profile
$app->get('/player/{id}', function ($request, $response, $args) {
    if (!Auth::isLogged()) {
        return $response->withRedirect('/login');
    } else {
        require_once '../private/classes/Player.class.php';

        $datas = new Player;
        $datas = $datas->getInfos($args['id']);

        //echo json_encode($datas);
        //exit;

        return $this->view->render($response, 'player.html', [
            'head_title' => "Player profil",
            'p_id' => $datas['other'][0]['playerid'],
            'p_uid' => $datas['other'][0]['uid'],
            'p_name' => $datas['other'][0]['name'],
            'p_aliases' => $datas['aliases'],
            'p_licenses' => $datas['licenses'],
            'p_vehicles' => $datas['vehicles'],
            'datas' => $datas['other']
        ]);
    }
})->setArgument('id', null);

// Search
$app->map(['GET', 'POST'], '/search[/{searchquery}]', function ($request, $response, $args) {
    if (!Auth::isLogged()) {
        return $response->withRedirect('/login');
    } else {
        if ($request->isPost()) {
            // Post to get
            return $response->withRedirect('/search/'.$_POST['searchquery']);
        }
        require_once '../private/classes/Player.class.php';

        $datas = new Player;
        $datas = $datas->getSearch($args['searchquery']);

        return $this->view->render($response, 'search.html', [
            'head_title' => "Search results",
            'query' => mb_strimwidth($args['searchquery'], 0, 45, "..."),
            'datas' => $datas
        ]);
    }
})->setName('search');
<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

$container['db'] = function($container){
    $getSettings = $container->get('settings')['db'];
    //$mysqli = new mysqli($getSettings['host'],$getSettings['user'],$getSettings['password'],$getSettings['database']);
    //return $mysqli;
    var_dump($app);die();
    $db = new PDO("mysql:host=" . $getSettings['host'] . ";dbname=" . $getSettings['database'],$getSettings['username'],$getSettings['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $db;
};

/**
$container['db'] = function($container){
    $getSettings = $container->get('settings')['db'];
    $mysqli = new mysqli($getSettings['host'],$getSettings['user'],$getSettings['password'],$getSettings['database']);
    return $mysqli;
};
*/

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';


// Run app
$app->run();

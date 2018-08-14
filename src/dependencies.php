<?php

// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['db'] = function($c){
    $getSettings = $c->get('settings')['db'];
    $mysqli = new mysqli("localhost","root","","slim");
    return $mysqli;
    //var_dump($getSettings);die();
    //$db = new PDO("mysql:host=localhost;dbname=slim","root","");
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    //return $db;
};

// $container['db'] = function($c){ 
//     //setup NOTORM
//     $db = $c['settings']['db'];
//     $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['slim'], $db['user'], $db['password']);
//     // $db = new ($pdo);
//     $db->debug = true;
//     return $db;
// };

$container['AdController'] = function($c){
	$adController =  new classes\Controller\AdController($c);
    return 	$adController;
};

/**
$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};
*/
/**
$container[App\WidgetController::class] = function ($c) {
    $view = $c->get('view');
    $logger = $c->get('logger');
    $table = $c->get('db')->table('table_name');
    return new \App\WidgetController($view, $logger, $table);
};
*/
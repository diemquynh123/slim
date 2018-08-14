<?php

$app->get('/',\AdController::class . ':index');
$app->get('/blog',\AdController::class . ':blog');
$app->get('/login',\AdController::class . ':getLogin');
$app->post('/login',\AdController::class . ':postLogin');

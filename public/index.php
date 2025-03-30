<?php 
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->setBasePath('/php-practice/api restful/public');

$app->get('/hello', function ($req, $res, $args) {
    $res->getBody()->write("Hello, world!");
    return $res;
});

$app -> run();
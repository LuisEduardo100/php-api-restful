<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$container = require __DIR__ . '/../src/config/container.php';
AppFactory::setContainer($container);

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$routes = require __DIR__ . '/../src/config/routes.php';
$routes($app);

$app->run();

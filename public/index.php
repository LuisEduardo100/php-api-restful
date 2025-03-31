<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

$container = require __DIR__ . '/../src/config/container.php';
AppFactory::setContainer($container);

$app = AppFactory::create();
$app->setBasePath("/php-practice/api-restful/public");

$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

$routes = require __DIR__ . '/../src/config/routes.php';
$routes($app);

$app->run();

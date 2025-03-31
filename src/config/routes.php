<?php

use Luise\Apirestful\controllers\UserController;

return function (\Slim\App $app) {
  $app->get('/users', [UserController::class, 'index']);
  $app->get('/users/{id}', [UserController::class, 'show']);
  $app->post('/users', [UserController::class, 'store']);
  $app->put('/users/{id}', [UserController::class, 'update']);
  $app->delete('/users/{id}', [UserController::class, 'delete']);

  // var_dump($app->getRouteCollector()->getRoutes()); // Depuração
};

<?php

use DI\ContainerBuilder;
use Luise\Apirestful\config\Database;
use Luise\Apirestful\controllers\UserController;
use Luise\Apirestful\repository\UserRepository;
use Luise\Apirestful\services\UserService;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
  Database::class => function () {
    return new Database();
  },

  UserRepository::class => function (\Psr\Container\ContainerInterface $c) {
    return new UserRepository(
      $c->get(Database::class)->getConnection()
    );
  },

  UserService::class => function (\Psr\Container\ContainerInterface $c) {
    return new UserService(
      $c->get(UserRepository::class)
    );
  },

  UserController::class => function (\Psr\Container\ContainerInterface $c) {
    return new UserController(
      $c->get(UserService::class)
    );
  },
]);

return $containerBuilder->build();

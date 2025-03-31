<?php

namespace Luise\Apirestful\controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Luise\Apirestful\services\UserService;
use Luise\Apirestful\exceptions\ValidationException;
use Luise\Apirestful\exceptions\NotFoundException;

class UserController
{
  private UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function index(Request $request, Response $response): Response
  {
    try {
      $users = $this->userService->getAllUsers();
      return $this->jsonResponse($response, 200, $users);
    } catch (\Exception $e) {
      return $this->jsonResponse($response, 500, ['error' => 'Server error']);
    }
  }

  public function show(Request $request, Response $response, array $args): Response
  {
    try {
      $id = (int) $args['id'];
      $user = $this->userService->getUserById($id);

      if (!$user) {
        throw new NotFoundException("User not found");
      }

      return $this->jsonResponse($response, 200, $user->toArray());
    } catch (NotFoundException $e) {
      return $this->jsonResponse($response, 404, ['error' => $e->getMessage()]);
    } catch (\Exception $e) {
      return $this->jsonResponse($response, 500, ['error' => 'Server error']);
    }
  }

  public function store(Request $request, Response $response): Response
  {
    try {
      $requestData = $request->getParsedBody();
      $this->validateUserData($requestData);

      $success = $this->userService->createUser(
        $requestData['name'],
        $requestData['email'],
        $requestData['password']
      );

      if (!$success) {
        throw new \RuntimeException("Failed to create user");
      }

      return $this->jsonResponse($response, 201, ['message' => 'User created successfully']);
    } catch (ValidationException $e) {
      return $this->jsonResponse($response, 400, ['error' => $e->getMessage()]);
    } catch (\RuntimeException $e) {
      return $this->jsonResponse($response, 500, ['error' => $e->getMessage()]);
    }
  }

  public function update(Request $request, Response $response, array $args): Response
  {
    try {
      $id = (int) $args['id'];
      $requestData = $request->getParsedBody();
      $this->validateUserData($requestData, false); // Senha opcional

      $success = $this->userService->updateUser(
        $id,
        $requestData['name'],
        $requestData['email'],
        $requestData['password'] ?? null
      );

      if (!$success) {
        throw new \RuntimeException("Failed to update user");
      }

      return $this->jsonResponse($response, 200, ['message' => 'User updated successfully']);
    } catch (ValidationException $e) {
      return $this->jsonResponse($response, 400, ['error' => $e->getMessage()]);
    } catch (NotFoundException $e) {
      return $this->jsonResponse($response, 404, ['error' => $e->getMessage()]);
    } catch (\RuntimeException $e) {
      return $this->jsonResponse($response, 500, ['error' => $e->getMessage()]);
    }
  }

  public function delete(Request $request, Response $response, array $args): Response
  {
    try {
      $id = (int) $args['id'];
      $success = $this->userService->deleteUser($id);

      if (!$success) {
        throw new NotFoundException("User not found");
      }

      return $this->jsonResponse($response, 200, ['message' => 'User deleted successfully']);
    } catch (NotFoundException $e) {
      return $this->jsonResponse($response, 404, ['error' => $e->getMessage()]);
    } catch (\Exception $e) {
      return $this->jsonResponse($response, 500, ['error' => 'Server error']);
    }
  }

  private function validateUserData(array $data, bool $requirePassword = true): void
  {
    if (empty($data['name'])) {
      throw new ValidationException("Name is required");
    }

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      throw new ValidationException("Valid email is required");
    }

    if ($requirePassword && (empty($data['password']) || strlen($data['password']) < 8)) {
      throw new ValidationException("Password must be at least 8 characters");
    }
  }

  private function jsonResponse(Response $response, int $statusCode, array $data): Response
  {
    $response->getBody()->write(json_encode($data));
    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus($statusCode);
  }
}

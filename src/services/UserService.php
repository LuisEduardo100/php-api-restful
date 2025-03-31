<?php

namespace Luise\Apirestful\services;

use Luise\Apirestful\repository\UserRepository;
use Luise\Apirestful\models\User;
use Luise\Apirestful\dto\UserDTO;

class UserService
{
  private $userRepository;

  public function __construct(UserRepository $userRepository)
  {
    $this->userRepository = $userRepository;
  }

  public function getAllUsers(): array
  {
    $users = $this->userRepository->getAll();
    return array_map(function ($userData) {
      return new UserDTO(
        $userData['id'],
        $userData['name'],
        $userData['email']
      );
    }, $users);
  }

  public function getUserById(int $id): ?UserDTO
  {
    $user = $this->userRepository->getById($id);

    if (!$user) {
      return null;
    }

    return new UserDTO(
      $user->getId(),
      $user->getName(),
      $user->getEmail()
    );
  }

  public function createUser(string $name, string $email, string $password): bool
  {
    if (empty($password)) {
      throw new \InvalidArgumentException("Password cannot be empty");
    }
    if (strlen($password) < 8) {
      throw new \InvalidArgumentException("Password must be at least 8 characters");
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    if ($passwordHash === false) {
      throw new \RuntimeException("Failed to hash password");
    }

    $user = new User(
      null,
      $name,
      $email,
      $passwordHash
    );

    return $this->userRepository->create($user);
  }

  public function updateUser(int $id, string $name, string $email, string $password): bool
  {
    $user = new User(
      $id,
      $name,
      $email,
      $password
    );

    return $this->userRepository->update($user);
  }

  public function deleteUser(int $id): bool
  {
    return $this->userRepository->delete($id);
  }
}

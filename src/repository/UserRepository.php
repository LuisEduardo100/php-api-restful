<?php

namespace Luise\Apirestful\repository;

use Luise\Apirestful\models\User;
use PDO;

class UserRepository
{
  private PDO $conn;

  public function __construct(PDO $conn)
  {
    $this->conn = $conn;
  }

  public function create(User $user): bool
  {
    $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':name', $user->getName());
    $stmt->bindParam(':email', $user->getEmail());
    $stmt->bindParam(':password', $user->getPassword());
    return $stmt->execute();
  }

  public function getAll(): array
  {
    $query = "SELECT * FROM users";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById(?int $id): ?User
  {
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      return null;
    }

    return new User(
      $id['id'],
      $user['name'],
      $user['email'],
      $user['password']
    );
  }
  public function update(User $user): bool
  {
    $query = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':name', $user->getName());
    $stmt->bindParam(':email', $user->getEmail());
    $stmt->bindParam(':password', $user->getPassword());
    $stmt->bindParam(':id', $user->getId());
    return $stmt->execute();
  }

  public function delete(int $id): bool
  {
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
  }
}

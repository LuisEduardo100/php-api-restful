<?php

namespace App\e\Apirestful\services;

use Luise\Apirestful\Models\User;
use PDO;

class UserService {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function getAllUsers() {
    $stmt = $this->db->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getUserById($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function createUser($data) {
    $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password");
    $stmt->bindParam(":name", $data['name']);
    $stmt->bindParam(":email", $data['email']);
    $stmt->bindParam(":password", password_hash($data['password'], PASSWORD_DEFAULT));
    $stmt->execute();
  }

  public function dleteUser($id) {
    $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    return $stmt->execute();
  }
}


<?php
require_once __DIR__ . '/../config/database.php';

class User {
  private $id;
  private $name;
  private $email;
  private $password;
  private $created_at;

  public function __construct(
      ?int $id,
      string $name,
      string $email,
      string $password,
      string $created_at
    )
  {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->created_at = $created_at;
  }

  public function getId(): ?int {
    return $this->id;
  }

  public function getName(): string {
    return $this->name;
  }

  public function getEmail(): string {
    return $this->email;
  }

  public function getPassword(): string {
    return $this->password;
  }

  public function getCreatedAt(): string {
    return $this->created_at;
  }

}
<?php
namespace Luise\Apirestful\models;

use DateTime;

class User {
  private ?int $id;
  private string $name;
  private string $email;
  private string $password;
  private ?DateTime $created_at;

  public function __construct(
      ?int $id,
      string $name,
      string $email,
      string $password,
    )
  {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
    $this->created_at = $created_at ?? new DateTime();
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

  public function getCreatedAt(): ?DateTime {
    return $this->created_at;
  }

}
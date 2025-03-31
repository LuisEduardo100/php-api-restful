<?php

namespace Luise\Apirestful\dto;

use DateTime;

class UserDTO
{
  private int $id;
  private string $name;
  private string $email;
  private DateTime $created_at;

  public function __construct(
    int $id,
    string $name,
    string $email,
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->created_at = new DateTime();
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getCreatedAt(): DateTime
  {
    return $this->created_at;
  }

  public function toArray(): array
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'email' => $this->email,
    ];
  }
}

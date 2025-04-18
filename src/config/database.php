<?php

namespace Luise\Apirestful\config;

use PDO;
use PDOException;

class Database
{
  private $host = "localhost";
  private $db_name = "api_restful";
  private $username = "root";
  private $password = "";
  private $conn;

  public function getConnection()
  {
    $this->conn = null;

    try {
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
      die();
    }

    return $this->conn;
  }
}

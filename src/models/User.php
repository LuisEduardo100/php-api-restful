<?php
require_once __DIR__ . '/../config/database.php';

class User {
  private $conn;
  private $table_name = "users";

  public $id;
  public $name;
  public $email;
  public $password;
  public $created_at;

  public function __construct() {
    $database = new Database();
    $this->conn = $database->getConnection();
  }

  public function create() {
    $query = "INSERT INTO " . $this->table_name 
    . " (name, email, password) 
    VALUES (:name, :email, :password)";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password",password_hash(
      $this->password,
      PASSWORD_BCRYPT)
    );

    if ($stmt->execute()) {
      return true;
    }
    return false;
  }

  public function getAll() {
    $query = "SELECT * FROM ". $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
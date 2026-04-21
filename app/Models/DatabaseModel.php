<?php
namespace App\Models;

class DatabaseModel {
  private $conn;

  public function __construct() {
    $this->conn = mysqli_connect(ENV['DB_HOST'], ENV['DB_USER'], ENV['DB_PASS'], ENV['DB_NAME']);
    mysqli_set_charset($this->connect(), "utf8mb4");
  }
  
  protected function connect() {
    return $this->conn;
  }

  protected function escape(string $str = ""){
    return mysqli_real_escape_string($this->connect(), $str);
  }

  protected function disconnect(){
    mysqli_close($this->connect());
  }
}
<?php
namespace App\Models;
use App\Models\DatabaseModel;
require_once __DIR__."/../../config/config.php";

class ResetPasswordModel extends DatabaseModel {
  protected function getEmail(string $token) {
    $resetToken = $this->escape($token);
    $query = "SELECT u.email, CONCAT(u.first_name, ' ', u.last_name) as username, u.password, t.reset_token, t.token_expires_at FROM users u LEFT JOIN tokens t ON t.user_id = u.id WHERE t.reset_token = '$resetToken'";
    $result = mysqli_query($this->connect(), $query);
    return mysqli_fetch_assoc($result);
  }

  protected function updatePassword(string $token, string $newPassword) {
    $email = $this->getEmail($token)['email'];
    $query = "UPDATE tokens SET reset_token = null, token_expires_at = null WHERE reset_token = '$token'";
    mysqli_query($this->connect(), $query);
    $query = "UPDATE users SET password = '$newPassword' WHERE email = '$email'";
    mysqli_query($this->connect(), $query);
  }
}
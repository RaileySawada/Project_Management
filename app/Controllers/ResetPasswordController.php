<?php
namespace App\Controllers;
use App\Models\ResetPasswordModel;

class ResetPasswordController extends ResetPasswordModel {
  private $token;
  private $password;
  private $confirm_password;

  public function handleRequest() {
    $this->token = $_GET["token"] ?? "";
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') $this->reset();
    else $this->showResetPassword();
  }

  private function reset() {
    global $session;
    $this->password = $_POST['password'];
    $this->confirm_password = $_POST['confirm_password'];

    if ($this->password != $this->confirm_password) {
      $session->setVal('error', 'Passwords do not match');
      header('Location: '.BASE_URL.'/Reset?token='.$this->token);
      return;
    } else if (password_verify($this->password, $this->getEmail($this->token)['password'])) {
      $session->setVal('error', 'Please choose a new password. Old passwords are not allowed.');
      header('Location: '.BASE_URL.'/Reset?token='.$this->token);
      return;
    } else if (strlen($this->password) < 8) {
      $session->setVal('error', 'Password must be at least 8 characters long');
      header('Location: '.BASE_URL.'/Reset?token='.$this->token);
      return;
    } else if (!preg_match('/[a-z]/', $this->password)) {
      $session->setVal('error', 'Password must contain at least one lowercase letter');
      header('Location: '.BASE_URL.'/Reset?token='.$this->token);
      return;
    } else if (!preg_match('/[A-Z]/', $this->password)) {
      $session->setVal('error', 'Password must contain at least one uppercase letter');
      header('Location: '.BASE_URL.'/Reset?token='.$this->token);
      return;
    } else if (!preg_match('/\d/', $this->password)) {
      $session->setVal('error', 'Password must contain at least one number');
      header('Location: '.BASE_URL.'/Reset?token='.$this->token);
      return;
    } else if (!preg_match('/[@$!%*?&#]/', $this->password)) {
      $session->setVal('error', 'Password must contain at least one special character (@$!%*?&#)');
      header('Location: '.BASE_URL.'/Reset?token='.$this->token);
      return;
    }

    $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
    $this->updatePassword($this->token, $hashed_password);

    $session->setVal('success', 'Password reset successfully.');
    header('Location: '.BASE_URL);
    return;
  }

  private function showResetPassword() {
    $user = $this->getEmail($this->token);
    if (!empty($this->token) && $user['token_expires_at'] > date('Y-m-d H:i:s')) require RESET;
    else header("Location: ".BASE_URL);
  }
}
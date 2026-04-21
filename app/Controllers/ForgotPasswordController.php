<?php
namespace App\Controllers;
use App\Models\ForgotPasswordModel;

class ForgotPasswordController extends ForgotPasswordModel {
  private string $email;
  public function handleRequest() {
    global $session;
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $isAjax = $this->isAjaxRequest();

    if (!empty($session->getVal('role'))) {
      $this->redirectUser($isAjax);
      return;
    }

    if ($method === 'POST') {
      $this->reset($isAjax);
      return;
    }

    $this->showForgotPassword();
  }

  private function reset(bool $isAjax = false) {
    try {
      $this->email = trim((string) ($_POST['email'] ?? ''));
      if ($this->email === '') {
        $this->respondFailure('All input fields are required.', $isAjax, 422);
        return;
      }

      $user = $this->getEmail($this->email);
      if (empty($user)) {
        $this->respondFailure('Email address is not registered', $isAjax, 404);
        return;
      }

      $tokenExpiresAt = (string) ($user['token_expires_at'] ?? $user['reset_token_expires_at'] ?? '');
      $tokenActive = !empty($user['reset_token']) && $tokenExpiresAt !== '' && strtotime($tokenExpiresAt) > time();
      if ($tokenActive) {
        $this->respondFailure('Email already sent! Please check your email.', $isAjax, 409);
        return;
      }

      $token = bin2hex(random_bytes(32)) . time();
      $tokenExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

      $isUpdateSuccessful = $this->sendResetLink($this->email, (string) ($user['username'] ?? ''), $token, $tokenExpiry);
      if ($isUpdateSuccessful) {
        $this->respondSuccess($isAjax, 'Reset link sent!');
        return;
      }

      $this->respondFailure('Unable to send reset link right now. Please try again.', $isAjax, 500);
    } catch (\Throwable $error) {
      error_log('[ForgotPasswordController::reset] ' . $error->getMessage());
      $this->respondFailure('Unable to process your request right now. Please try again.', $isAjax, 500);
    }
  }

  private function respondSuccess(bool $isAjax, string $message): void {
    global $session;

    if ($isAjax) {
      $this->jsonResponse([
        'success' => true,
        'message' => $message
      ]);
      return;
    }

    $session->setVal('success', $message);
    header('Location: '.BASE_URL.'/Forgot_Password');
  }

  private function respondFailure(string $message, bool $isAjax, int $statusCode = 400): void {
    global $session;

    if ($isAjax) {
      $this->jsonResponse([
        'success' => false,
        'message' => $message
      ], $statusCode);
      return;
    }

    $session->setVal('error', $message);
    header('Location: '.BASE_URL.'/Forgot_Password');
  }

  private function showForgotPassword() {
    require FORGOT_PASSWORD;
  }

  private function redirectUser(bool $isAjax = false): void {
    global $session;
    $role = $session->getVal('role');
    $allowed_roles = ['ADMIN', 'ADMIN STAFF', 'STUDENT', 'FACULTY', 'STAFF', 'ACCREDITOR'];

    if (!in_array($role, $allowed_roles)) {
      if ($isAjax) {
        $this->jsonResponse([
          'success' => false,
          'message' => 'Invalid role.'
        ], 403);
        return;
      }
      $session->logout('error', 'Invalid role!');
      return;
    }

    $userRoles = $this->getRoles($session->getVal('id_number'));
    $redirectPath = '';

    if ($role === "ADMIN STAFF" || $role === "STUDENT" || ($role === "FACULTY" && isset($userRoles['rs_role']))) $redirectPath = '/Research';
    else if ($role === "ADMIN STAFF" || $role === "FACULTY") $redirectPath = '/Extension';
    else if ($role === "ADMIN STAFF" || $role === "FACULTY") $redirectPath = '/Planning';
    else if ($role === "ADMIN STAFF" || ($role === "FACULTY" && isset($userRoles['user_role']))) $redirectPath = '/Quality_Assurance';

    if ($redirectPath === '') $redirectPath = '/';

    if ($isAjax) {
      $this->jsonResponse([
        'success' => true,
        'redirectUrl' => BASE_URL . $redirectPath
      ]);
      return;
    }

    header('Location: '.BASE_URL.$redirectPath);
  }

  private function isAjaxRequest(): bool {
    $requestWith = strtolower((string) ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? ''));
    if ($requestWith === 'xmlhttprequest') return true;

    $accept = strtolower((string) ($_SERVER['HTTP_ACCEPT'] ?? ''));
    return str_contains($accept, 'application/json');
  }

  private function jsonResponse(array $payload, int $statusCode = 200): void {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
  }
}

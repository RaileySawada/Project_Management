<?php
namespace App\Controllers;
use App\Services\SessionService;

class SessionController {
  private SessionService $session;
  private int $idleTimeout = 2400;
  private int $regenInterval = 2400;

  public function __construct(array $config) {
    $this->session = new SessionService($config);
    $this->session->start();
  }

  public function handle() {
    $this->checkIdle();
    $this->regenerateIfNeeded();
    $this->touch();
  }

  private function checkIdle() {
    $lastActivity = $this->session->getValue('last_activity');

    if ($lastActivity && (time() - $lastActivity > $this->idleTimeout)) {
      $this->logout('error', 'Your session has expired.');
    }
  }

  private function regenerateIfNeeded() {
    $lastRegen = $this->session->getValue('last_regeneration');

    if (!$lastRegen || (time() - $lastRegen >= $this->regenInterval)) {
      $this->session->regenerate();
      $this->session->setValue('last_regeneration', time());
    }
  }

  private function touch() {
    $this->session->setValue('last_activity', time());
  }

  public function getVal(string $key) {
    return $this->session->getValue($key);
  }

  public function setVal(string $key, $value) {
    $this->session->setValue($key, $value);
  }

  public function dropVal(string $key) {
    $this->session->dropValue($key);
  }

  public function logout(string $key = 'success', string $message = 'Logout Successful') {
    $this->session->end();
    $this->session->start();
    $this->session->setValue($key, $message);
    header('Location: '.BASE_URL);
    exit;
  }
}
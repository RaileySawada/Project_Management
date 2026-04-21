<?php
ob_start();
require_once __DIR__ . '/../config/config.php';
require_once AUTOLOAD_CONFIG;
// require_once __DIR__ . '/../vendor/autoload.php';

$meta = require META_CONFIG;
$sessionConfig = require SESSION_CONFIG;

if (DEBUG == true) {  
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
}

use App\Controllers\SessionController;
use App\Controllers\LoginController;
use App\Controllers\ForgotPasswordController;
use App\Controllers\ResetPasswordController;

$session = new SessionController($sessionConfig);
$session->handle();

$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/Project_Management', '', $request);
$request = strtok($request, '?');
$page = str_replace('/', '', $request);
$page = str_replace('_', ' ', $page);

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if (!$isAjax) {
  $name = $session->getVal('full_name');
  $formatted_name = $session->getVal('formatted_name');
  $email = $session->getVal('email');
  $profile_picture = $session->getVal('profile_picture');
  $user_id = $session->getVal('id_number');

  require HEAD;
  require_once SPINNER;
}

if((ENVIRONMENT == 'prod' && DEBUG == false) || (ENVIRONMENT == 'local' && DEBUG == true)):
  switch ($request) {
    case '/':
      $login = new LoginController();
      $login->handleRequest();
      break;

    case '/Forgot_Password':
      $forgotPass = new ForgotPasswordController;
      $forgotPass->handleRequest();
      break;

    case '/Reset':
      $resetPass = new ResetPasswordController;
      $resetPass->handleRequest();
      break;

    case '/Logout':
      $session->logout();
      break;

    default:
      http_response_code(404);
      echo '404 Page Not Found';
      break;
  }
else:
  http_response_code(503);
  echo 'Under Maintenance';
endif;

if (!$isAjax) require FOOT;
ob_end_flush();

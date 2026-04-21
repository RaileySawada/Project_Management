<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\LoginModel;

class LoginController extends LoginModel {
  private const MAX_ATTEMPTS = 5;

  private string $id_number = '';
  private string $password = '';

  public function handleRequest(): void {
    global $session;
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $activeUserId = trim((string) ($session->getVal('id_number') ?? ''));

    if ($activeUserId !== '') {
      $this->redirectUser($this->isAjaxRequest(), $activeUserId);
      return;
    }

    if ($method === 'POST') {
      $this->login();
      return;
    }

    $this->showLogin();
  }

  private function login(): void {
    global $session;
    $isAjax = $this->isAjaxRequest();

    $this->id_number = trim((string) ($_POST['idNumber'] ?? ''));
    $this->password = (string) ($_POST['password'] ?? '');

    if ($this->id_number === '' || $this->password === '') {
      $this->respondLoginFailure('All input fields are required.', 0, $isAjax, 422);
      return;
    }

    $user = $this->getUserInfo();

    if (!$user) {
      $this->respondLoginFailure('ID Number not found.', 0, $isAjax, 404);
      return;
    }

    if (!empty($user['lockout_time']) && strtotime((string) $user['lockout_time']) > time()) {
      $attempts = $this->getCurrentAttempts($this->id_number);
      $this->respondLoginFailure(
        'Your account is locked. Please wait 10 minutes before trying again.',
        $attempts,
        $isAjax,
        423
      );
      return;
    }

    if (!password_verify($this->password, (string) ($user['password'] ?? ''))) {
      $this->incrementloginAttempts($this->id_number);
      $attempts = $this->getCurrentAttempts($this->id_number);
      $session->setVal('login_attempts', $attempts);
      $this->respondLoginFailure('Incorrect password, please try again.', $attempts, $isAjax, 401);
      return;
    }

    $redirectPath = $this->resolveRedirectPath($this->id_number);
    if ($redirectPath === null) {
      $this->respondLoginFailure('No module access found for your account.', 0, $isAjax, 403);
      return;
    }

    $this->resetLoginAttempts($this->id_number);
    $session->setVal('login_attempts', 0);
    $middleInitial = (!empty($user['middle_name']) && isset($user['middle_name'])) ? $user['middle_name'][0].'. ' : '';
    $lastName = isset($user['last_name']) ? $user['last_name'] : '';
    $fullName = trim($user['first_name'].' '.$middleInitial.$lastName);
    $session->setVal('full_name', $fullName);
    $session->setVal('formatted_name', $user['first_name'][0].'. '.$user['last_name']);
    $session->setVal('email', $user['email']);
    $session->setVal('id_number', $user['id_number']);
    $session->setVal('profile_picture', $user['picture']);
    if(isset($user['dcode'])) $session->setVal('department', $user['dcode']);
    if(isset($user['program'])) $session->setVal('program', $user['program']);
    $session->setVal('success', 'Login successful. Welcome, ' . $session->getVal('full_name') . '!');

    if ($isAjax) {
      $this->jsonResponse([
        'success' => true,
        'message' => 'Login successful.',
        'redirectUrl' => BASE_URL . $redirectPath,
        'loginAttempts' => 0,
        'maxAttempts' => self::MAX_ATTEMPTS
      ]);
      return;
    }

    header('Location: ' . BASE_URL . $redirectPath);
    return;
  }

  private function getUserInfo() {
    return $this->fetchUser($this->id_number);
  }

  private function showLogin(): void {
    $viewData = $this->getAttemptsData();
    extract($viewData);
    require LOGIN;
  }

  private function getAttemptsData(): array {
    global $session;
    return [
      'loginAttempts' => (int) ($session->getVal('login_attempts') ?? 0),
      'maxAttempts' => self::MAX_ATTEMPTS
    ];
  }

  private function redirectUser(bool $isAjax = false, ?string $idNumber = null): void {
    global $session;
    $activeId = trim((string) ($idNumber ?? $session->getVal('id_number') ?? ''));
    if ($activeId === '') {
      if ($isAjax) {
        $this->jsonResponse([
          'success' => false,
          'message' => 'Session expired.',
          'loginAttempts' => 0,
          'maxAttempts' => self::MAX_ATTEMPTS
        ], 401);
      }
      header('Location: ' . BASE_URL);
      return;
    }

    $redirectPath = $this->resolveRedirectPath($activeId);
    if ($redirectPath !== null) {
      if ($isAjax) {
        $this->jsonResponse([
          'success' => true,
          'redirectUrl' => BASE_URL . $redirectPath,
          'loginAttempts' => 0,
          'maxAttempts' => self::MAX_ATTEMPTS
        ]);
        return;
      }
      header('Location: ' . BASE_URL . $redirectPath);
      return;
    }

    if ($isAjax) {
      $this->jsonResponse([
        'success' => false,
        'message' => 'No module access found for your account.',
        'loginAttempts' => 0,
        'maxAttempts' => self::MAX_ATTEMPTS
      ], 403);
      return;
    }

    $session->logout('error', 'No module access found for your account.');
  }

  private function resolveRedirectPath(string $idNumber): ?string {
    $accessRows = $this->getPermissions($idNumber);
    $allowedModules = [];

    foreach ($accessRows as $access) {
      $module = trim((string) ($access['module'] ?? ''));
      if ($module === '') continue;

      $permissions = $this->parsePermissions((string) ($access['permission'] ?? ''));
      $hasMainPermission = !empty(array_intersect($permissions, ['set', 'view', 'upload', 'approve']));
      $hasDesignation = (bool) array_filter(
        $permissions,
        static fn(string $permission): bool => str_starts_with($permission, 'designation:')
      );

      if ($hasMainPermission || $hasDesignation) $allowedModules[$module] = true;
    }

    if (isset($allowedModules['research'])) return '/Research';
    if (isset($allowedModules['extension'])) return '/Extension';
    if (isset($allowedModules['planning'])) return '/Planning';
    if (isset($allowedModules['quality_assurance'])) return '/Quality_Assurance';

    return null;
  }

  private function parsePermissions(string $permissionValue): array {
    if ($permissionValue === '') return [];

    $permissions = [];

    foreach (explode(';', trim($permissionValue, ';')) as $permission) {
      $normalizedPermission = strtolower(trim((string) $permission));
      if ($normalizedPermission === '' || $normalizedPermission === 'no access') continue;

      if (str_starts_with(strtolower($normalizedPermission), 'designation:')) {
        $designationValues = explode(',', substr($normalizedPermission, 12));

        foreach ($designationValues as $designationValue) {
          $designationId = trim($designationValue);
          if ($designationId === '') continue;
          $permissions[] = 'designation:' . $designationId;
        }

        continue;
      }

      $permissions[] = $normalizedPermission;
    }

    return array_values(array_filter(
      $permissions,
      static fn(string $permission): bool => $permission !== '' && $permission !== 'no access'
    ));
  }

  private function getCurrentAttempts(string $idNumber): int {
    $attemptData = $this->getLoginAttempts($idNumber);
    return isset($attemptData['login_attempts']) ? (int) $attemptData['login_attempts'] : 0;
  }

  private function respondLoginFailure(
    string $message,
    int $attempts,
    bool $isAjax,
    int $statusCode = 400
  ): void {
    global $session;

    if ($isAjax) {
      $this->jsonResponse([
        'success' => false,
        'message' => $message,
        'loginAttempts' => $attempts,
        'maxAttempts' => self::MAX_ATTEMPTS
      ], $statusCode);
      return;
    }

    $session->setVal('error', $message);
    $session->setVal('login_attempts', $attempts);
    header('Location: ' . BASE_URL);
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

  public function semesters() {
    return $this->getAllSemester();
  }

  public function setCurrentSemester(): void {
    global $session;
    $session->setVal('semester', $_POST['semester']);
    $session->setVal('success', 'Active semester has been updated');
    header('Location: '.$_POST['url']);
    return;
  }

  public function semesterModal(string $url) {
    global $session;
    $semOptions = '';
    foreach ($this->semesters() as $semester) {
      $activeSem = $session->getVal('semester') == $semester['acad_year'] ? 'selected' : '';
      $semOptions .= '<option value="'.$semester['acad_year'].'" class="bg-white text-gray-800" '.$activeSem.'>'.$semester['acad_year'].'</option>';
    }
    $setSemesterBody = <<<HTML
    <div class="py-4 flex flex-col items-center gap-4">
      <label for="semester-selector" class="text-black text-lg mb-2 tracking-wide">Select Semester</label>

      <div class="relative w-[80%]">
        <select
          id="semester-selector"
          name="semester"
          class="appearance-none w-full bg-gradient-to-r from-slate-100 to-white text-gray-800 font-medium px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-blue-700 cursor-pointer transition duration-300">
          $semOptions
        </select>
        <input type="hidden" name="url" value="{$url}">
        <input type="hidden" name="action" value="update_semester">

        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
          <i class="fa-solid fa-chevron-down text-gray-500"></i>
        </div>
      </div>
    </div>
    HTML;

    return $setSemesterBody;
  }
}

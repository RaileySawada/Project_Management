<?php
namespace App\Models;
use App\Models\DatabaseModel;

class LoginModel extends DatabaseModel {
  protected function fetchUser(string $id_number) {
    $idNumber = $this->escape($id_number);
    $query = "SELECT u.id_number, u.password, u.picture, u.email, u.first_name, u.middle_name, u.last_name, u.lockout_time, u.program, d.dcode, d.dname, p.pcode, p.pname 
              FROM users u
              LEFT JOIN departments d ON d.id = u.department 
              LEFT JOIN programs p ON p.id = u.program
              WHERE u.id_number = '$idNumber'";
    $result = mysqli_query($this->connect(), $query);
    $row = mysqli_fetch_assoc($result);
    return $row;
  }

  protected function getLoginAttempts(string $id_number) {
    $idNumber = $this->escape($id_number);
    $query = "SELECT login_attempts FROM users WHERE id_number = '$idNumber'";
    $stmt = mysqli_query($this->connect(), $query);
    return $stmt->fetch_assoc();
  }

  protected function incrementloginAttempts(string $id_number) {
    $idNumber = $this->escape($id_number);
    $query = "UPDATE users 
              SET login_attempts = login_attempts + 1,
                  lockout_time = CASE 
                    WHEN login_attempts >= 5 THEN DATE_ADD(NOW(), INTERVAL 10 MINUTE)
                    ELSE lockout_time
                  END
              WHERE id_number = '$idNumber'";
    mysqli_query($this->connect(), $query);
  }

  protected function resetLoginAttempts(string $id_number) {
    $idNumber = $this->escape($id_number);
    $query = "UPDATE users SET login_attempts = 0, lockout_time = null WHERE id_number = '$idNumber'";
    mysqli_query($this->connect(), $query);
  }

  protected function getPermissions(string $id_number): array {
    $idNumber = $this->escape($id_number);
    $query = "SELECT u.id_number, d.dcode, d.dname, p.pcode, p.pname, up.module, up.permission
              FROM users u
              LEFT JOIN departments d ON u.department = d.id
              LEFT JOIN programs p ON u.program = p.id
              LEFT JOIN user_permissions up ON up.user_id = u.id
              WHERE u.id_number = '$idNumber'";
    $stmt = mysqli_query($this->connect(), $query);
    if (!$stmt) return [];
    $permissions = [];
    while ($row = mysqli_fetch_assoc($stmt)) {
      $permissions[] = $row;
    }
    return $permissions;
  }

  protected function getAccess(string $id_number) {
    $idNumber = $this->escape($id_number);
    $query = "SELECT u.id_number, sa.access_type
              FROM users u
              LEFT JOIN system_access sa ON sa.user_id = u.id";
    $stmt = mysqli_query($this->connect(), $query);
    return $stmt->fetch_assoc();
  }
  
  protected function getActiveAcadYear() {
    $query = "SELECT acad_year FROM academic_years WHERE active = 1";
    $stmt = mysqli_query($this->connect(), $query);
    return $stmt->fetch_assoc();
  }

  protected function getActiveSemester() {
    $query = "SELECT s.semester, ay.acad_year
              FROM semesters s
              LEFT JOIN academic_years ay ON s.year_id = ay.id
              WHERE s.active = 1";
    $stmt = mysqli_query($this->connect(), $query);
    return $stmt->fetch_assoc();
  }

  protected function getActiveLevel() {
    $query = "SELECT level FROM qa_level WHERE active = 1";
    $stmt = mysqli_query($this->connect(), $query);
    return $stmt->fetch_assoc();
  }

  protected function getAllSemester() {
    $query = "SELECT s.semester, a.acad_year FROM semesters s LEFT JOIN academic_years a ON s.year_id = a.id";
    $stmt = mysqli_query($this->connect(), $query);
    $semesters = [];
    while ($row = mysqli_fetch_assoc($stmt)) {
      $semesters[] = $row;
    }
    return $semesters;
  }
}
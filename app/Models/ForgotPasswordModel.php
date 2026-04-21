<?php
namespace App\Models;
use App\Models\DatabaseModel;
require_once __DIR__."/../../config/config.php";

class ForgotPasswordModel extends DatabaseModel {
  private $app_name = ENV["APP_NAME"];
  private $smtp2go_api_key = ENV["SMTP2GO_API_KEY"] ?? '';
  private $smtp2go_email = ENV["SMTP2GO_EMAIL"] ?? '';

  protected function getEmail(string $email) {
    $emailAddress = $this->escape($email);
    $query = "SELECT u.email, CONCAT(u.first_name, ' ', u.last_name) as username, t.reset_token, t.token_expires_at FROM edocs_users u LEFT JOIN tokens t ON t.user_id = u.id WHERE u.email = '$emailAddress'";
    $result = mysqli_query($this->connect(), $query);
    return mysqli_fetch_assoc($result);
  }

  protected function getRoles(string $id_number) {
    $idNumber = $this->escape($id_number);
    $query = "SELECT u.*, d.dcode, d.dname, p.pcode, p.pname, r.role as rs_role, q.user_role
              FROM edocs_users u
              LEFT JOIN departments d ON u.department = d.id
              LEFT JOIN programs p ON u.program = p.id
              LEFT JOIN research_roles r ON r.user_id = u.id
              LEFT JOIN qa_roles q ON q.user_id = u.id
              WHERE u.id_number = '$idNumber' ORDER BY u.id DESC LIMIT 1";
    $stmt = mysqli_query($this->connect(), $query);
    return $stmt->fetch_assoc();
  }

  protected function getIdByEmail(string $email) {
    $emailAddress = $this->escape($email);
    $query = "SELECT id FROM edocs_users WHERE email = '$emailAddress'";
    $stmt = mysqli_query($this->connect(), $query);
    return $stmt->fetch_assoc();
  }

  protected function sendResetLink(string $email, string $username, string $token, string $tokenExpiry) {
    $emailAddress = $this->escape($email);
    $username = $this->escape($username);
    $token = $this->escape($token);
    $tokenExpiry = $this->escape($tokenExpiry);
    
    $mail = $this->sendEmail($emailAddress, $username, $token);
    $idResult = $this->getIdByEmail($email);
    $id = isset($idResult['id']) ? (int) $idResult['id'] : 0;

    if ($mail && $id > 0) {
      $query = "SELECT t.reset_token, u.email FROM tokens t LEFT JOIN edocs_users u ON t.user_id = u.id WHERE u.email = '$emailAddress'";
      $stmt = mysqli_query($this->connect(), $query);
      $result = mysqli_fetch_assoc($stmt);

      if ($result) {
        $query = "UPDATE tokens SET reset_token = '$token', token_expires_at = '$tokenExpiry' WHERE user_id = $id";
        return (bool) mysqli_query($this->connect(), $query);
      } else {
        $query = "INSERT INTO tokens (reset_token, token_expires_at, user_id) VALUES ('$token', '$tokenExpiry', $id)";
        return (bool) mysqli_query($this->connect(), $query);
      }
    }

    return false;
  }

  private function sendEmail(string $email, string $username, string $token) {
    require MAILER_BODY;
    $subject = "Reset Your Password - $this->app_name";
    $resetLink = BASE_URL . "/Reset?token=$token";
    $purpose_title = "Password Reset Request";
    $content = '
      <td style="padding: 48px 40px;">
        <p style="color: #1a202c; font-size: 20px; font-weight: 600; margin: 0 0 16px 0; letter-spacing: -0.3px;">Hello, ' . htmlspecialchars($username) . '</p>
        
        <p style="color: #4a5568; font-size: 16px; line-height: 1.7; margin: 0 0 24px 0;">
          We received a request to reset the password for your <strong style="color: #1a202c;">' . htmlspecialchars($this->app_name) . '</strong> account. Click the button below to create a new password.
        </p>
        
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
          <tr>
            <td align="center" style="padding: 16px 0 32px 0;">
              <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td style="border-radius: 50px; background: linear-gradient(135deg, #0b2075 0%, #062296 100%); box-shadow: 0 8px 24px rgba(11, 32, 117, 0.3);">
                    <a href="' . $resetLink . '" target="_blank" style="display: inline-block; padding: 16px 48px; color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; letter-spacing: 0.3px;">
                      Reset My Password
                    </a>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 0 0 32px 0;">
          <tr>
            <td style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-left: 4px solid #ffc107; border-radius: 8px; padding: 20px 24px;">
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                  <td width="40" valign="top">
                    <span style="font-size: 28px; line-height: 1;">⏰</span>
                  </td>
                  <td valign="top">
                    <p style="color: #856404; font-size: 15px; line-height: 1.6; margin: 0;">
                      <strong style="display: block; margin-bottom: 4px; font-weight: 600;">Time-Sensitive Link</strong>
                      This password reset link will expire in <strong>1 hour</strong>. Please reset your password as soon as possible.
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 32px 0;">
          <tr>
            <td style="border-top: 1px solid #e2e8f0;"></td>
          </tr>
        </table>
        
        <p style="color: #718096; font-size: 14px; margin: 0 0 12px 0; text-align: center;">
          If the button above doesn\'t work, copy and paste this URL into your browser:
        </p>
        
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
          <tr>
            <td style="background-color: #f7fafc; border: 2px dashed #cbd5e0; border-radius: 8px; padding: 16px; word-break: break-all;">
              <a href="' . $resetLink . '" style="color: #0b2075; font-size: 13px; text-decoration: none; word-break: break-all; font-weight: 500;">
                ' . $resetLink . '
              </a>
            </td>
          </tr>
        </table>
        
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 32px 0 0 0;">
          <tr>
            <td style="background: linear-gradient(135deg, #ebf4ff 0%, #e0e7ff 100%); border-left: 4px solid #0b2075; border-radius: 8px; padding: 20px 24px;">
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                  <td width="40" valign="top">
                    <span style="font-size: 28px; line-height: 1;">🔒</span>
                  </td>
                  <td valign="top">
                    <p style="color: #3730a3; font-size: 15px; line-height: 1.6; margin: 0;">
                      <strong style="display: block; margin-bottom: 4px; font-weight: 600; color: #0b2075;">Security Notice</strong>
                      If you didn\'t request this password reset, please ignore this email. Your password will remain unchanged and your account is secure.
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>

        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 32px 0;">
          <tr>
            <td style="border-top: 1px solid #e2e8f0;"></td>
          </tr>
        </table>

        <p style="color: #718096; font-size: 14px; line-height: 1.7; margin: 0; text-align: center;">
          Need help? Contact our support team at<br>
          <a href="mailto:support@example.com" style="color: #0b2075; text-decoration: none; font-weight: 600;">support@example.com</a>
        </p>
      </td>
    ';
    $body = mailerBody($this->app_name, $content, $purpose_title);
    
    return $this->mailer($email, $username, $subject, $body);
  }

  private function mailer(string $email, string $username, string $subject, string $body) {
    $data = [
      'api_key' => $this->smtp2go_api_key,
      'sender' => "$this->app_name <$this->smtp2go_email>",
      'to' => ["$username <$email>"],
      'subject' => $subject,
      'html_body' => $body,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.smtp2go.com/v3/email/send');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);

    $response = curl_exec($ch);
    if ($response === false) {
      curl_close($ch);
      return false;
    }

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 200) {
      $response_data = json_decode($response, true);
      return isset($response_data['data']['succeeded']) && (int) $response_data['data']['succeeded'] === 1;
    }

    return false;
  }
}

<?php

function mailerBody(string $app_name, string $content, string $purpose_title) {
  $logoUrl = BASE_URL . "/public/images/logo.webp";
  return '
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Reset Your Password</title>
    </head>
    <body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, sans-serif; background-color: #f4f7fa; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color: #f4f7fa; padding: 40px 20px;">
        <tr>
          <td align="center">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08); overflow: hidden;">
              <tr>
                <td style="background: linear-gradient(135deg, #0b2075 0%, #062296 100%); padding: 48px 40px; text-align: center;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td align="center">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                          <tr>
                            <td style="background-color: rgba(255, 255, 255, 0.15); border-radius: 50%; width: 90px; height: 90px; text-align: center; vertical-align: middle; border: 3px solid rgba(255, 255, 255, 0.25);">
                              <img src="'. $logoUrl .'" alt="' . htmlspecialchars($app_name) . '" width="60" height="60" style="display: inline-block; vertical-align: middle; border: none;">
                            </td>
                          </tr>
                        </table>
                        <h1 style="color: #ffffff; font-size: 28px; font-weight: 700; margin: 24px 0 0 0; letter-spacing: -0.5px;">'.$purpose_title.'</h1>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              
              <tr>
                '.$content.'
              </tr>
              
              <tr>
                <td style="background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); padding: 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                      <td align="center" style="padding-bottom: 20px;">
                        <img src="' . $logoUrl . '" alt="' . htmlspecialchars($app_name) . '" width="50" height="50" style="opacity: 0.5; border: none;">
                      </td>
                    </tr>
                  </table>
                  
                  <p style="color: #718096; font-size: 14px; line-height: 1.6; margin: 0 0 24px 0;">
                    You\'re receiving this email because a password reset was requested for your account.
                  </p>
                  
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; padding: 20px 0; margin: 0 0 24px 0;">
                    <tr>
                      <td align="center">
                        <a href="' . BASE_URL . '" style="color: #4a5568; text-decoration: none; font-size: 14px; font-weight: 500; margin: 0 12px;">Home</a>
                        <span style="color: #cbd5e0;">|</span>
                        <a href="' . BASE_URL . '/Help" style="color: #4a5568; text-decoration: none; font-size: 14px; font-weight: 500; margin: 0 12px;">Help Center</a>
                        <span style="color: #cbd5e0;">|</span>
                        <a href="' . BASE_URL . '/Privacy" style="color: #4a5568; text-decoration: none; font-size: 14px; font-weight: 500; margin: 0 12px;">Privacy</a>
                        <span style="color: #cbd5e0;">|</span>
                        <a href="' . BASE_URL . '/Contact" style="color: #4a5568; text-decoration: none; font-size: 14px; font-weight: 500; margin: 0 12px;">Contact</a>
                      </td>
                    </tr>
                  </table>
                  
                  <p style="color: #a0aec0; font-size: 13px; margin: 0;">
                    © ' . date('Y') . ' ' . htmlspecialchars($app_name) . '. All rights reserved.
                  </p>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </body>
    </html>
  ';
}
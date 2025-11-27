<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendResetEmail($email, $resetLink)
{
  $mail = new PHPMailer(true);

  try {
    // REQUIRED SETTINGS
    $mail->isSMTP();
    $mail->Host       = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USERNAME'] ?? '';
    $mail->Password   = $_ENV['SMTP_PASSWORD'] ?? '';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = (int) ($_ENV['SMTP_PORT'] ?? 587);

    // Optional: charset/encoding
    $mail->CharSet    = 'UTF-8';
    $mail->Encoding   = 'base64';

    // sender details
    $mail->setFrom($_ENV['SMTP_FROM'] ?? 'no-reply@example.com', $_ENV['SMTP_FROM_NAME'] ?? 'App');
    $mail->addAddress($email);

    // email content
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Instructions';
    $mail->Body = "
            <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
                <h2>Password Reset Request</h2>
                <p>Click below to reset your password:</p>
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='$resetLink'
                        style='background-color: #28a745; color: white; padding: 12px 24px; 
                        text-decoration: none; border-radius: 6px;'>
                        Reset My Password
                    </a>
                </div>
                <p>If you did not request this, ignore this message.</p>
            </div>
        ";

    $mail->send();
  } catch (Exception $e) {
    error_log("Mailer Exception: {$e->getMessage()}");
    error_log("Mailer ErrorInfo: {$mail->ErrorInfo}");
  }
}

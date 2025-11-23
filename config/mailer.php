<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendResetEmail($email, $resetLink)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'abubakarahmadadili002@gmail.com';
        $mail->Password   = 'hlnd boad ofsf hrap';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('abubakarahmadadili002@gmail.com', 'Tauheed Academy');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Instructions';
        $mail->Body = "
  <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
    <h2 style='color: #2c3e50; text-align: center;'>Password Reset Request</h2>
    <p>Hello,</p>
    <p>We received a request to reset your password for <strong>Tauheed Academy</strong>. 
    If this was you, please click the button below to reset your password:</p>
    
    <div style='text-align: center; margin: 30px 0;'>
      <a href='$resetLink' 
         style='background-color: #28a745; color: white; padding: 12px 24px; 
                text-decoration: none; border-radius: 6px; font-weight: bold;'>
        Reset My Password
      </a>
    </div>
    
    <p>This link will expire in <strong>1 hour</strong> for your security.</p>
    <p>If you did not request a password reset, you can safely ignore this email.</p>
    
    <hr style='margin: 30px 0; border: none; border-top: 1px solid #ddd;'/>
    <p style='font-size: 12px; color: #777; text-align: center;'>
      &copy; " . date('Y') . " Tauheed Academy. All rights reserved.
    </p>
  </div>
";


        $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
    }
}

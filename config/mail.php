<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../PHPMailer/src/Exception.php";
require_once __DIR__ . "/../PHPMailer/src/PHPMailer.php";
require_once __DIR__ . "/../PHPMailer/src/SMTP.php";

function sendResetMail($toEmail, $toName, $resetLink)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();

        $mail->Host = "smtp.gmail.com";

        $mail->SMTPAuth = true;

        $mail->Username = "##############";

        $mail->Password = "##############3";

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = 587;

        $mail->setFrom(
            "YOUR_GMAIL@gmail.com",
            "Library LMS"
        );

        $mail->addAddress(
            $toEmail,
            $toName
        );

        $mail->isHTML(true);

        $mail->Subject = "Reset Your Password";

        $mail->Body = "

        <h2>Library LMS</h2>

        <p>Hello <b>$toName</b>,</p>

        <p>You requested a password reset.</p>

        <p>
        Click the button below.
        </p>

        <a
        href='$resetLink'
        style='
        background:#2563eb;
        color:white;
        padding:12px 20px;
        text-decoration:none;
        border-radius:6px;
        '>
        Reset Password
        </a>

        <br><br>

        <p>
        This link expires in
        <b>1 hour</b>.
        </p>

        ";

        return $mail->send();

    } catch (Exception $e) {

        return false;

    }
}
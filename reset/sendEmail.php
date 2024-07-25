<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$mailSentOrNo = false;
require 'vendor/autoload.php';
function resetPasswordOnly()
{

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'docstreamofficial@gmail.com';
        $mail->Password   = 'npxbunksujpluvkt';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('docstreamofficial@gmail.com', 'DocStream');
        $mail->addAddress($_POST["emailCpy"]);

        $mail->isHTML(true);
        $mail->Subject = 'Forgot Password';
        $mail->Body    = "
                <h3>Hello, you are receiving this email because you requested a password reset.</h3>
                <p>Click the link below to reset your password</p>
                <a href='http://localhost/dms/reset/resetpassword.php'>Reset Password</a>
                ";
        if($mail->send())
        {
            global $mailSentOrNo;
            $mailSentOrNo = true;
        }
        else
        {
            global $mailSentOrNo;
            $mailSentOrNo = false;
        }
        
        // if ($mail->send()) {
        //     echo '<div class="alert alert-success alert-dismissible fade show alert-top mb-0" role="alert">
        // <strong>Success! </strong>A password reset email has bee sent to you. Check your Inbox.
        // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        // </div>';
        // } else {
        //     echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0" role="alert">
        // <strong>Error! </strong>Something went wrong. Email couldn\'t be sent.<br>Error:' . $mail->ErrorInfo . '
        // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        // </div>';
        // }
    } catch (Exception $e) {
        // echo '<div class="alert alert-danger alert-dismissible fade show alert-top mb-0" role="alert">
        // <strong>Error! </strong>Something went wrong. Email couldn\'t be sent.<br>Error:' . $mail->ErrorInfo . '
        // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        // </div>';
    }
}

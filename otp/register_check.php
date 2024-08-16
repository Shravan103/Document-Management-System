<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'vendor/autoload.php';

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "dms";
$table = "users";
$table2 = "otps";

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    
    // Generate a 6-digit OTP
    $otp = sprintf("%06d", mt_rand(1, 999999));
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); 

    $query = "INSERT INTO $table (username, email, password, type, date, status, status2) VALUES (?, ?, ?,'employee', CURRENT_TIMESTAMP(),  'inactive', 0)";
    $query2 = "INSERT INTO $table2 (email,otp) VALUES (?,?)";

    
    $stmt= $mysqli->prepare($query);
    $stmt2 = $mysqli->prepare($query2);


    if (!$stmt|| !$stmt2) {
        die("Error in SQL query: " . $mysqli->error);
    }

    $stmt->bind_param("sss", $name, $email, $hashedPassword);
    $stmt2->bind_param("ss", $email, $otp);
    
    
    if ($stmt->execute()&&$stmt2->execute()) {
        // Send an email with the OTP for verification
        $mail =  new PHPMailer(true);
        $mail->SMTPDebug = 1;    
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'docstreamofficial@gmail.com';
        $mail->Password = 'mjuf mldq ynsy gvgt';
       
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('docstreamofficial@gmail.com', 'DocStream');
        $mail->addReplyTo('docstreamofficial@gmail.com', 'DocStream');

        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code for Registration';
        $mail->Body = "Your OTP is: $otp";

        if ($mail->send()) {
            session_start(); // Start a PHP session
            $message[] = "Registration successful. Check your email for the OTP.";
            $_SESSION["email"] = $email;
            echo "1";
            header("Location: otp.php");
            exit; 
        } else {
            $message[] = 'Error sending OTP:';
            // header("Location: register.php");
            // echo "Error sending OTP: " . $mail->ErrorInfo;
            echo "2";
        }
    } else {
       $message[] = "Error: " . $stmt->error;
       echo "3";
        // header("Location: register.php");
    }
}

$mysqli->close();
?>
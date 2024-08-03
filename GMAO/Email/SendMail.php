

<?php
// session_start();
// require_once("./config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";

require '../../phpmailer/src/PHPMailer.php';  
require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/SMTP.php';

function SendMail($email,$message){
    // Create a new PHPMailer instance
    try {
        $mail = new PHPMailer(true);
        // Set mailer to use SMTP
        $mail->isSMTP();
        $mail->SMTPDebug = 0; // Set to 2 for debugging
    
        // SMTP settings
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'djairmouad@gmail.com'; // Replace with your Gmail address
        $mail->Password = 'cqbw mkgk hdug sksz'; // Replace with your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
    
        // Sender and recipient
        $mail->setFrom('djairmouad@gmail.com', 'djair mouad'); // Replace with your name and email
        $mail->addAddress($email, ''); // Replace with recipient's email address and name
        
        // Subject and body
        $mail->Subject = 'Request For Intervention';
        $mail->isHTML(true); // Set the email body type to HTML
        $mail->Body = $message; // Include HTML content or plain text
    
        // Send the email
        if ($mail->send()) {
            echo 'Email with formatted HTML content has been sent successfully.';
        } else {
            echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }
    
    } catch (Exception $e) {
        echo 'Email could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

?>

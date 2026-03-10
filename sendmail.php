<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);
    
    try {
        // SES SMTP settings
        $mail->isSMTP();
        $mail->Host = 'email-smtp.ap-south-1.amazonaws.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'AKIA5T6N3ZLMLYF465MV';  // PASTE HERE
        $mail->Password = 'BBdM/OneiS3YrhRPLCcwIvH2OpzLVwmedHmA3Pzw/wW3';  // PASTE HERE
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        
        // Recipients
        $mail->setFrom('ankit.finvasia@gmail.com', 'Anant Global');
        $mail->addAddress('ankit.finvasia@gmail.com');  // Your email
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Consultation: ' . $_POST['subject'];
        $mail->Body = "
            <h2>New Consultation Request</h2>
            <p><strong>Name:</strong> {$_POST['fullname']}</p>
            <p><strong>Phone:</strong> {$_POST['phone']}</p>
            <p><strong>Email:</strong> {$_POST['email']}</p>
            <p><strong>Message:</strong><br>{$_POST['message']}</p>
        ";
        
        $mail->send();
        header("Location: index.html?status=success");
    } catch (Exception $e) {
        header("Location: index.html?status=error");
    }
}
?>

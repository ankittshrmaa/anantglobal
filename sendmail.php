<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fullname'])) {
    
    // Get form data
    $fullname = strip_tags(trim($_POST["fullname"]));
    $fullname = htmlspecialchars($fullname);
    
    $countrycode = isset($_POST["countrycode"]) ? $_POST["countrycode"] : "+91";
    $phone = strip_tags(trim($_POST["phone"]));
    $fullphone = $countrycode . " " . $phone;
    
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = isset($_POST["subject"]) ? $_POST["subject"] : "No subject selected";
    $message = isset($_POST["message"]) ? strip_tags(trim($_POST["message"])) : "No message";
    
    // Validate required fields
    if (empty($fullname) || empty($phone) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.html?status=error");
        exit;
    }
    
    // YOUR EMAIL ADDRESS - CHANGE THIS!
    $to = "info@anantglobal.in"; // Use your actual email
    
    // Email subject
    $email_subject = "New Consultation Request from $fullname";
    
    // Email content
    $email_content = "You have received a new consultation request:\n\n";
    $email_content .= "Name: $fullname\n";
    $email_content .= "Phone: $fullphone\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Subject: $subject\n";
    $email_content .= "Message:\n$message\n";
    
    // Email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Send email
    if (mail($to, $email_subject, $email_content, $headers)) {
        header("Location: index.html?status=success");
    } else {
        // Log error for debugging
        error_log("Mail failed for consultation request from $email");
        header("Location: index.html?status=error");
    }
    exit;
} else {
    // If someone tries to access directly
    header("Location: index.html");
    exit;
}
?>
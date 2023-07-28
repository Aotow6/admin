<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output (You can set it to '0' to disable debugging)
     $mail->isSMTP(); // Send using SMTP
    $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'manusianpc2@gmail.com'; // SMTP username (your Gmail address)
    $mail->Password = 'ufxnwzogbyildvik'; // SMTP password (your Gmail password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption (you can also use PHPMailer::ENCRYPTION_STARTTLS)
    $mail->Port = 465; // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    // Recipients
    $mail->setFrom('manusianpc2@gmail.com','gweh' ); // Set the sender's email address and name
    $mail->addAddress('support@adnan-tech.com', 'Adnan Tech'); // Add a recipient email and name (optional)

    // Content
    $mail->isHTML(true); // Set email format to HTML (you can set it to 'false' for plain text)
    $mail->Subject = 'Test Email from PHPMailer'; // Email subject
    $mail->Body = 'This is a test email sent using PHPMailer. <b>HTML content</b> can be included in the body.'; // HTML version of the email
    $mail->AltBody = 'This is the plain text version of the test email.'; // Plain text version of the email (for clients that can't display HTML)

    $mail->send(); // Send the email
    echo 'Message has been sent'; // Display success message if the email is sent successfully
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; // Display error message if there's an exception
}
?>

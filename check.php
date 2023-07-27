<?php
require 'vendor/autoload.php'; // Make sure to include the correct path to autoload.php

// Check if PHPMailer class is available
if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    echo "PHPMailer is installed.";
} else {
    echo "PHPMailer is not installed.";
}
?>

<h2>tes</h2>
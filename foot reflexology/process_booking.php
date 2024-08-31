<?php
// process_booking.php

// Start the session
session_start();

// Get the form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';
$service = $_POST['service'] ?? '';

// Admin email address
$admin_email = 'sharmifootreflexologycentre@gmail.com'; // Replace with your admin email address

// Validate and process the data
if ($name && $email && $phone && $date && $time && $service) {
    // Prepare the email content
    $subject = 'New Booking Appointment';
    $message = "You have a new booking appointment:\n\n";
    $message .= "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Phone: $phone\n";
    $message .= "Date: $date\n";
    $message .= "Time: $time\n";
    $message .= "Service: $service\n";

    $headers = 'From: no-reply@example.com' . "\r\n" .
               'Reply-To: no-reply@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Send the email to the admin
    mail($admin_email, $subject, $message, $headers);

    // Redirect to a confirmation page
    header("Location: confirmation.html");
    exit(); // Make sure to exit after redirection
} else {
    // Redirect back to the booking page with an error (optional)
    header("Location: booking.html?error=1");
    exit(); // Make sure to exit after redirection
}
?>

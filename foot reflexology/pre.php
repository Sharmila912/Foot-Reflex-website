<?php
// Capture form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$time = $_POST['time'];
$service = $_POST['service'];

// Admin email
$admin_email = 'sharmifootreflexologycentre@gmail.com'; // Your email address

// Email subject
$subject = 'New Appointment Booking';

// Email body
$message = "
    <html>
    <head>
        <title>New Appointment Booking</title>
    </head>
    <body>
        <p>You have received a new appointment booking.</p>
        <table>
            <tr>
                <th>Full Name:</th>
                <td>$name</td>
            </tr>
            <tr>
                <th>Email Address:</th>
                <td>$email</td>
            </tr>
            <tr>
                <th>Phone Number:</th>
                <td>$phone</td>
            </tr>
            <tr>
                <th>Preferred Date:</th>
                <td>$date</td>
            </tr>
            <tr>
                <th>Preferred Time:</th>
                <td>$time</td>
            </tr>
            <tr>
                <th>Selected Service:</th>
                <td>$service</td>
            </tr>
        </table>
    </body>
    </html>
";

// Set content-type for HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Additional headers
$headers .= 'From: ' . $email . "\r\n";
$headers .= 'Reply-To: ' . $email . "\r\n";

// Send email
if (mail($admin_email, $subject, $message, $headers)) {
    echo 'Thank you for booking an appointment. We will get back to you soon!';
} else {
    echo 'Sorry, there was an error processing your request. Please try again later.';
}
?>

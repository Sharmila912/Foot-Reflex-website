<?php
require_once 'vendor/autoload.php'; // Composer's autoload file

use Vonage\Client\Credentials\Basic;
use Vonage\Client;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nexmo (Vonage) API credentials
    $apiKey = 'YOUR_API_KEY'; // Replace with your Nexmo API Key
    $apiSecret = 'YOUR_API_SECRET'; // Replace with your Nexmo API Secret

    // Form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Admin's phone number (international format, e.g., +919344820338)
    $adminPhoneNumber = 'YOUR_ADMIN_PHONE_NUMBER';

    // Create the SMS message
    $smsMessage = "New Contact Form Submission:\n";
    $smsMessage .= "Name: $name\n";
    $smsMessage .= "Email: $email\n";
    $smsMessage .= "Message: $message";

    // Initialize the Vonage Client
    $basic  = new Basic($apiKey, $apiSecret);
    $client = new Client($basic);

    // Try to send the SMS
    try {
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($adminPhoneNumber, 'SharmiFootReflex', $smsMessage)
        );

        // Check if the message was successfully sent
        $messageResponse = $response->current();
        if ($messageResponse->getStatus() == 0) {
            echo "Message sent successfully!";
        } else {
            echo "Failed to send message. Error: " . $messageResponse->getStatus();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

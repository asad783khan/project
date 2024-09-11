<?php
header('Content-Type: application/json');
require 'database.php';

$email = $_POST['email'];

// Simple example: generate a reset link (no actual implementation for sending email)
$resetLink = "https://yourdomain.com/reset_password.php?email=" . urlencode($email);

// Simulate sending email (replace with actual email sending in production)
echo json_encode(['success' => true, 'message' => 'Reset link sent to ' . $resetLink]);

$conn->close();
?>

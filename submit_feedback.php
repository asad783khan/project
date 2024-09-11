<?php
include "db_connect.php";
// Prepare and bind
$stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

// Set parameters and execute
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: feedback_success.html");
exit();
?>

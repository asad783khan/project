<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Send a message
    $receiver_id = $_POST['receiver_id'];
    $message_content = $_POST['message_content'];

    $query_message = "INSERT INTO messages (sender_id, receiver_id, message_content, sent_at) VALUES ($teacher_id, $receiver_id, '$message_content', NOW())";
    mysqli_query($conn, $query_message);
}

// Fetch received messages
$teacher_id = $_SESSION['teacher_id'];
$query_messages = "SELECT * FROM messages WHERE receiver_id = $teacher_id";
$result_messages = mysqli_query($conn, $query_messages);
?>

<h2>Communication</h2>
<form method="post">
    <label for="receiver_id">Receiver ID:</label>
    <input type="text" name="receiver_id" required>
    <label for="message_content">Message:</label>
    <textarea name="message_content" required></

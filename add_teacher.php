<?php
include 'db_connect.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password
$email = $_POST['email'];
$subject = $_POST['subject'];

$sql = "INSERT INTO teachers (username, password, email, subject) VALUES ('$username', '$password', '$email', '$subject')";

if ($conn->query($sql) === TRUE) {
    echo "New teacher added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

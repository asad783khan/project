<?php
session_start();
require 'db_connect.php'; // Ensure this path is correct and the file exists

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$semester = $_POST['semester'];

// Hash the password for storage
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if the email and semester combination already exists
$sql_check = "SELECT * FROM teachers WHERE email = ? AND semester = ?";
$stmt_check = $conn->prepare($sql_check);

if ($stmt_check === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt_check->bind_param("ss", $email, $semester);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Email and semester combination already exists
    echo "The email is already registered for this semester.";
} else {
    // Prepare SQL statement for insertion
    $sql_insert = "INSERT INTO teachers (name, email, password, semester) VALUES (?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);

    if ($stmt_insert === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt_insert->bind_param("ssss", $name, $email, $hashed_password, $semester);

    if ($stmt_insert->execute()) {
        // Successful registration
        header("Location: ../hod/hod_portal.php"); // Redirect to the HOD portal page
        exit();
    } else {
        echo "Execute failed: " . htmlspecialchars($stmt_insert->error);
    }

    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>

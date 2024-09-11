<?php
// Database connection
include "db_connect.php";

// Sanitize and validate input data
$name = $conn->real_escape_string($_POST['name']);
$fathername = $conn->real_escape_string($_POST['fathername']);
$college_roll_number = $conn->real_escape_string($_POST['college_roll_number']);
$uni_roll_number = $conn->real_escape_string($_POST['uni_roll_number']);
$registration_number = $conn->real_escape_string($_POST['registration_number']);
$department = $conn->real_escape_string($_POST['department']);
$semester = $conn->real_escape_string($_POST['semester']);
$email = $conn->real_escape_string($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Password hashing

// Insert data into the database
$sql = "INSERT INTO students (name, fathername, college_roll_number, uni_roll_number, registration_number, department, semester, email, password)
        VALUES ('$name', '$fathername', '$college_roll_number', '$uni_roll_number', '$registration_number', '$department', '$semester', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    // Registration successful, show alert and redirect
    echo '<script>
            alert("Registration successful! Press OK to go to the HOD portal and back to this page to register another student.");
            window.location.href = "../hod/hod_portal.php";
          </script>';
} else {
    // Error occurred
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

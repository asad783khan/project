<?php
session_start();
include "db_connect.php"; // Include your database connection script

$email = '';  // Variables to store form input values
$selectedSemester = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize user inputs
    $email = $conn->real_escape_string($_POST['email']); 
    $password = $_POST['password'];
    $selectedSemester = $_POST['semester']; // Get the selected semester from the form

    // Query to get student details
    $sql = "SELECT * FROM students WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Ensure the semester selected is between 1 and 8
            if (in_array($selectedSemester, range(1, 8))) {
                // Set session variables
                $_SESSION['student_name'] = $row['name'];
                $_SESSION['student_id'] = $row['id'];
                $_SESSION['semester'] = $selectedSemester; // Use the semester selected in the form

                // Redirect to the student portal
                header("Location: ../students/student_portal.php");
                exit();
            } else {
                echo "<script>alert('Invalid semester selection. Please select a valid semester from 1 to 8.');</script>";
            }
        } else {
            echo "<script>alert('Invalid password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('No account found with this email address. Please check your email or register.');</script>";
    }
}
?>
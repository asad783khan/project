<?php
// Include the database connection file
include_once '../db_connect.php';

// Start session
session_start();

// Get form data
$email = $_POST['Email'] ?? '';
$password = $_POST['password'] ?? '';

// Sanitize input data
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

// Prepare SQL query to fetch teacher data
$sql = "SELECT * FROM teachers WHERE email = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param('s', $email);

// Execute the query
if (!$stmt->execute()) {
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();

// Check if a teacher with the provided email exists
if ($result->num_rows === 1) {
    $teacher = $result->fetch_assoc();

    // Verify the password
    if (password_verify($password, $teacher['password'])) {
        // Password is correct, fetch assigned semesters from the teacher_courses table
        $sql_semesters = "SELECT DISTINCT semester FROM teacher_courses WHERE teacher_id = ?";
        $stmt_semesters = $conn->prepare($sql_semesters);
        $stmt_semesters->bind_param('i', $teacher['id']);
        $stmt_semesters->execute();
        $result_semesters = $stmt_semesters->get_result();

        $semesters = [];
        while ($row = $result_semesters->fetch_assoc()) {
            $semesters[] = $row['semester'];
        }

        // Store teacher data and assigned semesters in session
        $_SESSION['teacher_id'] = $teacher['id'];
        $_SESSION['teacher_name'] = $teacher['name'];
        $_SESSION['semesters'] = $semesters;

        // Redirect to the teacher dashboard
        header('Location: ../teacher/teacher_portal.php');
        exit();
    } else {
        // Invalid password
        $_SESSION['login_error'] = 'Invalid email or password.';
        header('Location: ../auth/dlms-login.html');
        exit();
    }
} else {
    // Invalid email
    $_SESSION['login_error'] = 'Invalid email or password.';
    header('Location: ../auth/dlms-login.html');
    exit();
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

<?php
// remove_courses.php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['courses'])) {
    $course_ids = $_POST['courses'];
    $placeholders = implode(',', array_fill(0, count($course_ids), '?'));

    $stmt = $conn->prepare("DELETE FROM courses WHERE id IN ($placeholders)");
    $stmt->bind_param(str_repeat('i', count($course_ids)), ...$course_ids);

    if ($stmt->execute()) {
        header('Location: remove-course.php'); // Redirect back to the main page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

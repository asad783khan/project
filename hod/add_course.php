<?php
// add_course.php
include '../db_connect.php'; // Make sure this file contains your DB connection settings

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $semester = $_POST['semester'];
    $course_code = $_POST['course_code'];
    $course_title = $_POST['course_title'];
    $author_name = $_POST['author_name'];
    $course_outline = $_POST['course_outline'];

    $stmt = $conn->prepare("INSERT INTO courses (semester, course_code, course_title, author_name, course_outline) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $semester, $course_code, $course_title, $author_name, $course_outline);
    
    if ($stmt->execute()) {
        header('Location: add_course1.php'); // Redirect to the same page to show the updated course list
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

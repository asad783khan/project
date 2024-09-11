<?php
include '../db_connect.php';

$course_id = isset($_POST['id']) ? $_POST['id'] : '';
$course_code = isset($_POST['course_code']) ? $_POST['course_code'] : '';
$course_title = isset($_POST['course_title']) ? $_POST['course_title'] : '';
$author_name = isset($_POST['author_name']) ? $_POST['author_name'] : '';
$semester = isset($_POST['semester']) ? $_POST['semester'] : '';
$course_outline = isset($_POST['course_outline']) ? $_POST['course_outline'] : '';

if (!$course_id || !$course_code || !$course_title || !$author_name || !$semester || !$course_outline) {
    echo "All fields are required.";
    exit;
}

// Update course data
$query = "UPDATE courses SET course_code = ?, course_title = ?, author_name = ?, semester = ?, course_outline = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssisi", $course_code, $course_title, $author_name, $semester, $course_outline, $course_id);

if ($stmt->execute()) {
    echo "Course updated successfully.";
} else {
    echo "Error updating course: " . $conn->error;
}

$stmt->close();
$conn->close();
?>

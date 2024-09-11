<?php
require 'db_connect.php';

if (isset($_GET['semester'])) {
    $semester = $_GET['semester'];

    // Fetch subjects (course_code and course_title) for the selected semester
    $stmt = $conn->prepare("SELECT id, course_code, course_title FROM courses WHERE semester = ?");
    $stmt->bind_param("i", $semester);
    $stmt->execute();
    $result = $stmt->get_result();
    $subjects = [];

    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }

    // Return the subjects as a JSON object
    echo json_encode($subjects);
}
?>

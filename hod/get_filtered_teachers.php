<?php
require 'db_connect.php';

$semester_type = isset($_GET['semester_type']) ? $_GET['semester_type'] : '';
$semester = isset($_GET['semester']) ? $_GET['semester'] : '';

$query = "SELECT teachers.id, teachers.name, semesters.name AS semester, subjects.name AS subject, teachers.department, teachers.email, teachers.password 
          FROM teachers
          LEFT JOIN teachers_courses ON teachers.id = teachers_courses.teacher_id
          LEFT JOIN courses ON teachers_courses.course_id = courses.id
          LEFT JOIN semesters ON courses.semester_id = semesters.id
          LEFT JOIN subjects ON courses.subject_id = subjects.id";

if ($semester_type && $semester) {
    $query .= " WHERE semesters.semester_type = '$semester_type' AND semesters.name = '$semester'";
}

$result = $conn->query($query);

$teachers = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
}

echo json_encode($teachers);
?>

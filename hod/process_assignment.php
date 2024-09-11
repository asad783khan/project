<?php
include "db_connect.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Sanitize and retrieve form data
    $teacher_id = isset($_POST['teacher']) ? intval($_POST['teacher']) : 0;
    $new_subjects = isset($_POST['subjects']) ? $_POST['subjects'] : [];
    $semester = isset($_POST['semester']) ? intval($_POST['semester']) : 0;

    // Check if teacher_id and semester are valid
    if ($teacher_id <= 0 || $semester <= 0 || empty($new_subjects)) {
        throw new Exception("Invalid input data.");
    }

    // Fetch existing courses for the teacher and semester
    $query = 'SELECT course_id FROM teacher_courses WHERE teacher_id = ? AND semester = ?';
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('ii', $teacher_id, $semester);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    $existing_courses_result = $stmt->get_result();
    $existing_courses = [];
    while ($row = $existing_courses_result->fetch_assoc()) {
        $existing_courses[] = $row['course_id'];
    }
    $stmt->close();

    // Merge new subjects with existing ones
    $all_courses = array_unique(array_merge($existing_courses, array_map('intval', $new_subjects)));

    // Clear existing courses and re-insert merged list
    $query = 'DELETE FROM teacher_courses WHERE teacher_id = ? AND semester = ?';
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('ii', $teacher_id, $semester);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    $stmt->close();

    // Insert new subjects
    $query = 'INSERT INTO teacher_courses (teacher_id, course_id, semester) VALUES (?, ?, ?)';
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    foreach ($all_courses as $course_id) {
        if (!$stmt->bind_param('iii', $teacher_id, $course_id, $semester)) {
            throw new Exception("Bind failed: " . $stmt->error);
        }
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
    }
    $stmt->close();

    // Output JavaScript for alert and redirection
    echo "<script>
            if (confirm('Courses assigned successfully! Press OK to go to the teacher list or Cancel to stay on this page.')) {
                window.location.href = 'view_teacher.php';
            }
          </script>";

} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>


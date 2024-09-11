<?php
include "db_connect.php";

// Handle form submission to assign courses
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacherId = $_POST['teacher'];
    $semester = $_POST['semester'];
    $subjects = $_POST['subjects'];

    $conn->begin_transaction();

    try {
        // Delete existing assignments for the teacher in the given semester
        $stmt = $conn->prepare('DELETE FROM teacher_courses WHERE teacher_id = ? AND semester = ?');
        $stmt->bind_param('is', $teacherId, $semester);
        if (!$stmt->execute()) {
            throw new Exception("Failed to delete existing assignments: " . $stmt->error);
        }

        // Insert new assignments
        $stmt = $conn->prepare('INSERT INTO teacher_courses (teacher_id, course_id, semester) VALUES (?, ?, ?)');
        foreach ($subjects as $subject) {
            $stmt->bind_param('iis', $teacherId, $subject, $semester);
            if (!$stmt->execute()) {
                throw new Exception("Failed to insert assignment: " . $stmt->error);
            }
        }

        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Fetch teachers and subjects
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    try {
        // Fetch teachers
        $query = '
            SELECT t.id, t.name, t.email, t.department, tc.semester, GROUP_CONCAT(c.course_name) AS courses
            FROM teachers t
            LEFT JOIN teacher_courses tc ON t.id = tc.teacher_id
            LEFT JOIN courses c ON tc.course_id = c.id
            GROUP BY t.id, tc.semester
        ';
        $result = $conn->query($query);

        if ($result === false) {
            throw new Exception("Error executing teachers query: " . $conn->error);
        }

        $teachers = $result->fetch_all(MYSQLI_ASSOC);

        // Fetch subjects
        $query = 'SELECT id, course_name FROM courses';
        $result = $conn->query($query);

        if ($result === false) {
            throw new Exception("Error executing subjects query: " . $conn->error);
        }

        $subjects = $result->fetch_all(MYSQLI_ASSOC);

        echo json_encode(['teachers' => $teachers, 'subjects' => $subjects]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}
?>

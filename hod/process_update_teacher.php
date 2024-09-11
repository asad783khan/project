<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db_connect.php';  // Ensure this file connects to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = $_POST['teacher_id'];
    $name = $_POST['name'];
    $semester = $_POST['semester'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $courses = $_POST['courses'];  // Array of selected course IDs

    if ($teacher_id && $name && $semester && $department && $email) {
        // Begin transaction
        $conn->begin_transaction();

        try {
            // Update teacher information
            $update_teacher_stmt = $conn->prepare("UPDATE teachers SET name = ?, semester = ?, department = ?, email = ? WHERE id = ?");
            $update_teacher_stmt->bind_param("ssssi", $name, $semester, $department, $email, $teacher_id);

            if (!$update_teacher_stmt->execute()) {
                throw new Exception("Error updating teacher: " . $update_teacher_stmt->error);
            }

            // Remove existing course assignments
            $delete_assignments_stmt = $conn->prepare("DELETE FROM teacher_courses WHERE teacher_id = ?");
            $delete_assignments_stmt->bind_param("i", $teacher_id);

            if (!$delete_assignments_stmt->execute()) {
                throw new Exception("Error removing assignments: " . $delete_assignments_stmt->error);
            }

            // Assign new courses
            foreach ($courses as $course_id) {
                $assign_course_stmt = $conn->prepare("INSERT INTO teacher_courses (teacher_id, course_id) VALUES (?, ?)");
                $assign_course_stmt->bind_param("ii", $teacher_id, $course_id);

                if (!$assign_course_stmt->execute()) {
                    throw new Exception("Error assigning course: " . $assign_course_stmt->error);
                }
            }

            // Commit transaction
            $conn->commit();
            echo "<script>
                alert('Teacher and course assignments updated successfully!');
                window.location.href = 'hod_portal.php';
            </script>";
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.location.href = 'update_teacher.php?teacher_id=" . $teacher_id . "';
            </script>";
        }
    } else {
        echo "<script>
            alert('Please fill in all fields.');
            window.location.href = 'update_teacher.php?teacher_id=" . $teacher_id . "';
        </script>";
    }
}
?>

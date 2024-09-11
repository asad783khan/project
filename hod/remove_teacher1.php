<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db_connect.php';  // Ensure this file connects to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = $_POST['teacher_id'];

    if ($teacher_id) {
        // Begin transaction
        $conn->begin_transaction();

        try {
            // Remove assignments from teacher_courses
            $delete_assignments_stmt = $conn->prepare("DELETE FROM teacher_courses WHERE teacher_id = ?");
            $delete_assignments_stmt->bind_param("i", $teacher_id);

            if (!$delete_assignments_stmt->execute()) {
                throw new Exception("Error removing assignments: " . $delete_assignments_stmt->error);
            }

            // Remove teacher from teachers table
            $delete_teacher_stmt = $conn->prepare("DELETE FROM teachers WHERE id = ?");
            $delete_teacher_stmt->bind_param("i", $teacher_id);

            if (!$delete_teacher_stmt->execute()) {
                throw new Exception("Error removing teacher: " . $delete_teacher_stmt->error);
            }

            // Commit transaction
            $conn->commit();
            $message = "Teacher and their assigned courses removed successfully!";
            $redirect_url = "hod_portal.php";
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $conn->rollback();
            $message = "Error: " . $e->getMessage();
            $redirect_url = "remove_teacher.php";
        }

        // Close the connection
        $conn->close();

        // Redirect with a JavaScript confirmation
        echo "
            <script>
                alert('$message');
                var userChoice = confirm('Press OK to go back to the HOD Portal, or Cancel to stay on this page.');
                if (userChoice) {
                    window.location.href = '$redirect_url';
                } else {
                    window.location.href = 'remove_teacher.php';
                }
            </script>
        ";
    } else {
        echo "Please select a teacher.";
    }
}
?>

<?php
session_start();

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    header('Location: ../auth/dlms-login.html');
    exit();
}

// Get teacher ID, semester, and selected course from session or request
$teacher_id = $_SESSION['teacher_id'];
$semester = isset($_GET['semester']) ? $_GET['semester'] : null;
$course_title = isset($_GET['course_title']) ? $_GET['course_title'] : null;

// Database connection
include '../db_connect.php';

// Debugging: Output the semester and course_title values being used
echo "Semester: " . $semester . "<br>";
echo "Course Title: " . $course_title . "<br>";

// Fetch students who are enrolled in the selected course
$query = "
    SELECT students.id, students.college_roll_number, students.uni_roll_number, students.name 
    FROM students
    JOIN enrollments ON students.id = enrollments.student_id
    WHERE enrollments.course_title = ? AND enrollments.semester = ?";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("MySQL error: " . $conn->error);
}

$stmt->bind_param("si", $course_title, $semester);
$stmt->execute();
$students = $stmt->get_result();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_attendance'])) {
    // Check if attendance data is submitted and is an array
    if (isset($_POST['attendance']) && is_array($_POST['attendance'])) {
        // Validate the semester before proceeding
        $semester_query = "SELECT semester FROM courses WHERE semester = ?";
        $semester_stmt = $conn->prepare($semester_query);
        $semester_stmt->bind_param("i", $semester);
        $semester_stmt->execute();
        $result = $semester_stmt->get_result();

        // Debugging: Check if the semester exists in the courses table
        if ($result->num_rows > 0) {
            // If semester is valid, proceed with attendance insertion
            foreach ($_POST['attendance'] as $student_id => $status) {
                $attendance_status = $status == 'on' ? 'Present' : 'Absent';
                $attendance_date = date('Y-m-d');

                $insert_query = "INSERT INTO attendance (teacher_id, student_id, course_title, semester, session, attendance_date, status) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                if ($insert_stmt === false) {
                    die("MySQL error: " . $conn->error);
                }

                $insert_stmt->bind_param("iisiiss", $teacher_id, $student_id, $course_title, $semester, $session, $attendance_date, $attendance_status);
                if ($insert_stmt->execute()) {
                    echo "Attendance for student ID {$student_id} submitted successfully!<br>";
                } else {
                    echo "Error: " . $insert_stmt->error . "<br>";
                }
            }
        } else {
            echo "Invalid semester. Please select a valid semester.";
        }
    } else {
        echo "No attendance data submitted.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="teacher_portal5.css">
</head>
<body>
    <h1>Mark Attendance - Course: <?php echo $course_title; ?>, Semester: <?php echo $semester; ?></h1>

    <?php if ($students->num_rows > 0) { ?>
        <form method="POST" action="">
            <table>
                <thead>
                    <tr>
                        <th>College Roll Number</th>
                        <th>University Roll Number</th>
                        <th>Name</th>
                        <th>Present</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($student = $students->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $student['college_roll_number']; ?></td>
                            <td><?php echo $student['uni_roll_number']; ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <td>
                                <input type="checkbox" name="attendance[<?php echo $student['id']; ?>]" checked>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" name="submit_attendance">Submit Attendance</button>
        </form>
    <?php } else { ?>
        <p>No students enrolled in this course for this semester.</p>
    <?php } ?>
</body>
</html>

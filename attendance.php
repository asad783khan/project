<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mark attendance
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $status = $_POST['status'];

    $query_attendance = "INSERT INTO attendance (student_id, course_id, date, status) VALUES ($student_id, $course_id, CURDATE(), '$status')";
    mysqli_query($conn, $query_attendance);
}

// Fetch attendance reports
$teacher_id = $_SESSION['teacher_id'];
$query_reports = "SELECT * FROM attendance WHERE course_id IN (SELECT course_id FROM courses WHERE teacher_id = $teacher_id)";
$result_reports = mysqli_query($conn, $query_reports);
?>

<h2>Attendance Management</h2>
<form method="post">
    <label for="student_id">Student ID:</label>
    <input type="text" name="student_id" required>
    <label for="course_id">Course ID:</label>
    <input type="text" name="course_id" required>
    <label for="status">Status:</label>
    <select name="status">
        <option value="Present">Present</option>
        <option value="Absent">Absent</option>
        <option value="Late">Late</option>
    </select>
    <button type="submit">Mark Attendance</button>
</form>

<h3>Attendance Reports</h3>
<ul>
    <?php while ($report = mysqli_fetch_assoc($result_reports)) : ?>
        <li>Student ID: <?php echo $report['student_id']; ?> - Status: <?php echo $report['status']; ?> - Date: <?php echo $report['date']; ?></li>
    <?php endwhile; ?>
</ul>

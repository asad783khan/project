<?php
include 'db_connect.php';
session_start();

// Fetch teacher's courses
$teacher_id = $_SESSION['teacher_id'];
$query_courses = "SELECT * FROM courses WHERE teacher_id = $teacher_id";
$result_courses = mysqli_query($conn, $query_courses);

// Fetch notifications
$query_notifications = "SELECT * FROM notifications WHERE teacher_id = $teacher_id";
$result_notifications = mysqli_query($conn, $query_notifications);
?>

<h2>Dashboard</h2>
<h3>Your Courses</h3>
<ul>
    <?php while ($course = mysqli_fetch_assoc($result_courses)) : ?>
        <li><?php echo $course['course_name']; ?></li>
    <?php endwhile; ?>
</ul>

<h3>Notifications and Events</h3>
<ul>
    <?php while ($notification = mysqli_fetch_assoc($result_notifications)) : ?>
        <li><?php echo $notification['notification_content']; ?> - <?php echo $notification['event_date']; ?></li>
    <?php endwhile; ?>
</ul>

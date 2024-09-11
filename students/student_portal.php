<?php
session_start();
include "db_connect.php"; // Database connection

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/student_login.html"); // Redirect to login if not authenticated
    exit();
}

// Get the semester of the logged-in student
$semester = $_SESSION['semester'];

// Fetch courses for the student's semester
$sql = "SELECT * FROM courses WHERE semester='$semester'";
$result = $conn->query($sql);
$courses = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link rel="stylesheet" href="student_styles.css"> <!-- Link to your CSS file -->
</head>
<body>

    <!-- Navbar -->
    <header>
        <div class="navbar-container">
            <div class="logo">DLMS</div>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="../index.html">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Dashboard -->
    <main>
        <h1>Welcome, <?php echo $_SESSION['student_name']; ?></h1>
        <div class="overview">
            <div class="stat">
                <h2>Current Semester</h2>
                <p><?php echo $semester; ?></p>
            </div>
            <!-- Additional stats can be added here -->
        </div>

        <!-- Gallery Section -->
 <!-- Gallery Section -->
<section class="gallery">
    <?php foreach ($courses as $course): ?>
        <?php 
            // Define the path to the default image
            $defaultImage = '../images/4cd8282c47ab.jpeg'; 
            // Use course image if available, otherwise use the default image
            $courseImage = !empty($course['course_image']) ? 'images/' . $course['course_image'] : $defaultImage;
        ?>
        <div class="gallery-item">
            <img src="<?php echo $courseImage; ?>" alt="<?php echo $course['course_title']; ?>">
            <!-- Course Title below the image -->
            <h2 class="course-title"><?php echo $course['course_title']; ?></h2>
            <div class="overlay">
                <div class="options">
                    <a href="#" class="btn">Assignment</a>
                    <a href="#" class="btn">Attendance</a>
                    <a href="#" class="btn">Quiz</a>
                    <a href="#" class="btn">Presentation</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>

    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 DLMS. All rights reserved.</p>
    </footer>

    <script src="script.js"></script> <!-- Link to your JavaScript -->
</body>
</html>

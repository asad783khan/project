<?php
// Start session
session_start();

// Check if teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    header('Location: ../auth/dlms-login.html');
    exit();
}

// Get the teacher's assigned semesters and ID from the session
$semesters = $_SESSION['semesters'];
$teacher_id = $_SESSION['teacher_id'];

// Database connection
include '../db_connect.php';  // Assuming you have a db_connect.php file for DB connection

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch subjects (now course titles) for each semester the teacher is assigned to
$subjects = [];
$total_courses = 0; // Variable to hold the total number of courses

foreach ($semesters as $semester) {
    $query = "
        SELECT c.course_title 
        FROM teacher_courses tc 
        JOIN courses c ON tc.course_id = c.id 
        WHERE tc.teacher_id = ? AND tc.semester = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('ii', $teacher_id, $semester);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $subjects[$semester] = [];
        while ($row = $result->fetch_assoc()) {
            $subjects[$semester][] = $row['course_title'];
            $total_courses++; // Increment the total courses counter
        }
        $stmt->close();
    } else {
        // Print an error message if prepare() fails
        echo "Error preparing statement: " . $conn->error;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Teachers Portal</title>
    <link rel="stylesheet" href="teacher_portal5.css">
</head>
<body>
    <header>
        <nav>
            <div class="navbar-container">
                <!-- Logo on the left side -->
                <h2 class="logo">DLMS</h2>
                <ul>
                    <li><a href="../library/library.php">Library</a></li>
                    <li><a href="../hod/hod_portal.php">Hod Portal</a></li>
                    <li><a href="communication.html">Communication</a></li>
                    <li><a href="profile.html">Profile</a></li>
                    <li><a href="../auth/logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section id="dashboard">
            <h1>Dashboard</h1>
            <div class="overview">
                <div class="stat">
                    <h2>Semesters Being Taught</h2>
                    <p id="courses-count"><?php echo count($semesters); ?></p>
                </div>
                <div class="stat">
                    <h2>Total Courses Taught</h2>
                    <p id="total-courses-count"><?php echo $total_courses; ?></p>
                </div>
            </div>

            <!-- Gallery Section -->
            <div class="gallery">
    <?php foreach ($semesters as $semester): ?>
    <div class="gallery-item" data-semester="<?php echo $semester; ?>">
        <img src="../images/semester-word-on-blue-table-260nw-1684997986.webp" alt="Semester <?php echo $semester; ?>">
        <div class="overlay">
            <h4 class="semester-label">Semester <?php echo $semester; ?></h4> <!-- Semester displayed on the image -->
            <select class="subject-dropdown" onchange="showOptions(this)">
                <option value="">Select Course</option>
                <?php foreach ($subjects[$semester] as $course_title): ?>
                <option value="<?php echo $course_title; ?>"><?php echo $course_title; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="options" style="display: none;">
                <a href="attendance.php" class="btn">Attendance</a>
                <a href="assignment.html" class="btn">Assignment</a>
                <a href="quiz.html" class="btn">Quiz</a>
            </div>
        </div>
        <h4 class="semester-label">Semester <?php echo $semester; ?></h4>
    </div>
    <?php endforeach; ?>
</div>

        </section>
    </main>

    <footer>
        <p>&copy; 2024 Department Learning Management System. All rights reserved.</p>
    </footer>

    <script>
    function showOptions(selectElement) {
        // Hide all options divs initially
        var allOptions = document.querySelectorAll('.options');
        allOptions.forEach(function(optionsDiv) {
            optionsDiv.style.display = 'none';
        });

        // Display the options for the selected course
        var selectedCourse = selectElement.value;
        var optionsDiv = selectElement.nextElementSibling;

        if (selectedCourse) {
            optionsDiv.style.display = 'block';
        } else {
            optionsDiv.style.display = 'none';
        }
    }
    </script>
</body>
</html>

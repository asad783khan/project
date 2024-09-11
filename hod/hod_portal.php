<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Portal | DLMS</title>
    <link rel="stylesheet" href="hod_portal6.css">
</head>
<body>
    <!-- Top Navbar -->
    <header id="top-navbar">
        <div class="logo">
            <h1>DLMS</h1>
        </div>
        <nav>
            <ul>
                <li><a href="../library/library.php">Library</a></li>
                <li><a href="reports.html">Reports</a></li>
                <li><a href="../teacher/teacher_portal.php">Teacher</a></li>
                <li><a href="profile.html">Profile</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Register</a>
                    <div class="dropdown-content">
                        <a href="../auth/admin_register.html">Admin</a>
                        <a href="../auth/teacher_register.html">Teacher</a>
                        <a href="../auth/student_register.html">Student</a>
                    </div>
                </li>
                <li><a href="../auth/logout.php" id="logout">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Management Gallery -->
        <section class="management-gallery">
            <!-- Manage Teachers -->
            <div class="gallery-item">
                <img src="../images/download (4).jpg" alt="Manage Teachers">
                <div class="overlay">
                    <div class="overlay-content">
                        <h2>Assign courses</h2>
                        <a href="assign_subjects.php" class="manage-btn" id="add-teacher">Add</a>
                        <a href="remove_teacher.php" class="manage-btn" id="remove-teacher">Remove</a>
                        <a href="update_teacher.php" class="manage-btn" id="update-teacher">Update</a>
                        <a href="view_teacher.php" class="manage-btn" id="update-teacher">View</a>
                    </div>
                </div>
                <p>Assign course to any teacher and remove any teacher and update  Click on this image</p>
            </div>

            <!-- Manage Students -->
            <div class="gallery-item">
                <img src="../images/stidents-1600x700-1.jpg" alt="Manage Students">
                <div class="overlay">
                    <div class="overlay-content">
                        <h2>Manage Students</h2>
                        <a href="add_student.html" class="manage-btn" id="add-student">Add</a>
                        <a href="remove_student.html" class="manage-btn" id="remove-student">Remove</a>
                        <a href="update_student.html" class="manage-btn" id="update-student">Update</a>
                    </div>
                </div>
                <p>Add, remove and update any student data click on this image. Click on this image</p>
            </div>

            <!-- Manage Courses -->
            <div class="gallery-item">
                <img src="../images/images.jpg" alt="Manage Courses">
                <div class="overlay">
                    <div class="overlay-content">
                        <h2>Manage Courses</h2>
                        <a href="add_course1.php" class="manage-btn" id="add-course">Add</a>
                        <a href="remove-course.php" class="manage-btn" id="remove-course">Remove</a>
                        <a href="update-courses.php" class="manage-btn" id="update-course">Update</a>
                    </div>
                 
                </div>
                <p>Add, remove and update courses and outlines. Click on this image</p>
            </div>
        </section>
    </main>
  
    <script src="hod_portal.js" defer></script>
</body>

</html>

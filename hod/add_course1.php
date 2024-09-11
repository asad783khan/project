<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course | HOD Portal</title>
    <link rel="stylesheet" href="add_course1.css">
</head>
<body>
    <!-- Top Navbar -->
    <header id="top-navbar">
        <div class="logo">
            <h1>DLMS</h1>
        </div>
        <nav>
            <ul>
            <li><a href="hod_portal.php">Home</a></li>
                <li><a href="../library/library.php">Library</a></li>
                <li><a href="reports.html">Reports</a></li>
                <li><a href="communication.html">Communication</a></li>
                <li><a href="profile.html">Profile</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Register</a>
                    <div class="dropdown-content">
                        <a href="auth/admin_register.html">Admin</a>
                        <a href="auth/teacher_register.html">Teacher</a>
                        <a href="auth/student_register.html">Student</a>
                    </div>
                </li>
                <li><a href="logout.php" id="logout">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Add Course Form -->
        <section class="add-course-section">
            <h2>Add Course</h2>
            <form action="add_course.php" method="POST">
                <label for="semester">Semester:</label>
                <select id="semester" name="semester" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>

                <label for="course_code">Course Code:</label>
                <input type="text" id="course_code" name="course_code" required>

                <label for="course_title">Course Title:</label>
                <input type="text" id="course_title" name="course_title" required>

                <label for="author_name">Author Name:</label>
                <input type="text" id="author_name" name="author_name" required>

                <label for="course_outline">Course Outline:</label>
                <textarea id="course_outline" name="course_outline" rows="4" required></textarea>

                <button type="submit">Add Course</button>
            </form>

          
        </section>
    </main>

    <script src="add_course1.js" defer></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses | HOD Portal</title>
    <link rel="stylesheet" href="remove_courses.css">
</head>
<body>
    <!-- Top Navbar -->
    <header id="top-navbar">
        <div class="logo">
            <h1>DLMS</h1>
        </div>
        <nav>
            <ul>
                <li><a href="library/library.php">Library</a></li>
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
        <!-- Filter Courses by Semester -->
        <section class="filter-courses-section">
            <h2>Filter Courses</h2>
            <form action="" method="GET">
                <label for="filter-semester">Select Semester:</label>
                <select id="filter-semester" name="semester" required>
                    <option value="">Select Semester</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
                <button type="submit">Filter</button>
            </form>
        </section>

        <!-- Display Courses -->
        <section class="add-course-section">
            <h2>Existing Courses</h2>
            <form id="update-courses-form" action="update_courses.php" method="POST">
                <table id="course-table">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Course Code</th>
                            <th>Course Title</th>
                            <th>Author Name</th>
                            <th>Semester</th>
                            <th>Course Outline</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="course-display">
                        <?php
                        include '../db_connect.php';

                        $semester_filter = isset($_GET['semester']) ? $_GET['semester'] : '';

                        $query = "SELECT * FROM courses";
                        if ($semester_filter) {
                            $query .= " WHERE semester = ?";
                        }

                        $stmt = $conn->prepare($query);

                        if ($semester_filter) {
                            $stmt->bind_param("i", $semester_filter);
                        }

                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><input type='checkbox' name='courses[]' value='" . htmlspecialchars($row['id']) . "'></td>";
                                echo "<td>" . htmlspecialchars($row['course_code']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['course_title']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['author_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['course_outline']) . "</td>";
                                echo "<td><a href='update_course.php?id=" . htmlspecialchars($row['id']) . "' class='update-button'>Update</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No courses found</td></tr>";
                        }

                        $stmt->close();
                        $conn->close();
                        ?>
                    </tbody>
                </table>
                <!-- The button to update courses, if you want it to be a general update button -->
                <!-- <button type="submit">Update Selected Courses</button> -->
            </form>
        </section>
    </main>

    <script src="add_course1.js" defer></script>
</body>
</html>

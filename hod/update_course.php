<?php
include '../db_connect.php';

$course_id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$course_id) {
    echo "Invalid course ID.";
    exit;
}

// Fetch course data
$query = "SELECT * FROM courses WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$course) {
    echo "Course not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course | HOD Portal</title>
    <link rel="stylesheet" href="remove_courses.css">
</head>
<body>
    <header id="top-navbar">
        <div class="logo">
            <h1>DLMS</h1>
        </div>
        <nav>
            <ul>
                <!-- Include your navigation items here -->
            </ul>
        </nav>
    </header>

    <main>
        <section class="update-course-section">
            <h2>Update Course</h2>
            <form action="update_course_action.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($course['id']); ?>">
                
                <label for="course_code">Course Code:</label>
                <input type="text" id="course_code" name="course_code" value="<?php echo htmlspecialchars($course['course_code']); ?>" required>
                
                <label for="course_title">Course Title:</label>
                <input type="text" id="course_title" name="course_title" value="<?php echo htmlspecialchars($course['course_title']); ?>" required>
                
                <label for="author_name">Author Name:</label>
                <input type="text" id="author_name" name="author_name" value="<?php echo htmlspecialchars($course['author_name']); ?>" required>
                
                <label for="semester">Semester:</label>
                <select id="semester" name="semester" required>
                    <option value="">Select Semester</option>
                    <option value="1" <?php if ($course['semester'] == '1') echo 'selected'; ?>>1</option>
                    <option value="2" <?php if ($course['semester'] == '2') echo 'selected'; ?>>2</option>
                    <option value="3" <?php if ($course['semester'] == '3') echo 'selected'; ?>>3</option>
                    <option value="4" <?php if ($course['semester'] == '4') echo 'selected'; ?>>4</option>
                    <option value="5" <?php if ($course['semester'] == '5') echo 'selected'; ?>>5</option>
                    <option value="6" <?php if ($course['semester'] == '6') echo 'selected'; ?>>6</option>
                    <option value="7" <?php if ($course['semester'] == '7') echo 'selected'; ?>>7</option>
                    <option value="8" <?php if ($course['semester'] == '8') echo 'selected'; ?>>8</option>
                </select>
                
                <label for="course_outline">Course Outline:</label>
                <textarea id="course_outline" name="course_outline" required><?php echo htmlspecialchars($course['course_outline']); ?></textarea>
                
                <button type="submit">Update Course</button>
            </form>
        </section>
    </main>
</body>
</html>

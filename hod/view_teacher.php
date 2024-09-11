<?php
include "db_connect.php";

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch teachers and their assigned courses
$teachers = [];
$subjects = [];

try {
    // Fetch teachers and their assigned courses
    $query = 'SELECT 
    t.id AS teacher_id, 
    t.name AS teacher_name, 
    t.email, 
    t.department, 
    tc.semester, 
    GROUP_CONCAT(c.course_title SEPARATOR \',\') AS courses
FROM 
    teachers t
LEFT JOIN 
    teacher_courses tc ON t.id = tc.teacher_id
LEFT JOIN 
    courses c ON tc.course_id = c.id
GROUP BY 
    t.id, tc.semester
ORDER BY 
    t.id, tc.semester';
    
    $result = $conn->query($query);

    if ($result === false) {
        throw new Exception("Error executing teachers query: " . $conn->error);
    }

    $teachers = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch subjects (courses)
    $query = 'SELECT id, course_title FROM courses';
    $result = $conn->query($query);

    if ($result === false) {
        throw new Exception("Error executing subjects query: " . $conn->error);
    }

    $subjects = $result->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers and Courses</title>
    <link rel="stylesheet" href="view_teacher.css">
</head>
<body>
    <div class="container">
        <h1>Teachers and Their Assigned Courses</h1>
        
        <!-- Display Data in a Table -->
        <table id="teachersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Semester</th>
                    <th>Courses</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($teachers)): ?>
                    <?php foreach ($teachers as $teacher): ?>
                        <tr>
                            <td><?= htmlspecialchars($teacher['teacher_id']) ?></td>
                            <td><?= htmlspecialchars($teacher['teacher_name']) ?></td>
                            <td><?= htmlspecialchars($teacher['email']) ?></td>
                            <td><?= htmlspecialchars($teacher['department']) ?></td>
                            <td><?= htmlspecialchars($teacher['semester']) ?></td>
                            <td><?= htmlspecialchars($teacher['courses']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No teachers found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="assign_subjects.php">Assign Subjects to Teachers</a>
    </div>
</body>
</html>

<?php
include "db_connect.php";

// Fetch teachers and subjects
$teachers = [];
$subjects = [];

try {
    // Fetch teachers
    $query = 'SELECT id, name FROM teachers';
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
    <title>Assign Subjects</title>
    <link rel="stylesheet" href="assign_subjects.css">
    <script src="assign_subjects.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Assign Subjects to Teachers</h1>
        
        <!-- Form to assign subjects to a teacher -->
        <form id="assignCourseForm" method="POST" action="process_assignment.php">
            <label for="teacher">Teacher:</label>
            <select id="teacher" name="teacher" required>
                <?php if (!empty($teachers)): ?>
                    <?php foreach ($teachers as $teacher): ?>
                        <option value="<?= htmlspecialchars($teacher['id']) ?>"><?= htmlspecialchars($teacher['name']) ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">No teachers available</option>
                <?php endif; ?>
            </select>

            <label for="subjects">Subjects (Courses):</label>
            <select id="subjects" name="subjects[]" multiple required>
                <?php if (!empty($subjects)): ?>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= htmlspecialchars($subject['id']) ?>"><?= htmlspecialchars($subject['course_title']) ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">No subjects available</option>
                <?php endif; ?>
            </select>

            <label for="semester">Semester:</label>
            <input type="number" id="semester" name="semester" required>

            <button type="submit">Assign Courses</button>
        </form>

        <div id="message"></div>
    </div>
</body>
</html>

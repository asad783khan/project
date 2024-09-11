<?php
require 'db_connect.php';

// Check the column names in the courses table
$checkColumnsQuery = "SHOW COLUMNS FROM courses";
$columnsResult = $conn->query($checkColumnsQuery);

$columns = [];
if ($columnsResult) {
    while ($column = $columnsResult->fetch_assoc()) {
        $columns[] = $column['Field'];
    }
} else {
    die("Error fetching columns: " . $conn->error);
}

if (!in_array('course_title', $columns)) {
    die("Column 'course_title' does not exist in the 'courses' table.");
}

// SQL query to fetch data from teachers and teacher_courses
$query = "
    SELECT 
        teachers.id,
        teachers.name,
        teacher_courses.semester,
        GROUP_CONCAT(courses.course_title SEPARATOR ', ') AS subject,
        teachers.department,
        teachers.email
    FROM 
        teachers
    JOIN 
        teacher_courses ON teachers.id = teacher_courses.teacher_id
    JOIN 
        courses ON teacher_courses.course_id = courses.id
    GROUP BY
        teachers.id, teacher_courses.semester, teachers.department, teachers.email
";

// Execute the query and check for errors
$result = $conn->query($query);

if (!$result) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Assigned Subjects</title>
    <link rel="stylesheet" href="update_teacher.css"> <!-- Your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Update Assigned Subjects</h1>

        <label for="search-name">Search by Name:</label>
        <input type="text" id="search-name" placeholder="Enter teacher's name">
        <button type="button" id="search-button">Search</button>

        <table id="teacher-table" border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Semester</th>
                    <th>Subject</th>
                    <th>Department</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if the query returned any results
                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['semester']}</td>
                                <td>{$row['subject']}</td>
                                <td>{$row['department']}</td>
                                <td>{$row['email']}</td>
                                <td><button onclick=\"updateTeacher({$row['id']})\">Update</button></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No teachers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Search functionality
        document.getElementById('search-button').addEventListener('click', function() {
            const searchValue = document.getElementById('search-name').value.toLowerCase();
            const rows = document.querySelectorAll('#teacher-table tbody tr');

            rows.forEach(row => {
                const nameCell = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (nameCell.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Example function to handle the update action
        function updateTeacher(teacherId) {
            alert('Update teacher with ID: ' + teacherId);
            // Redirect or open a modal to update the teacher details
        }
    </script>
</body>
</html>

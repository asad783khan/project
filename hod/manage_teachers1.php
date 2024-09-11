<?php
session_start();
require 'db_connect.php'; // Adjust the path as needed

// Check if user is logged in and is an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: auth/dlms-login.html");
    exit();
}

// Fetch all teachers from the database
$query = "SELECT teacher_id, username, subject FROM teacher";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error retrieving teacher data.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers | DLMS</title>
    <link rel="stylesheet" href="hod_portal.css">
    <script src="hod_portal.js" defer></script>
</head>
<body>
    <header id="top-navbar">
        <!-- Navbar code as in your previous example -->
    </header>

    <main>
        <section id="manage-teachers">
            <h1>Manage Teachers</h1>
            <button id="add-teacher">Add Teacher</button>
            <button id="remove-teacher">Remove Teacher</button>
            <button id="update-teacher">Update Teacher</button>
            <button id="performance-report">Performance Reports</button>

            <!-- Teacher List Table -->
            <table id="teacher-list">
                <thead>
                    <tr>
                        <th>Teacher ID</th>
                        <th>Username</th>
                        <th>Subject</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['teacher_id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['subject']; ?></td>
                            <td>
                                <button class="edit-teacher" data-id="<?php echo $row['teacher_id']; ?>">Edit</button>
                                <button class="delete-teacher" data-id="<?php echo $row['teacher_id']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Department Learning Management System. All rights reserved.</p>
    </footer>
</body>
</html>

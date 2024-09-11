<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Teacher</title>
    <link rel="stylesheet" href="remove_teacher.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Remove Teacher</h1>
        <form action="remove_teacher1.php" method="POST" onsubmit="return confirmDelete()">
            <label for="teacher_id">Select Teacher:</label>
            <select name="teacher_id" id="teacher_id" required>
                <option value="">Select a teacher</option>
                <?php
                require 'db_connect.php';

                // Check if connection was successful
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query the database for teachers
                $query = "SELECT id, name FROM teachers";  // Updated to reflect correct column names
                $result = $conn->query($query);

                // Check if the query was successful
                if ($result) {
                    // Fetch and display options
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                } else {
                    echo "<option value=''>Error: " . $conn->error . "</option>";
                }

                // Close the connection
                $conn->close();
                ?>
            </select>
            <button type="submit">Remove Teacher</button>
        </form>
    </div>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to remove this teacher? This will also remove their assigned courses.");
        }
    </script>
</body>
</html>

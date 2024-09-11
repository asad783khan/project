<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch courses for a specific semester
$semester = 1; // Replace with dynamic semester value if needed
$sql = "SELECT * FROM courses WHERE semester = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $semester);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);

// Close the connection
$stmt->close();
$conn->close();
?>

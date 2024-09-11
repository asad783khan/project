<?php
include "db_connect.php";

header('Content-Type: application/json');

// Query the teachers table
$sql = "SELECT id, name FROM teachers";
$result = $conn->query($sql);

$teachers = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teachers[] = $row;
    }
}

// Close the connection
$conn->close();

// Output JSON
echo json_encode($teachers);
?>

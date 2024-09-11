<?php
require 'db_connect.php';

$semester_type = $_GET['semester_type'];

$query = "SELECT id, name FROM semesters WHERE semester_type = '$semester_type'";
$result = $conn->query($query);

$semesters = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $semesters[] = $row;
    }
}

echo json_encode($semesters);
?>

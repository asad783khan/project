<?php
include "db_connect.php";

$sql = "SELECT id, course_name FROM courses";
$result = $conn->query($sql);

$subjects = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $subjects[] = $row;
    }
}
echo json_encode($subjects);

$conn->close();
?>

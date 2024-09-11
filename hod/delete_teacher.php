<?php
require 'db_connect.php';

if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];

    $query = "DELETE FROM teacher WHERE teacher_id=$teacher_id";

    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>

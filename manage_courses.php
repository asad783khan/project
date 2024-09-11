<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Upload course material
    $course_id = $_POST['course_id'];
    $material_name = $_FILES['course_material']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($material_name);

    move_uploaded_file($_FILES['course_material']['tmp_name'], $target_file);

    $query_upload = "UPDATE courses SET course_materials = '$target_file' WHERE course_id = $course_id";
    mysqli_query($conn, $query_upload);
}

// Fetch teacher's courses
$teacher_id = $_SESSION['teacher_id'];
$query_courses = "SELECT * FROM courses WHERE teacher_id = $teacher_id";
$result_courses = mysqli_query($conn, $query_courses);
?>

<h2>Manage Courses</h2>
<form method="post" enctype="multipart/form-data">
    <label for="course_id">Select Course:</label>
    <select name="course_id">
        <?php while ($course = mysqli_fetch_assoc($result_courses)) : ?>
            <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
        <?php endwhile; ?>
    </select>
    <label for="course_material">Upload Material:</label>
    <input type="file" name="course_material">
    <button type="submit">Upload</button>
</form>

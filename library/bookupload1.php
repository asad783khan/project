<?php
session_start();
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseCode = $_POST['courseCode'];
    $bookName = $_POST['bookName'];
    $authorName = $_POST['authorName'];

    // Directory to upload files
    $targetDir = "uploads/";
    $fileName = basename($_FILES["bookFile"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if directory exists, if not create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Check if the file is a PDF
    if ($fileType != "pdf") {
        echo "Only PDF files are allowed.";
        exit;
    }

    // Upload the file
    if (move_uploaded_file($_FILES["bookFile"]["tmp_name"], $targetFilePath)) {
        // Insert book information into the database
        $sql = "INSERT INTO books (course_code, book_name, author_name, file_path) 
                VALUES ('$courseCode', '$bookName', '$authorName', '$targetFilePath')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to upload page with a success message
            header("Location: bookupload.php?success=1");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "There was an error uploading your file. Please check the folder permissions and ensure it is writable.";
    }
}

$conn->close();
?>

<?php

include '../db_connect.php';

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    // Prepare and execute the deletion query
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $bookId);

    if ($stmt->execute()) {
        // If successful, redirect to the library page
        header('Location: library.php?msg=Book deleted successfully');
    } else {
        // If there's an error, display it
        echo "Error deleting book: " . $conn->error;
    }
} else {
    echo "No book ID provided.";
}

// Close the connection
$conn->close();
?>

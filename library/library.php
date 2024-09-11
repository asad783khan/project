<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Library</title>
    <link rel="stylesheet" href="library.css">
</head>
<body>
    <header>
        <h1>Digital Library</h1>
        <nav>
            <ul>
                <li><a href="../hod/hod_portal.php">Home</a></li>
                <li><a href="bookupload.php">Upload</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="librarySection">
            <h2>Library</h2>
            <div id="bookList">
                <?php
                include '../db_connect.php';
                $sql = "SELECT * FROM books";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='book'>";
                        echo "<h3>" . $row['book_name'] . "</h3>";
                        echo "<p>Course Code: " . $row['course_code'] . "</p>";
                        echo "<p>Author: " . $row['author_name'] . "</p>";
                        echo "<a href='" . $row['file_path'] . "' target='_blank'>Read Book</a> | ";
                        echo "<a href='" . $row['file_path'] . "' download>Download Book</a> | ";
                        echo "<a href='delete_book.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this book?\")'>Delete Book</a>";
                        echo "</div>";
                    }
                } else {
                    echo "No books found.";
                }
                
                $conn->close();
                ?>
            </div>
        </section>
    </main>
    <script src="script.js"></script>
</body>
</html>

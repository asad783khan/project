<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload a Book</title>
    <link rel="stylesheet" href="bookupload1.css">
    <script>
        function handleSuccess() {
            // Check if the URL contains the success parameter
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === '1') {
                // Show confirmation dialog
                const confirmed = confirm("The book has been uploaded successfully. Do you want to go back to the library?");
                if (confirmed) {
                    window.location.href = 'library.php';
                } else {
                    window.location.href = 'bookupload.php';
                }
            }
        }

        window.onload = handleSuccess;
    </script>
</head>
<body>
    <section id="uploadSection">
        <h2>Upload a Book</h2>
        <form id="uploadForm" action="bookupload1.php" method="post" enctype="multipart/form-data">
            <label for="courseCode">Course Code:</label>
            <input type="text" id="courseCode" name="courseCode" required>
            
            <label for="bookName">Book Name:</label>
            <input type="text" id="bookName" name="bookName" required>
            
            <label for="authorName">Author Name:</label>
            <input type="text" id="authorName" name="authorName" required>
            
            <label for="bookFile">Book File (PDF):</label>
            <input type="file" id="bookFile" name="bookFile" accept=".pdf" required>
            
            <button type="submit">Upload</button>
        </form>
        <br>
           
            <button onclick="window.location.href='Library.php'" class="back-btn">Library</button>
    </section>
</body>
</html>

// script.js

document.addEventListener("DOMContentLoaded", function() {
    fetchBooks();
});

function fetchBooks() {
    fetch('fetch_books.php')
    .then(response => response.json())
    .then(data => {
        const bookList = document.getElementById('bookList');
        bookList.innerHTML = '';

        data.forEach(book => {
            const bookItem = document.createElement('div');
            bookItem.className = 'bookItem';

            const bookTitle = document.createElement('h3');
            bookTitle.textContent = book.book_name;

            const bookAuthor = document.createElement('p');
            bookAuthor.textContent = `Author: ${book.author_name}`;

            const bookCourseCode = document.createElement('p');
            bookCourseCode.textContent = `Course Code: ${book.course_code}`;

            const viewLink = document.createElement('a');
            viewLink.href = book.file_path;
            viewLink.textContent = 'Read Online';
            viewLink.target = '_blank';

            const downloadLink = document.createElement('a');
            downloadLink.href = book.file_path;
            downloadLink.download = book.file_path.split('/').pop();
            downloadLink.textContent = 'Download PDF';

            bookItem.appendChild(bookTitle);
            bookItem.appendChild(bookAuthor);
            bookItem.appendChild(bookCourseCode);
            bookItem.appendChild(viewLink);
            bookItem.appendChild(document.createTextNode(' | ')); // Separator between links
            bookItem.appendChild(downloadLink);

            bookList.appendChild(bookItem);
        });
    })
    .catch(error => {
        console.error('Error fetching books:', error);
    });
}

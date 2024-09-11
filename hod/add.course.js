document.addEventListener('DOMContentLoaded', function() {
    fetch('add_course.php')
        .then(response => response.json())
        .then(data => {
            const courseDisplay = document.getElementById('course-display');
            data.forEach(course => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${course.course_code}</td>
                    <td>${course.course_title}</td>
                    <td>${course.author_name}</td>
                    <td>${course.semester}</td>
                    <td>${course.course_outline}</td>
                `;
                courseDisplay.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching courses:', error));
});

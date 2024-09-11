document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-name');
    const searchButton = document.getElementById('search-button');
    const tableBody = document.querySelector('#teacher-table tbody');

    // Fetch data from the server
    fetch('fetch_teachers.php')
        .then(response => response.json())
        .then(teachers => {
            renderTable(teachers);

            // Filter the table based on the search input
            searchButton.addEventListener('click', () => {
                const searchValue = searchInput.value.toLowerCase();
                const filteredTeachers = teachers.filter(teacher => teacher.name.toLowerCase().includes(searchValue));
                renderTable(filteredTeachers);
            });
        })
        .catch(error => console.error('Error fetching data:', error));

    // Function to render the table rows
    function renderTable(data) {
        tableBody.innerHTML = '';
        data.forEach(teacher => {
            const row = `<tr>
                <td>${teacher.id}</td>
                <td>${teacher.name}</td>
                <td>${teacher.semester}</td>
                <td>${teacher.subject}</td>
                <td>${teacher.department}</td>
                <td>${teacher.email}</td>
                <td>${teacher.password}</td>
                <td><button onclick="updateTeacher(${teacher.id})">Update</button></td>
            </tr>`;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    }
});

// Example function to handle the update action
function updateTeacher(teacherId) {
    alert('Update teacher with ID: ' + teacherId);
}

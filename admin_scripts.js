// admin_scripts.js

document.addEventListener('DOMContentLoaded', () => {
    const loadUsersButton = document.getElementById('load-users');
    const generateReportButton = document.getElementById('generate-report');

    if (loadUsersButton) {
        loadUsersButton.addEventListener('click', loadUsers);
    }

    if (generateReportButton) {
        generateReportButton.addEventListener('click', generateReport);
    }

    function loadUsers() {
        fetch('get_users.php')
            .then(response => response.json())
            .then(data => {
                const userTableBody = document.querySelector('#user-table tbody');
                userTableBody.innerHTML = ''; // Clear existing data
                data.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                        <td>
                            <button onclick="editUser(${user.id})">Edit</button>
                            <button onclick="deleteUser(${user.id})">Delete</button>
                        </td>
                    `;
                    userTableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error loading users:', error));
    }

    function generateReport() {
        fetch('generate_report.php')
            .then(response => response.json())
            .then(data => {
                const reportResults = document.getElementById('report-results');
                reportResults.innerHTML = ''; // Clear existing data
                data.forEach(report => {
                    const div = document.createElement('div');
                    div.textContent = report;
                    reportResults.appendChild(div);
                });
            })
            .catch(error => console.error('Error generating report:', error));
    }
});

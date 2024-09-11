document.getElementById('register-form').addEventListener('submit', function(event) {
    // Perform form validation if needed
    // For example, checking if all fields are filled
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const semester = document.getElementById('semester').value;

    if (!name || !email || !password || !semester) {
        alert('Please fill in all fields.');
        event.preventDefault(); // Prevent form submission
    }
});

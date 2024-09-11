function handleDropdown(role) {
    if (role === 'Admin') {
        // Redirect to the admin registration page or handle as needed
        window.location.href = 'admin_register.html'; // Adjust the path if necessary
    } else if (role === 'Teacher') {
        // Redirect to the teacher registration page
        window.location.href = 'teacher_register.html'; // Adjust the path if necessary
    } else if (role === 'Student') {
        // Redirect to the student registration page
        window.location.href = 'student_register.html'; // Adjust the path if necessary
    }
}


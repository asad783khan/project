
document.addEventListener('DOMContentLoaded', function() {
    // Add fade-in effect for the container
    const container = document.querySelector('.container');
    container.style.opacity = 0;
    container.style.transition = 'opacity 0.5s ease-in-out';
    setTimeout(() => container.style.opacity = 1, 100);

    // Add form validation feedback
    const form = document.getElementById('assignCourseForm');
    form.addEventListener('submit', function(event) {
        const teacherSelect = document.getElementById('teacher');
        const subjectsSelect = document.getElementById('subjects');
        const semesterInput = document.getElementById('semester');
        
        if (!teacherSelect.value || !subjectsSelect.value.length || !semesterInput.value) {
            event.preventDefault();
            document.getElementById('message').textContent = 'Please fill out all fields correctly.';
            document.getElementById('message').style.color = 'red';
        }
    });
});


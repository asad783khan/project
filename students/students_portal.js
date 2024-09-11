// students_portal.js

document.addEventListener('DOMContentLoaded', () => {
    const submitAssignmentForm = document.getElementById('submit-assignment-form');
    const updateProfileForm = document.getElementById('update-profile-form');
    const sendMessageForm = document.getElementById('send-message-form');

    if (submitAssignmentForm) {
        submitAssignmentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Assignment submitted successfully.');
        });
    }

    if (updateProfileForm) {
        updateProfileForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Profile updated successfully.');
        });
    }

    if (sendMessageForm) {
        sendMessageForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Message sent successfully.');
        });
    }

    // Example of dynamic content loading
    loadDashboardData();
    loadCourseMaterials();
    loadAttendanceHistory();
    loadExamSchedule();

    function loadDashboardData() {
        const coursesList = document.getElementById('courses-list');
        const courses = ['Mathematics', 'Physics', 'Computer Science']; // Example courses
        courses.forEach(course => {
            const listItem = document.createElement('li');
            listItem.textContent = course;
            coursesList.appendChild(listItem);
        });
    }

    function loadCourseMaterials() {
        const courseList = document.getElementById('course-list');
        const materials = ['Lecture 1', 'Assignment 1', 'Lecture 2']; // Example materials
        materials.forEach(material => {
            const div = document.createElement('div');
            div.textContent = material;
            courseList.appendChild(div);
        });
    }

    function loadAttendanceHistory() {
        const attendanceHistory = document.getElementById('attendance-history');
        const history = ['September 1: Present', 'September 2: Absent']; // Example history
        history.forEach(record => {
            const div = document.createElement('div');
            div.textContent = record;
            attendanceHistory.appendChild(div);
        });
    }

    function loadExamSchedule() {
        const examList = document.getElementById('exam-list');
        const exams = ['Math Exam: October 10', 'Physics Exam: October 15']; // Example exams
        exams.forEach(exam => {
            const listItem = document.createElement('li');
            listItem.textContent = exam;
            examList.appendChild(listItem);
        });
    }
});

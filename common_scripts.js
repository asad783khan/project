document.addEventListener('DOMContentLoaded', () => {
    // Toggle profile dropdown visibility
    const profileBtn = document.getElementById('profile-btn');
    const profileDropdown = document.getElementById('profile-dropdown');

    profileBtn.addEventListener('click', () => {
        if (profileDropdown.style.display === 'block') {
            profileDropdown.style.display = 'none';
        } else {
            profileDropdown.style.display = 'block';
        }
    });

    // Close dropdown if clicked outside
    document.addEventListener('click', (event) => {
        if (!profileBtn.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.style.display = 'none';
        }
    });

    // Dynamic navigation menu based on user role
    const role = 'student'; // Example role, replace with dynamic role from server
    const navMenu = document.getElementById('nav-menu');

    const menuItems = {
        student: ['Dashboard', 'Course Materials', 'Attendance', 'Results', 'Profile', 'Communication'],
        teacher: ['Dashboard', 'Manage Courses', 'Attendance', 'Communication', 'Profile'],
        hod: ['Dashboard', 'Manage Teachers', 'Manage Courses', 'Reports', 'Communication']
    };

    menuItems[role].forEach(item => {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = `#${item.toLowerCase().replace(' ', '-')}`;
        a.textContent = item;
        li.appendChild(a);
        navMenu.appendChild(li);
    });
});

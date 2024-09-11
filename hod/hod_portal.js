document.addEventListener("DOMContentLoaded", function() {
    const semesterSelect = document.getElementById('semester');
    const subjectSelect = document.getElementById('subject');

    // Populate semester dropdown
    fetch('get_semesters.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(semester => {
                const option = document.createElement('option');
                option.value = semester.id;
                option.textContent = semester.name;
                semesterSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching semesters:', error));

    // Event listener for semester change
    semesterSelect.addEventListener('change', function() {
        const semesterId = this.value;

        fetch(`get_subjects.php?semester_id=${semesterId}`)
            .then(response => response.json())
            .then(data => {
                subjectSelect.innerHTML = ''; // Clear existing options
                data.forEach(subject => {
                    const option = document.createElement('option');
                    option.value = subject.id;
                    option.textContent = subject.name;
                    subjectSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching subjects:', error));
    });
});

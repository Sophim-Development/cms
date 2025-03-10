document.addEventListener('DOMContentLoaded', () => {
    const specializationSelect = document.getElementById('specialization');
    const doctorSelect = document.getElementById('doctors');
    const feesInput = document.getElementById('fees');

    if (specializationSelect && doctorSelect) {
        specializationSelect.addEventListener('change', () => {
            fetch(`/src/user/pages/get_doctors.php?spec_id=${specializationSelect.value}`)
                .then(response => response.json())
                .then(doctors => {
                    doctorSelect.innerHTML = '';
                    doctors.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.id;
                        option.text = `${doctor.doctorName} ($${doctor.docFees})`;
                        doctorSelect.appendChild(option);
                    });
                    feesInput.value = doctors.length > 0 ? doctors[0].docFees : '';
                })
                .catch(error => console.error('Error fetching doctors:', error));
        });

        // Trigger initial load if a specialization is selected
        if (specializationSelect.value) {
            specializationSelect.dispatchEvent(new Event('change'));
        }
    }

    function logout() {
        session_unset();
        session_destroy();
        redirect('/');
    }
});

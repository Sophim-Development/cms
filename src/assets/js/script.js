document.addEventListener('DOMContentLoaded', () => {
    // Specialization and Doctor Selection
    const specializationSelect = document.getElementById('specialization');
    const doctorSelect = document.getElementById('doctors');
    const feesInput = document.getElementById('fees');

    if (specializationSelect && doctorSelect) {
        specializationSelect.addEventListener('change', () => {
            fetch(`/src/user/pages/get_doctors.php?spec_id=${specializationSelect.value}`)
                .then(response => response.json())
                .then(doctors => {
                    doctorSelect.innerHTML = ''; // Clear existing options
                    doctors.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.id;
                        option.text = `${doctor.doctorName} ($${doctor.docFees})`;
                        doctorSelect.appendChild(option);
                    });
                    // Update fees input with the first doctor's fees if available
                    feesInput.value = doctors.length > 0 ? doctors[0].docFees : '';
                })
                .catch(error => console.error('Error fetching doctors:', error));
        });

        // Trigger initial load if a specialization is selected
        if (specializationSelect.value) {
            specializationSelect.dispatchEvent(new Event('change'));
        }
    }

    // Carousel Functionality
    const carousel = document.getElementById('carousel');
    if (carousel){
        const items = carousel.getElementsByClassName('carousel-item');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;
        function showSlide(index) {
            for (let i = 0; i < items.length; i++) {
                items[i].classList.remove('opacity-100');
                items[i].classList.add('opacity-0');
            }
            items[index].classList.remove('opacity-0');
            items[index].classList.add('opacity-100');
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % items.length;
            showSlide(currentIndex);
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + items.length) % items.length;
            showSlide(currentIndex);
        }

        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);

        // Initialize carousel
        showSlide(currentIndex);
    }

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Close mobile menu when a link is clicked
    const mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });
    });

    // Gallery Tab Functionality
    const galleryTabs = document.querySelectorAll('.gallery-tab');
    const galleryItems = document.querySelectorAll('.gallery-item');

    if (galleryTabs) {

        galleryTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs
                galleryTabs.forEach(t => t.classList.remove('active'));
                // Add active class to the clicked tab
                tab.classList.add('active');

                const category = tab.getAttribute('data-category');

                // Filter gallery items based on category
                galleryItems.forEach(item => {
                    const itemCategories = item.className.split(' ').filter(c => c !== 'gallery-item' && c !== 'hidden');
                    if (category === 'all' || itemCategories.includes(category)) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });
        });

        galleryTabs[0].click();
    }
});
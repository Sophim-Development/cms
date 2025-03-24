<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/doctor/services/DoctorService.php';
$doctorService = new DoctorService($con);
$doctors = $doctorService->getAllDoctors();
include __DIR__ . '/includes/header-public.php';
?>
    <section id="home" class="pt-20">
        <!-- Carousel -->
        <div class="relative w-full h-64 sm:h-80 md:h-96 overflow-hidden">
            <div class="carousel" id="carousel">
                <div class="carousel-item absolute w-full h-full flex items-center justify-center transition-opacity duration-500 opacity-0">
                    <img src="./assets/images/slider/slider_1.jpg" alt="Slide 1" class="w-full h-full object-cover">
                    <div class="absolute text-white text-center">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">Hospital Management System</h1>
                    </div>
                </div>
                <div class="carousel-item absolute w-full h-full flex items-center justify-center transition-opacity duration-500 opacity-0">
                    <img src="./assets/images/slider/slider_2.jpg" alt="Slide 2" class="w-full h-full object-cover">
                    <div class="absolute text-white text-center">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">Quality Healthcare</h1>
                    </div>
                </div>
                <div class="carousel-item absolute w-full h-full flex items-center justify-center transition-opacity duration-500 opacity-0">
                    <img src="./assets/images/slider/slider_3.jpg" alt="Slide 3" class="w-full h-full object-cover">
                    <div class="absolute text-white text-center">
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">Expert Team</h1>
                    </div>
                </div>
            </div>
            <button id="prevBtn" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full hover:bg-gray-600">
                <
            </button>
            <button id="nextBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full hover:bg-gray-600">
                >
            </button>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-10 bg-gray-100">
        <div class="container mx-auto text-center">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6">Our Key Features</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
                <div class="p-4">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9H20V4m-8 8v8m4-4H8"></path></svg>
                    <h3 class="text-lg sm:text-xl font-semibold">Cardiology</h3>
                </div>
                <div class="p-4">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2zm0 8c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791-4-4-4z"></ unespath></svg>
                    <h3 class="text-lg sm:text-xl font-semibold">Orthopedic</h3>
                </div>
                <div class="p-4">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <h3 class="text-lg sm:text-xl font-semibold">Neurologist</h3>
                </div>
                <div class="p-4">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path></svg>
                    <h3 class="text-lg sm:text-xl font-semibold">Pharma Pipeline</h3>
                </div>
                <div class="p-4">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a2 2 0 012-2h2a2 2 0 012 2v5m-4 0h4"></path></svg>
                    <h3 class="text-lg sm:text-xl font-semibold">Pharma Team</h3>
                </div>
                <div class="p-4">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0113.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905a3.61 3.61 0 01-.608 2.006L7 10m7-10l-1 1m-6 0l1-1"></path></svg>
                    <h3 class="text-lg sm:text-xl font-semibold">High Quality Treatments</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about-us" class="py-10">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-6 md:mb-0">
                <img src="./assets/images/why.jpg" alt="About Us" class="w-full h-auto rounded-lg shadow-md">
            </div>
            <div class="md:w-1/2 md:pl-8">
                <h2 class="text-2xl sm:text-3xl font-bold mb-4">About Our Hospital</h2>
                <p class="text-sm sm:text-base md:text-lg">
                    The Hospital Management System (HMS) is designed for Any Hospital to replace their existing manual paper based system. The new system is to control the following information; patient information, staff, operating room schedules, patient invoices. These services are to be provided in an efficient, cost effective manner, with the goal of reducing the time and resources currently required for such tasks.<br><br>
                    A significant part of the operation of any hospital involves the acquisition, management and timely retrieval of great volumes of information. This information typically involves; patient personal information and medical history, staff information, room and ward scheduling, staff scheduling, operating theater scheduling and various facilities waiting lists. All of this information must be managed in an efficient and cost wise manner so that an institution's resources may be effectively utilized HMS will automate the management of the hospital making it more efficient and error free. It aims at standardizing data, consolidating data ensuring data integrity and reducing inconsistencies.
                </p>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-10 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-center">Our Gallery</h2>
            <p class="text-sm sm:text-base md:text-lg text-center mb-6">View Our Gallery</p>

            <!-- Tab Navigation -->
            <div class="flex justify-center space-x-4 mb-8">
                <button class="gallery-tab active bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" data-category="all">All</button>
                <button class="gallery-tab bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400" data-category="dental">Dental</button>
                <button class="gallery-tab bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400" data-category="cardiology">Cardiology</button>
                <button class="gallery-tab bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400" data-category="neurology">Neurology</button>
                <button class="gallery-tab bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400" data-category="laboratory">Laboratory</button>
            </div>

            <!-- Gallery Grid -->
            <div class="gallery-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Dental Images -->
                <div class="gallery-item dental">
                    <img src="./assets/images/gallery/gallery_01.jpg" class="w-full h-48 object-cover rounded-lg shadow-md">
                </div>
                <div class="gallery-item dental">
                    <img src="./assets/images/gallery/gallery_02.jpg" class="w-full h-48 object-cover rounded-lg shadow-md">
                </div>

                <!-- Cardiology Images -->
                <div class="gallery-item cardiology">
                    <img src="./assets/images/gallery/gallery_03.jpg" alt="Cardiology Image 1" class="w-full h-48 object-cover rounded-lg shadow-md">
                </div>
                <div class="gallery-item cardiology">
                    <img src="./assets/images/gallery/gallery_04.jpg" alt="Cardiology Image 2" class="w-full h-48 object-cover rounded-lg shadow-md">
                </div>

                <!-- Neurology Images -->
                <div class="gallery-item neurology">
                    <img src="./assets/images/gallery/gallery_05.jpg" alt="Neurology Image 1" class="w-full h-48 object-cover rounded-lg shadow-md">
                </div>
                <div class="gallery-item neurology">
                    <img src="./assets/images/gallery/gallery_06.jpg" alt="Neurology Image 2" class="w-full h-48 object-cover rounded-lg shadow-md">
                </div>

                <!-- Laboratory Images -->
                <div class="gallery-item laboratory">
                    <img src="./assets/images/gallery/gallery_09.jpg" alt="Laboratory Image 1" class="w-full h-48 object-cover rounded-lg shadow-md">
                </div>
                <div class="gallery-item laboratory">
                    <img src="./assets/images/gallery/gallery_08.jpg" alt="Laboratory Image 2" class="w-full h-48 object-cover rounded-lg shadow-md">
                </div>
            </div>
        </div>
    </section>

    <!-- Doctors Section -->
    <section id="doctors" class="py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-center">Our Doctors</h2>
            <p class="text-sm sm:text-base md:text-lg text-center mb-6">Meet our expert medical team</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php
                foreach ($doctors as $doctor) {
                    echo '<div class="doctor-card">';
                    echo '<img src="./assets/images//doctor.jpg" class="mb-4">';
                    echo '<h3 class="text-lg font-semibold">' . htmlspecialchars($doctor['doctorName']) . '</h3>';
                    echo '<p class="text-gray-600">Specialization: ' . htmlspecialchars($doctor['specialization']) . '</p>';
                    echo '<p class="text-gray-600">Fees: $' . htmlspecialchars($doctor['docFees']) . '</p>';
                    echo '<p class="text-gray-600">Contact: ' . (htmlspecialchars($doctor['contact']) ?: 'N/A') . '</p>';
                    echo '<p class="text-gray-600">Email: ' . (htmlspecialchars($doctor['email']) ?: 'N/A') . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section id="contact-us" class="py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-center">Contact Us</h2>
            <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
                <form action="submit_contact.php" method="POST">
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Enter Name:</label>
                        <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm sm:text-base" placeholder="Enter Name">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address:</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm sm:text-base" placeholder="Enter Email">
                    </div>
                    <div class="mb-4">
                        <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile Number:</label>
                        <input type="text" id="mobile" name="mobile" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm sm:text-base" placeholder="Enter Mobile Number">
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-sm font-medium text-gray-700">Enter Message:</label>
                        <textarea id="message" name="message" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm sm:text-base" rows="4" placeholder="Enter Your Message"></textarea>
                    </div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full sm:w-auto">Send Message</button>
                </form>
            </div>
        </div>
    </section>
<?php
include __DIR__ . '/includes/footer-public.php';
?>
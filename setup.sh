#!/bin/bash

# Create root folder
mkdir -p hms

# Create src structure
mkdir -p hms/src/{assets/{css,js},includes,services,admin/{pages,services},doctor/{pages,services},user/{pages,services}}
touch hms/src/assets/css/tailwind.css
touch hms/src/assets/js/script.js
touch hms/src/includes/{config.php,header-public.php,footer-public.php,header-auth.php,footer-auth.php,functions.php}
touch hms/src/services/{AdminService.php,DoctorService.php,UserService.php,AppointmentService.php,SpecializationService.php}
touch hms/src/admin/pages/{login.php,dashboard.php,manage-doctors.php}
touch hms/src/admin/services/AdminService.php
touch hms/src/doctor/pages/{login.php,dashboard.php,appointments.php}
touch hms/src/doctor/services/DoctorService.php
touch hms/src/user/pages/{login.php,register.php,book-appointment.php,get_doctors.php}
touch hms/src/user/services/UserService.php
touch hms/src/{index.php,about.php,contact.php,logout.php}

# Create public structure
mkdir -p hms/public/assets/{css,js}
touch hms/public/assets/css/style.css
touch hms/public/assets/js/script.js  # Empty initially, populated by build
touch hms/public/index.php
touch hms/public/.htaccess

# Create Tailwind-related files
touch hms/tailwind.config.js
touch hms/package.json

echo "HMS project structure created in 'hms/'!"

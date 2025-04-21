<?php
// Load env & DB connection (same as before)
if (getenv('APP_ENV') === 'production') {
    if (file_exists(__DIR__ . '../../vendor/autoload.php')) {
        require_once __DIR__ . '../../vendor/autoload.php';
    } else {
        die("Vendor autoloader not found. Please run 'composer install'.");
    }

    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    } catch (Exception $e) {
        die("Failed to load .env: " . $e->getMessage());
    }
}

define('DB_SERVER', $_ENV['DB_SERVER'] ?? '127.0.0.1');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'cms_db');

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$con) {
    die("MySQL connection error: " . mysqli_connect_error());
}

// Sample user registration data
$users = [
    [
        'full_name' => 'Dr. Lisa Wong',
        'address' => '123 Clinic Rd',
        'city' => 'Phnom Penh',
        'gender' => 'female',
        'email' => 'lisa@example.com',
        'password' => password_hash('secret123', PASSWORD_DEFAULT),
        'role' => 'doctor',
        'specialization_id' => 3,
        'fees' => 150.00
    ],
    [
        'full_name' => 'John Doe',
        'address' => '456 Street',
        'city' => 'Siem Reap',
        'gender' => 'male',
        'email' => 'john@example.com',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'role' => 'patient'
    ]
];

// Insert users
$user_stmt = $con->prepare("INSERT INTO users (full_name, address, city, gender, email, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$user_stmt) {
    die("User insert prepare failed: " . $con->error);
}

foreach ($users as $user) {
    $user_stmt->bind_param("sssssss", $user['full_name'], $user['address'], $user['city'], $user['gender'], $user['email'], $user['password'], $user['role']);
    if ($user_stmt->execute()) {
        echo "User registered: {$user['full_name']}<br>";
        $user_id = $con->insert_id;

        // If doctor, insert into doctors table too
        if ($user['role'] === 'doctor') {
            $doctor_stmt = $con->prepare("INSERT INTO doctors (name, specialization_id, user_id, fees) VALUES (?, ?, ?, ?)");
            if ($doctor_stmt) {
                $doctor_stmt->bind_param("siid", $user['full_name'], $user['specialization_id'], $user_id, $user['fees']);
                if ($doctor_stmt->execute()) {
                    echo "--> Added to doctors table.<br>";
                } else {
                    echo "--> Failed to add doctor: " . $doctor_stmt->error . "<br>";
                }
                $doctor_stmt->close();
            } else {
                echo "Doctor insert prepare failed: " . $con->error . "<br>";
            }
        }
    } else {
        echo "Failed to register user: {$user['email']} - " . $user_stmt->error . "<br>";
    }
}

$user_stmt->close();
$con->close();
?>
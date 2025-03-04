<?php
require_once __DIR__ . '/includes/config.php';

class UserService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function userLogin($email, $password) {
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $user;
    }

    public function registerUser($data) {
        $sql = "INSERT INTO users (fullName, address, city, gender, email, password) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", 
            $data['fullName'],
            $data['address'],
            $data['city'],
            $data['gender'],
            $data['email'],
            $data['password']
        );
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    public function getUserAppointments($userId) {
        $sql = "SELECT a.*, d.doctorName FROM appointment a 
                JOIN doctors d ON a.doctorId = d.id 
                WHERE a.userId = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        return $appointments;
    }
}
?>
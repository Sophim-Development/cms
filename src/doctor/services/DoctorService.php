<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';

class DoctorService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function doctorLogin($email, $password) {
        $sql = "SELECT * FROM doctors WHERE docEmail = ? AND password = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $doctor = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $doctor;
    }
}
<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';

class AdminService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function adminLogin($username, $password) {
        $sql = "SELECT * FROM admin WHERE username = ? AND password = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $admin;
    }
}
<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';

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
}
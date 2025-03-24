<?php
require_once dirname(__DIR__, 1) . '/includes/config.php';

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

    public function getAllDoctors() {
        $sql = "SELECT d.*, ds.specialization as spec_name 
                FROM doctors d 
                JOIN doctorspecialization ds ON d.specialization = ds.id";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        return $doctors;
    }

    public function updateDoctor($id, $data) {
        $sql = "UPDATE doctors SET doctorName = ?, specialization = ?, address = ?, docFees = ?, 
                contactno = ?, docEmail = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "sissssi", 
            $data['doctorName'],
            $data['specialization'],
            $data['address'],
            $data['docFees'],
            $data['contactno'],
            $data['docEmail'],
            $id
        );
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    public function deleteDoctor($id) {
        $sql = "DELETE FROM doctors WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
}
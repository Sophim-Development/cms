<?php
require_once dirname(__DIR__, 1) . '/includes/config.php';

class SpecializationService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllSpecializations() {
        $sql = "SELECT * FROM doctorspecialization";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $specializations = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        return $specializations;
    }

    public function getDoctorsBySpecialization($specId) {
        $sql = "SELECT * FROM doctors WHERE specialization = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $specId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $doctors = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        return $doctors;
    }

    public function addSpecialization($name) {
        $sql = "INSERT INTO doctorspecialization (specialization) VALUES (?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $name);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
}
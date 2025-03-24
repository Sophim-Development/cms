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

    public function getDoctorAppointments($doctorId) {
        $sql = "SELECT a.*, u.fullName FROM appointment a 
                JOIN users u ON a.userId = u.id 
                WHERE a.doctorId = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $doctorId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        return $appointments;
    }

    public function updateAppointmentStatus($appointmentId, $status) {
        $sql = "UPDATE appointment SET doctorStatus = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $status, $appointmentId);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    public function getAllDoctors() {
        $sql = "SELECT *
                FROM doctors
                LEFT JOIN doctorspecialization ON doctors.specialization = doctorspecialization.id";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $doctors = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $doctors[] = [
                'id' => $row['id'],
                'doctorName'=>$row['doctorName'],
                'docFees'=>$row['docFees'],
                'specialization' => $row['specialization'],
                'contact'=> $row['contactno'],
                'email'=> $row['docEmail'],
            ];
        }
        mysqli_stmt_close($stmt);
        return $doctors;
    }
}
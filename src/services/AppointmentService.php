<?php
require_once __DIR__ . '/includes/config.php';

class AppointmentService {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createAppointment($data) {
        $sql = "INSERT INTO appointment (doctorSpecialization, doctorId, userId, consultancyFees, 
                appointmentDate, appointmentTime, userStatus, doctorStatus)
                VALUES (?, ?, ?, ?, ?, ?, 1, 1)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiisss", 
            $data['specialization'],
            $data['doctorId'],
            $data['userId'],
            $data['fees'],
            $data['appointmentDate'],
            $data['appointmentTime']
        );
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    public function getAppointmentsByDoctor($doctorId) {
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

    public function cancelAppointment($appointmentId) {
        $sql = "UPDATE appointment SET userStatus = 0 WHERE id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $appointmentId);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }
}
?>
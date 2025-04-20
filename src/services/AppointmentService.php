<?php
class AppointmentService {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function getUserAppointments($userId) {
        $query = "SELECT a.*, s.specialization, d.name AS doctor_name 
                  FROM appointments a 
                  LEFT JOIN specializations s ON a.specialization_id = s.id 
                  LEFT JOIN doctors d ON a.doctor_id = d.id 
                  WHERE a.user_id = ? 
                  ORDER BY a.appointment_date, a.appointment_time";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointments = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $appointments;
    }

    public function getDoctorAppointments($doctorUserId) {
        $query = "SELECT a.*, s.specialization, u.full_name AS patient_name 
                  FROM appointments a 
                  LEFT JOIN specializations s ON a.specialization_id = s.id 
                  LEFT JOIN users u ON a.user_id = u.id 
                  LEFT JOIN doctors d ON a.doctor_id = d.id 
                  WHERE d.user_id = ? 
                  ORDER BY a.appointment_date, a.appointment_time";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('i', $doctorUserId);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointments = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $appointments;
    }

    public function createAppointment($data) {
        $query = "INSERT INTO appointments (user_id, specialization_id, doctor_id, appointment_date, appointment_time, fees, status) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('iiissss', $data['user_id'], $data['specialization_id'], $data['doctor_id'], 
                         $data['appointment_date'], $data['appointment_time'], $data['fees'], $data['status']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteAppointment($appointmentId, $userId) {
        $query = "DELETE FROM appointments WHERE id = ? AND user_id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ii', $appointmentId, $userId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
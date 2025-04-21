<?php
class UserService {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }
    public function emailExists($email) {
        $query = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $count = 0;
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count > 0;
    }

    public function registerUser($data) {
        try {
            $query = "INSERT INTO users (full_name, address, city, gender, email, password, role) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->con->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->con->error);
            }
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $role = $data['role'] !== "" ? $data['role'] : 'patient';
            $stmt->bind_param('sssssss', $data['fullName'], $data['address'], $data['city'], $data['gender'], $data['email'], $hashedPassword, $role);
            $result = $stmt->execute();
            if ($result) {
                $userId = $stmt->insert_id;
                $stmt->close();
                return $userId;
            } else {
                $error = $stmt->error;
                $stmt->close();
                if (strpos($error, 'Duplicate entry') !== false) {
                    throw new Exception("Email already exists in the database.");
                }
                throw new Exception("Registration failed: " . $error);
            }
        } catch (Exception $e) {
            if (isset($stmt)) {
                $stmt->close();
            }
            error_log($e->getMessage());
            return false; 
        }
    }

    public function userLogin($email, $password) {
        try {
            $email = strtolower($email);
            $query = "SELECT id, password, role FROM users WHERE email = ?";
            $stmt = $this->con->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $this->con->error);
            }
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            echo "User login failed";
            echo "User: " . json_encode($user);
            // Check if user exists and verify password
            if ($user && password_verify($password, $user['password'])) {
                echo "User: " . json_encode($user);
                return $user;
            }
            return false;
        } catch (Exception $e) {
            if (isset($stmt)) {
                $stmt->close();
            }
            error_log($e->getMessage());
            return false;
        }
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function storePasswordResetToken($userId, $token, $expiresAt) {
        $query = "INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('iss', $userId, $token, $expiresAt);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function verifyPasswordResetToken($token) {
        $query = "SELECT * FROM password_resets WHERE token = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $resetData = $result->fetch_assoc();
        $stmt->close();
        return $resetData;
    }

    public function deletePasswordResetToken($token) {
        $query = "DELETE FROM password_resets WHERE token = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $stmt->close();
    }

    public function updatePassword($userId, $newPassword) {
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bind_param('si', $hashedPassword, $userId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getAppointmentsByUserId($userId) {
        $stmt = $this->con->prepare("
            SELECT
                a.*,
                d.name AS doctor_name,
                s.specialization AS specialization_name
            FROM appointments a
            LEFT JOIN doctors d ON a.doctor_id = d.id
            LEFT JOIN specializations s ON a.specialization_id = s.id
            WHERE a.id = ?
            LIMIT 1
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        echo "Appointments: " . json_encode($appointments);
        $stmt->close();

        return $appointments;
    }

    public function getAppointmentsById($id) {
        $stmt = $this->con->prepare("
            SELECT
                a.*,
                d.name AS doctor_name,
                s.specialization AS specialization_name
            FROM appointments a
            LEFT JOIN doctors d ON a.doctor_id = d.id
            LEFT JOIN specializations s ON a.specialization_id = s.id
            WHERE a.id = ?
            LIMIT 1
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getMedicalHistoryByUserId($userId) {
        $stmt = $this->con->prepare("
            SELECT mh.*, d.name AS doctor_name
            FROM medical_histories mh
            LEFT JOIN doctors d ON mh.doctor_id = d.id
            WHERE mh.user_id = ?
            ORDER BY mh.recorded_at DESC
        ");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $history = [];
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
        return $history;
    }

    public function getMedicalHistoryById($id) {
        $stmt = $this->con->prepare("
            SELECT mh.*, d.name AS doctor_name
            FROM medical_histories mh
            LEFT JOIN doctors d ON mh.doctor_id = d.id
            WHERE mh.id = ?
            LIMIT 1
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
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
        $query = "INSERT INTO users (fullName, address, city, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ssssss', $data['fullName'], $data['address'], $data['city'], $data['gender'], $data['email'], $data['password']);
        $result = $stmt->execute();
        if ($result) {
            $userId = $stmt->insert_id;
            $stmt->close();
            return $userId;
        }
        $stmt->close();
        return false;
    }

    public function userLogin($email, $password) {
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
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
        $stmt->bind_param('si', $newPassword, $userId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getUserAppointments($userId) {
        $sql = "SELECT a.*, d.doctorName FROM appointment a 
                JOIN doctors d ON a.doctorId = d.id 
                WHERE a.userId = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $appointments = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt);
        return $appointments;
    }
}
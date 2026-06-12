<?php
namespace App\Models;

class UserModel extends Model {
    
    // Tìm người dùng theo email
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    // Tìm người dùng theo ID
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Đăng ký tài khoản khách hàng mới
    public function createUser($fullname, $email, $hashedPassword, $role = 'user') {
        $sql = "INSERT INTO users (fullname, email, password, role) VALUES (:fullname, :email, :password, :role)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'fullname' => $fullname,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role
        ]);
    }

    // Lưu token khôi phục mật khẩu
    public function saveResetToken($email, $token) {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = :token WHERE email = :email");
        return $stmt->execute([
            'token' => $token,
            'email' => $email
        ]);
    }

    // Tìm người dùng qua token khôi phục mật khẩu
    public function getUserByResetToken($token) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE reset_token = :token");
        $stmt->execute(['token' => $token]);
        return $stmt->fetch();
    }

    // Cập nhật mật khẩu mới và xóa token
    public function updatePasswordAndClearToken($id, $hashedPassword) {
        $stmt = $this->db->prepare("UPDATE users SET password = :password, reset_token = NULL WHERE id = :id");
        return $stmt->execute([
            'password' => $hashedPassword,
            'id' => $id
        ]);
    }

    // Lấy toàn bộ danh sách nhân viên
    public function getEmployees() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 'staff' ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Cập nhật thông tin nhân viên (hỗ trợ đổi mật khẩu tùy chọn)
    public function updateEmployee($id, $fullname, $email, $password = null) {
        if ($password !== null && $password !== '') {
            $stmt = $this->db->prepare("UPDATE users SET fullname = :fullname, email = :email, password = :password WHERE id = :id AND role = 'staff'");
            return $stmt->execute([
                'fullname' => $fullname,
                'email' => $email,
                'password' => $password,
                'id' => $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET fullname = :fullname, email = :email WHERE id = :id AND role = 'staff'");
            return $stmt->execute([
                'fullname' => $fullname,
                'email' => $email,
                'id' => $id
            ]);
        }
    }

    // Lấy toàn bộ danh sách tài khoản
    public function getAllUsers() {
        $stmt = $this->db->prepare("SELECT * FROM users ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Cập nhật thông tin tài khoản (hỗ trợ đổi mật khẩu tùy chọn và vai trò)
    public function updateUser($id, $fullname, $email, $role, $password = null) {
        if ($password !== null && $password !== '') {
            $stmt = $this->db->prepare("UPDATE users SET fullname = :fullname, email = :email, role = :role, password = :password WHERE id = :id");
            return $stmt->execute([
                'fullname' => $fullname,
                'email' => $email,
                'role' => $role,
                'password' => $password,
                'id' => $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET fullname = :fullname, email = :email, role = :role WHERE id = :id");
            return $stmt->execute([
                'fullname' => $fullname,
                'email' => $email,
                'role' => $role,
                'id' => $id
            ]);
        }
    }

    // Xóa nhân viên/người dùng
    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

<?php
namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    // Hiển thị và xử lý đăng nhập
    public function login() {
        $error = $_SESSION['auth_error'] ?? '';
        unset($_SESSION['auth_error']);
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user'; // 'user' hoặc 'admin'

            if ($email === '' || $password === '') {
                $error = 'Vui lòng nhập đầy đủ email và mật khẩu!';
            } else {
                $user = $this->userModel->getUserByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    // Kiểm tra vai trò đăng nhập có khớp không
                    if ($user['role'] !== $role) {
                        $error = 'Tài khoản không có quyền đăng nhập với vai trò này!';
                    } else {
                        // Đăng nhập thành công
                        if ($user['role'] === 'admin') {
                            $_SESSION['admin'] = $user;
                        } else {
                            $_SESSION['user'] = $user;
                        }
                        header('Location: ' . BASE_URL . '/');
                        exit;
                    }
                } else {
                    $error = 'Email hoặc mật khẩu không chính xác!';
                }
            }
        }

        $this->render('frontend.auth.login', [
            'error' => $error,
            'success' => $success
        ]);
    }

    // Hiển thị và xử lý đăng ký (User)
    public function register() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if ($fullname === '' || $email === '' || $password === '') {
                $error = 'Vui lòng điền đầy đủ các thông tin!';
            } elseif ($password !== $confirm_password) {
                $error = 'Mật khẩu nhập lại không khớp!';
            } else {
                $existingUser = $this->userModel->getUserByEmail($email);
                if ($existingUser) {
                    $error = 'Email này đã được đăng ký tài khoản khác!';
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $result = $this->userModel->createUser($fullname, $email, $hashedPassword, 'user');
                    if ($result) {
                        $success = 'Đăng ký tài khoản thành công! Bạn có thể đăng nhập ngay.';
                    } else {
                        $error = 'Có lỗi xảy ra khi tạo tài khoản, vui lòng thử lại!';
                    }
                }
            }
        }

        $this->render('frontend.auth.register', [
            'error' => $error,
            'success' => $success
        ]);
    }

    // Xử lý đăng xuất
    public function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['admin']);
        header('Location: ' . BASE_URL . '/');
        exit;
    }

    // Yêu cầu khôi phục mật khẩu
    public function forgotPassword() {
        $error = '';
        $success = '';
        $resetLink = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            if ($email === '') {
                $error = 'Vui lòng nhập địa chỉ email của bạn!';
            } else {
                $user = $this->userModel->getUserByEmail($email);
                if ($user) {
                    $token = md5(uniqid(rand(), true));
                    $this->userModel->saveResetToken($email, $token);
                    
                    // Tạo link reset mật khẩu trực tiếp để test local
                    $resetLink = BASE_URL . '/reset-password?token=' . $token;
                    $success = 'Đã tạo liên kết khôi phục mật khẩu thành công!';
                } else {
                    $error = 'Địa chỉ email này không tồn tại trong hệ thống!';
                }
            }
        }

        $this->render('frontend.auth.forgot-password', [
            'error' => $error,
            'success' => $success,
            'resetLink' => $resetLink
        ]);
    }

    // Đặt lại mật khẩu mới
    public function resetPassword() {
        $error = '';
        $success = '';
        $token = $_GET['token'] ?? $_POST['token'] ?? '';

        if ($token === '') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $user = $this->userModel->getUserByResetToken($token);
        if (!$user) {
            $error = 'Liên kết khôi phục mật khẩu không hợp lệ hoặc đã hết hạn!';
            $this->render('frontend.auth.reset-password', [
                'error' => $error,
                'success' => $success,
                'token' => $token,
                'userValid' => false
            ]);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if ($password === '') {
                $error = 'Vui lòng nhập mật khẩu mới!';
            } elseif ($password !== $confirm_password) {
                $error = 'Mật khẩu nhập lại không khớp!';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->userModel->updatePasswordAndClearToken($user['id'], $hashedPassword);
                $success = 'Đặt lại mật khẩu thành công! Bạn có thể dùng mật khẩu mới để đăng nhập.';
            }
        }

        $this->render('frontend.auth.reset-password', [
            'error' => $error,
            'success' => $success,
            'token' => $token,
            'userValid' => true
        ]);
    }
}

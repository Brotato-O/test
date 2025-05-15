<?php
session_start();
ob_start();
include '../app/model/connectdb.php';
include '../app/model/khachhang.php';

// Chuyển hướng nếu đã đăng nhập và có quyền admin
if (isset($_SESSION['acount']) && $_SESSION['acount']['vaitro_id'] != 2) {
    header("Location: indexadmin.php?act=home");
    exit();
}

$error = "";

// Kiểm tra nếu có lỗi không được phép truy cập
if (isset($_GET['error']) && $_GET['error'] == 'unauthorized') {
    $error = "Bạn không có quyền truy cập trang quản trị! Vui lòng đăng nhập với tài khoản admin hoặc nhân viên.";
}

if (isset($_POST['admin_login'])) {
    // Xử lý AJAX request
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        
        if (empty($email)) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng nhập email!'
            ]);
            exit;
        }
        
        if (empty($password)) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng nhập mật khẩu!'
            ]);
            exit;
        }

        try {
            $checkUser = check_user($email, $password);
            
            if (is_array($checkUser)) {
                if ($checkUser['vaitro_id'] != 2) {
                    $_SESSION['acount'] = $checkUser;
                    echo json_encode([
                        'success' => true,
                        'message' => 'Đăng nhập thành công!',
                        'redirect' => 'indexadmin.php?act=home'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Bạn không có quyền truy cập trang quản trị!'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Email hoặc mật khẩu không chính xác!'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi đăng nhập: ' . $e->getMessage()
            ]);
        }
        exit;
    }
    
    // Xử lý form submit thông thường (fallback)
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email)) {
        $emailError = "Vui lòng nhập email";
    }
    if (empty($password)) {
        $passwordError = "Vui lòng nhập mật khẩu";
    }

    // Kiểm tra đăng nhập
    $checkUser = check_user($email, $password);

    if (is_array($checkUser)) {
        // Kiểm tra vai trò - chỉ cho phép admin và nhân viên (vaitro_id khác 2)
        if ($checkUser['vaitro_id'] != 2) {
            $_SESSION['acount'] = $checkUser;
            header("Location: indexadmin.php?act=home");
            exit();
        } else {
            $error = "Bạn không có quyền truy cập trang quản trị!";
        }
    } else {
        $error = "Email hoặc mật khẩu không chính xác!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị - Đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            height: 100vh;
        }

        .login-container {
            max-width: 450px;
            margin: 0 auto;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            color: #333;
            font-weight: 600;
        }

        .btn-admin-login {
            background-color: #343a40;
            border-color: #343a40;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
        }

        .form-control:focus {
            border-color: #343a40;
            box-shadow: 0 0 0 0.25rem rgba(52, 58, 64, 0.25);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h2>Đăng nhập Quản trị</h2>
                <p class="text-muted">Dành cho Admin và Nhân viên</p>
            </div>

            <div id="login-message" class="alert d-none mb-3"></div>

            <form id="adminLoginForm" method="post" onsubmit="return false;">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <p id="email-error" class="text-danger form-message mt-1"></p>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <p id="password-error" class="text-danger form-message mt-1"></p>
                </div>

                <button type="submit" class="btn btn-primary btn-admin-login" name="admin_login">Đăng nhập</button>
            </form>

            <div class="mt-3 text-center">
                <a href="../index.php" class="text-decoration-none">Quay lại trang chủ</a>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset error messages
        document.getElementById('email-error').textContent = '';
        document.getElementById('password-error').textContent = '';
        const messageDiv = document.getElementById('login-message');
        messageDiv.className = 'alert d-none mb-3';
        
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        
        // Basic validation
        let hasError = false;
        if (!email) {
            document.getElementById('email-error').textContent = 'Vui lòng nhập email!';
            hasError = true;
        }
        if (!password) {
            document.getElementById('password-error').textContent = 'Vui lòng nhập mật khẩu!';
            hasError = true;
        }
        
        if (hasError) return;
        
        // Send AJAX request
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);
        formData.append('admin_login', '1');
        
        fetch('admin_login.php', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.className = 'alert alert-success mb-3';
                messageDiv.textContent = data.message;
                // Redirect after successful login
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            } else {
                messageDiv.className = 'alert alert-danger mb-3';
                messageDiv.textContent = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.className = 'alert alert-danger mb-3';
            messageDiv.textContent = 'Đã xảy ra lỗi khi đăng nhập, vui lòng thử lại!';
        });
    });
    </script>
</body>

</html>
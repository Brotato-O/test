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

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    <?php if (isset($emailError)): ?>
                        <div class="text-danger mt-1"><?php echo $emailError; ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <?php if (isset($passwordError)): ?>
                        <div class="text-danger mt-1"><?php echo $passwordError; ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary btn-admin-login" name="admin_login">Đăng nhập</button>
            </form>

            <div class="mt-3 text-center">
                <a href="../index.php" class="text-decoration-none">Quay lại trang chủ</a>
            </div>
        </div>
    </div>
</body>

</html>
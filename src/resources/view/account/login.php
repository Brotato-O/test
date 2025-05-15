<?php
// Chỉ giữ lại phần kiểm tra session và các biến cần thiết
if (isset($_SESSION['acount']) && $_SESSION['acount']) {
    header("Location:index.php?act=home");
    exit();
}
?>
<div class="form-wrapper d-flex align-items-center justify-content-center flex-column">
    <h2 class="fw-bold">Login</h2>
    <div id="login-message" class="alert d-none mb-3"></div>
    <form id="loginForm" class="form" method="post" onsubmit="return false;">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <p id="email-error" class="text-danger form-message mt-1"></p>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <p id="password-error" class="text-danger form-message mt-1"></p>
        </div>
        <button type="submit" class="btn btn-dark w-100 text-uppercase">Login</button>
    </form>
    <p class="mt-4">You don't have account? <a href="index.php?act=register">Sign up</a></p>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
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
    
    fetch('index.php?act=loginAjax', {
        method: 'POST',
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
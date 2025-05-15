<?php
// Chỉ giữ lại phần kiểm tra session
if (isset($_SESSION['acount']) && $_SESSION['acount']) {
    header("Location:index.php?act=home");
    exit();
}
?>

<div class="form-wrapper d-flex align-items-center justify-content-center flex-column">
    <h2 class="fw-bold">Sign Up</h2>
    <div id="register-message" class="alert d-none mb-3"></div>
    <form id="registerForm" class="form" onsubmit="return false;">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
            <p id="username-error" class="text-danger form-message mt-1"></p>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <p id="email-error" class="text-danger form-message mt-1"></p>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
            <p id="phone-error" class="text-danger form-message mt-1"></p>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Home Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
            <p id="address-error" class="text-danger form-message mt-1"></p>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <p id="password-error" class="text-danger form-message mt-1"></p>
        </div>
        <div class="mb-3">
            <label for="re-password" class="form-label">Password Confirm</label>
            <input type="password" class="form-control" id="re-password" name="re-password" required>
            <p id="re-password-error" class="text-danger form-message mt-1"></p>
        </div>
        <button type="submit" class="btn btn-dark w-100 text-uppercase">Sign Up</button>
    </form>
    <p class="mt-4">You have a account? <a href="index.php?act=login" class="text-dark">Login</a></p>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Reset error messages
    const errorElements = document.querySelectorAll('.form-message');
    errorElements.forEach(el => el.textContent = '');
    const messageDiv = document.getElementById('register-message');
    messageDiv.className = 'alert d-none mb-3';
    
    // Get form data
    const formData = new FormData(this);
    
    // Send AJAX request
    fetch('index.php?act=registerAjax', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.className = 'alert alert-success mb-3';
            messageDiv.textContent = data.message;
            // Redirect after successful registration
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 2000);
        } else {
            if (data.errors) {
                // Display validation errors
                Object.keys(data.errors).forEach(field => {
                    const errorElement = document.getElementById(field + '-error');
                    if (errorElement) {
                        errorElement.textContent = data.errors[field];
                    }
                });
            } else {
                // Display general error message
                messageDiv.className = 'alert alert-danger mb-3';
                messageDiv.textContent = data.message;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        messageDiv.className = 'alert alert-danger mb-3';
        messageDiv.textContent = 'Đã xảy ra lỗi khi đăng ký, vui lòng thử lại!';
    });
});

// Real-time validation
const usernameInput = document.getElementById('username');
const emailInput = document.getElementById('email');
const phoneInput = document.getElementById('phone');
const passwordInput = document.getElementById('password');
const rePasswordInput = document.getElementById('re-password');

// Username validation
usernameInput.addEventListener('input', function() {
    const value = this.value.trim();
    const errorElement = document.getElementById('username-error');
    
    if (!value) {
        errorElement.textContent = 'Vui lòng nhập tên đăng nhập!';
    } else if (!/^[a-zA-Z ]+$/.test(value)) {
        errorElement.textContent = 'Tên đăng nhập chỉ được chứa chữ cái và khoảng trắng!';
    } else {
        errorElement.textContent = '';
    }
});

// Email validation
emailInput.addEventListener('input', function() {
    const value = this.value.trim();
    const errorElement = document.getElementById('email-error');
    
    if (!value) {
        errorElement.textContent = 'Vui lòng nhập email!';
    } else if (!/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) {
        errorElement.textContent = 'Email không hợp lệ!';
    } else {
        errorElement.textContent = '';
    }
});

// Phone validation
phoneInput.addEventListener('input', function() {
    const value = this.value.trim();
    const errorElement = document.getElementById('phone-error');
    
    if (!value) {
        errorElement.textContent = 'Vui lòng nhập số điện thoại!';
    } else if (!/^(0|\+84)(3[2-9]|5[2689]|7[06789]|8[1-689]|9[0-9])[0-9]{7}$/.test(value)) {
        errorElement.textContent = 'Số điện thoại không hợp lệ!';
    } else {
        errorElement.textContent = '';
    }
});

// Password validation
passwordInput.addEventListener('input', function() {
    const value = this.value.trim();
    const errorElement = document.getElementById('password-error');
    
    if (!value) {
        errorElement.textContent = 'Vui lòng nhập mật khẩu!';
    } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*]).{6,}$/.test(value)) {
        errorElement.textContent = 'Mật khẩu phải chứa chữ hoa, chữ thường, số và ký tự đặc biệt, tối thiểu 6 ký tự!';
    } else {
        errorElement.textContent = '';
    }
    
    // Also check re-password if it has value
    if (rePasswordInput.value) {
        rePasswordInput.dispatchEvent(new Event('input'));
    }
});

// Re-password validation
rePasswordInput.addEventListener('input', function() {
    const value = this.value.trim();
    const password = passwordInput.value.trim();
    const errorElement = document.getElementById('re-password-error');
    
    if (!value) {
        errorElement.textContent = 'Vui lòng nhập lại mật khẩu!';
    } else if (value !== password) {
        errorElement.textContent = 'Mật khẩu nhập lại không khớp!';
    } else {
        errorElement.textContent = '';
    }
});
</script>
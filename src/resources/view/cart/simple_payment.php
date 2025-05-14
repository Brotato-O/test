<?php
// Đảm bảo người dùng đã đăng nhập
if (!isset($_SESSION['acount']) || !$_SESSION['acount']) {
    header("Location: index.php?act=login");
    exit;
}

// Kiểm tra thông tin đơn hàng
if (!isset($_SESSION['order_id']) || !isset($_SESSION['order_total']) || !isset($_SESSION['product_updates'])) {
    header("Location: index.php?act=home");
    exit;
}

$order_id = $_SESSION['order_id'];
$order_total = $_SESSION['order_total'];
$product_updates = $_SESSION['product_updates'];

// Xử lý khi người dùng xác nhận thanh toán
if (isset($_POST['confirm_payment'])) {
    // Cập nhật số lượng sản phẩm dựa trên thông tin đã lưu
    foreach ($product_updates as $update) {
        $pro_id = $update['pro_id'];
        $size_id = $update['size_id'];
        $color_id = $update['color_id'];
        $quantity = $update['quantity'];
        $current_stock = $update['current_stock'];

        // Cập nhật số lượng sản phẩm
        $new_stock = $current_stock - $quantity;
        $sql = "UPDATE pro_chitiet SET soluong = $new_stock 
                WHERE pro_id = $pro_id AND size_id = $size_id AND color_id = $color_id";
        pdo_execute($sql);
    }

    // Cập nhật trạng thái đơn hàng thành "Đã thanh toán"
    $sql = "UPDATE `order` SET trangthai = 'Đã thanh toán' WHERE order_id = $order_id";
    pdo_execute($sql);

    // Xóa thông tin đơn hàng khỏi session
    unset($_SESSION['order_id']);
    unset($_SESSION['order_total']);
    unset($_SESSION['product_updates']);

    // Hiển thị thông báo và chuyển hướng
    echo "<script>
        alert('Thanh toán thành công! Cảm ơn bạn đã mua sắm.');
        window.location.href = 'index.php?act=home';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán đơn hàng</title>
    <style>
    .payment-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 30px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .payment-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .payment-details {
        margin-bottom: 30px;
    }

    .payment-form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .payment-form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .btn-payment {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 12px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        margin-top: 15px;
    }

    .btn-payment:hover {
        background-color: #218838;
    }

    .payment-summary {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 30px;
    }

    .payment-summary h4 {
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="payment-container">
        <div class="payment-header">
            <h2>Thanh toán đơn hàng #<?php echo $order_id; ?></h2>
            <p class="text-muted">Vui lòng điền thông tin thanh toán của bạn để hoàn tất đơn hàng</p>
        </div>

        <div class="payment-summary">
            <h4>Thông tin đơn hàng</h4>
            <div class="d-flex justify-content-between">
                <p><strong>Mã đơn hàng:</strong> #<?php echo $order_id; ?></p>
                <p><strong>Tổng tiền:</strong> $<?php echo $order_total; ?></p>
            </div>

            <div class="alert alert-info">
                <p><strong>Lưu ý:</strong> Số lượng sản phẩm sẽ chỉ được cập nhật sau khi bạn xác nhận thanh toán.</p>
            </div>
        </div>

        <form action="" method="post" class="payment-form">
            <div class="card-details">
                <h4>Thông tin thẻ thanh toán</h4>

                <div class="form-group">
                    <label for="card-holder">Tên chủ thẻ</label>
                    <input type="text" id="card-holder" name="card_holder" placeholder="Nhập tên chủ thẻ" required>
                </div>

                <div class="form-group">
                    <label for="card-number">Số thẻ</label>
                    <input type="text" id="card-number" name="card_number" placeholder="XXXX-XXXX-XXXX-XXXX"
                        pattern="[0-9]{4}[\-]?[0-9]{4}[\-]?[0-9]{4}[\-]?[0-9]{4}" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="expiry-date">Ngày hết hạn</label>
                        <input type="text" id="expiry-date" name="expiry_date" placeholder="MM/YY"
                            pattern="[0-9]{2}/[0-9]{2}" required>
                    </div>
                </div>
            </div>

            <button type="submit" name="confirm_payment" class="btn-payment">Xác nhận thanh toán</button>
        </form>

        <div class="mt-3 text-center">
            <a href="index.php?act=cancel_payment" class="text-danger">Hủy thanh toán</a>
        </div>
    </div>
</body>

</html>
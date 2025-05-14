<?php
ob_start();

$cart_id = $_GET['cart_id_del'];
$kh_id = $_GET['kh_id'];
del_cart($cart_id);

// Nếu là AJAX request
if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    // Lấy số lượng còn lại trong giỏ hàng
    $cart = querycart_kh($kh_id);
    $cart_id = $cart['cart_id'];
    $sql = "SELECT SUM(soluong) as total_quantity FROM cart_chitiet WHERE cart_id = $cart_id";
    $result = pdo_query_one($sql);
    $total_quantity = isset($result['total_quantity']) ? $result['total_quantity'] : 0;

    // Trả về JSON
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'cart_count' => $total_quantity
    ]);
    exit();
} else {
    // Chuyển hướng thông thường
    header("Location: index.php?act=mycart&kh_id=$kh_id");
    exit();
}
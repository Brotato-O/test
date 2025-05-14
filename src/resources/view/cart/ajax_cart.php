<?php
session_start();
include '../../../app/model/connectdb.php';
include '../../../app/model/product.php';
include '../../../app/model/cart.php';

header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

$size = isset($_POST['size']) ? intval($_POST['size']) : 0;
$color = isset($_POST['color']) ? intval($_POST['color']) : 0;
$soluong = isset($_POST['cart_qty']) ? intval($_POST['cart_qty']) : 0;
$pro_id = isset($_POST['pro_id']) ? intval($_POST['pro_id']) : 0;
$kh_id = isset($_POST['kh_id']) ? intval($_POST['kh_id']) : 0;

if ($size <= 0 || $color <= 0 || $soluong <= 0 || $pro_id <= 0 || $kh_id <= 0) {
    $response['message'] = 'Vui lòng nhập đầy đủ thông tin sản phẩm';
} else {
    try {
        $pro_cart = queryonepro($pro_id);
        if (!$pro_cart) {
            $response['message'] = 'Không tìm thấy sản phẩm';
        } else {
            $cart_kh = querycart_kh($kh_id);
            if (!$cart_kh) {
                // Nếu giỏ hàng chưa tồn tại, tạo mới giỏ hàng
                addcart_kh($kh_id, 0);
                $cart_kh = querycart_kh($kh_id);
            }

            if (!$cart_kh) {
                throw new Exception("Không thể tạo giỏ hàng");
            }

            $check_cart = check_cart($size, $pro_id, $color, $cart_kh['cart_id']);

            if (is_array($check_cart)) {
                update_soluong_cart($soluong, $pro_cart['pro_price'], $check_cart['cart_chitiet_id'], $check_cart['soluong']);
            } else {
                add_cartchitiet($cart_kh['cart_id'], $pro_id, $color, $size, $pro_cart['pro_price'], $soluong);
            }

            $response['success'] = true;
            $response['message'] = 'Đã thêm sản phẩm vào giỏ hàng thành công!';

            // Lấy tổng số lượng sản phẩm trong giỏ hàng để cập nhật badge
            $sql = "SELECT SUM(soluong) as total_quantity FROM cart_chitiet WHERE cart_id = {$cart_kh['cart_id']}";
            $result = pdo_query_one($sql);
            $total_quantity = isset($result['total_quantity']) ? $result['total_quantity'] : 0;
            $response['cartQuantity'] = $total_quantity;
        }
    } catch (Exception $e) {
        $response['message'] = 'Lỗi xử lý: ' . $e->getMessage();
    }
}

echo json_encode($response);
exit;

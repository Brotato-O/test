<?php
// Bắt đầu output buffering để đảm bảo không có output nào trước JSON
ob_start();

// Thiết lập header JSON
header('Content-Type: application/json');

// Khởi tạo response
$response = array('success' => false, 'message' => '');

// Lấy dữ liệu từ form
$size = isset($_POST['size']) ? $_POST['size'] : '';
$color = isset($_POST['color']) ? $_POST['color'] : '';
$soluong = isset($_POST['cart_qty']) ? $_POST['cart_qty'] : '';
$pro_id = isset($_GET['pro_id']) ? $_GET['pro_id'] : 0;
$kh_id = isset($_GET['kh_id']) ? $_GET['kh_id'] : 0;

// Kiểm tra dữ liệu
if ($size == 'null' || empty($size) || empty($color) || empty($soluong)) {
  $response['message'] = 'Vui lòng nhập đầy đủ thông tin sản phẩm';
} else {
  if ($kh_id && $pro_id) {
    try {
      $pro_cart = queryonepro($pro_id);
      $cart_kh = querycart_kh($kh_id);
      $check_cart = check_cart($size, $pro_id, $color, $cart_kh['cart_id']);

      if (is_array($check_cart)) {
        update_soluong_cart($soluong, $pro_cart['pro_price'], $check_cart['cart_chitiet_id'], $check_cart['soluong']);
      } else {
        add_cartchitiet($cart_kh['cart_id'], $pro_cart['pro_id'], $color, $size, $pro_cart['pro_price'], $soluong);
      }

      $response['success'] = true;
      $response['message'] = 'Đã thêm sản phẩm vào giỏ hàng thành công!';
    } catch (Exception $e) {
      $response['message'] = 'Lỗi xử lý: ' . $e->getMessage();
    }
  } else {
    $response['message'] = 'Thông tin không hợp lệ';
  }
}

// Xóa tất cả output buffer
ob_end_clean();

// Trả về JSON
echo json_encode($response);
exit;

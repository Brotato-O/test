<?php
// Đảm bảo người dùng đã đăng nhập
if (!isset($_SESSION['acount']) || !$_SESSION['acount']) {
    header("Location: index.php?act=login");
    exit;
}

// Kiểm tra thông tin đơn hàng
if (!isset($_SESSION['order_id'])) {
    header("Location: index.php?act=home");
    exit;
}

// Hàm ghi log để debug
function write_debug_log($message)
{
    $log_file = __DIR__ . '/debug_cancel_payment.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] $message\n";
    file_put_contents($log_file, $log_message, FILE_APPEND);
}

$order_id = $_SESSION['order_id'];
write_debug_log("Bắt đầu xử lý hủy thanh toán cho đơn hàng: $order_id");

// Cập nhật trạng thái đơn hàng thành "Đã hủy"
$sql = "UPDATE `order` SET trangthai = 'Đã hủy' WHERE order_id = $order_id";
pdo_execute($sql);
write_debug_log("Đã cập nhật trạng thái đơn hàng thành 'Đã hủy'");

// Lấy chi tiết đơn hàng để kiểm tra
$sql = "SELECT * FROM order_chitiet WHERE order_id = $order_id";
$order_items = pdo_queryall($sql);
write_debug_log("Đơn hàng có " . (is_array($order_items) ? count($order_items) : 0) . " sản phẩm");

// Kiểm tra thông tin trong session
if (isset($_SESSION['product_updates'])) {
    write_debug_log("Session product_updates tồn tại với " . count($_SESSION['product_updates']) . " sản phẩm");
    foreach ($_SESSION['product_updates'] as $index => $item) {
        write_debug_log("Sản phẩm $index: pro_id = {$item['pro_id']}, size_id = {$item['size_id']}, color_id = {$item['color_id']}, quantity = {$item['quantity']}");
    }
} else {
    write_debug_log("Session product_updates không tồn tại");
}

// Khôi phục sản phẩm vào giỏ hàng
if (isset($_SESSION['product_updates']) && is_array($_SESSION['product_updates']) && !empty($_SESSION['product_updates'])) {
    $kh_id = $_SESSION['acount']['kh_id'];
    write_debug_log("Khách hàng ID: $kh_id");

    $cart_kh = querycart_kh($kh_id);
    write_debug_log("Giỏ hàng hiện tại: " . ($cart_kh ? "Tồn tại (cart_id: {$cart_kh['cart_id']})" : "Không tồn tại"));

    // Nếu không có giỏ hàng, tạo mới
    if (!$cart_kh) {
        write_debug_log("Tạo giỏ hàng mới cho khách hàng $kh_id");
        addcart_kh($kh_id, 0);
        $cart_kh = querycart_kh($kh_id);
        write_debug_log("Đã tạo giỏ hàng mới với id: " . ($cart_kh ? $cart_kh['cart_id'] : "không thành công"));
    }

    if (!$cart_kh) {
        write_debug_log("LỖI: Không thể tạo hoặc lấy giỏ hàng cho khách hàng $kh_id");
    } else {
        // Trực tiếp lấy thông tin từ product_updates trong session
        foreach ($_SESSION['product_updates'] as $item) {
            $pro_id = $item['pro_id'];
            $color_id = $item['color_id'];
            $size_id = $item['size_id'];
            $quantity = $item['quantity'];

            // Lấy giá trực tiếp từ product_updates nếu có, nếu không thì truy vấn
            $price = isset($item['price']) ? $item['price'] : queryonepro($pro_id)['pro_price'];
            write_debug_log("Đang thêm sản phẩm: pro_id=$pro_id, color=$color_id, size=$size_id, qty=$quantity, price=$price");

            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $check_cart = check_cart($size_id, $pro_id, $color_id, $cart_kh['cart_id']);
            write_debug_log("Kiểm tra sản phẩm trong giỏ hàng: " . (is_array($check_cart) ? "Đã tồn tại" : "Chưa có"));

            if (is_array($check_cart)) {
                // Nếu đã có trong giỏ hàng, tăng số lượng
                write_debug_log("Cập nhật số lượng sản phẩm trong giỏ hàng, ID: {$check_cart['cart_chitiet_id']}, SL hiện tại: {$check_cart['soluong']}, SL thêm: $quantity");
                update_soluong_cart($quantity, $price, $check_cart['cart_chitiet_id'], $check_cart['soluong']);
            } else {
                // Thêm mới vào giỏ hàng
                write_debug_log("Thêm mới sản phẩm vào giỏ hàng cart_id={$cart_kh['cart_id']}");
                add_cartchitiet($cart_kh['cart_id'], $pro_id, $color_id, $size_id, $price, $quantity);
            }
        }

        // Kiểm tra lại giỏ hàng sau khi thêm
        $cart_items = querycart_chitiet($cart_kh['cart_id']);
        write_debug_log("Sau khi cập nhật, giỏ hàng có " . (is_array($cart_items) ? count($cart_items) : 0) . " sản phẩm");
    }
} else {
    write_debug_log("Không có sản phẩm để khôi phục vào giỏ hàng");
}

// Xóa thông tin đơn hàng khỏi session
unset($_SESSION['order_id']);
unset($_SESSION['order_total']);
unset($_SESSION['product_updates']);
write_debug_log("Đã xóa thông tin đơn hàng khỏi session");

// Hiển thị thông báo và chuyển hướng
write_debug_log("Kết thúc xử lý hủy thanh toán, chuyển hướng về trang chủ");
echo "<script>
    alert('Bạn đã hủy thanh toán. Đơn hàng đã được hủy và các sản phẩm đã được trả lại giỏ hàng của bạn.');
    window.location.href = 'index.php?act=home';
</script>";
exit;

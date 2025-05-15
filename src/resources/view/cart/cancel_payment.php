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

try {
    // Bắt đầu transaction
    pdo_execute("START TRANSACTION");
    
    // Kiểm tra trạng thái đơn hàng hiện tại
    $sql = "SELECT order_trangthai FROM `order` WHERE order_id = $order_id FOR UPDATE";
    $order = pdo_query_one($sql);
    
    if(!$order) {
        throw new Exception("Không tìm thấy đơn hàng");
    }
    
    // Chỉ cập nhật nếu đơn hàng chưa bị hủy
    if($order['order_trangthai'] != 'Đã hủy') {
        // Lấy chi tiết đơn hàng để cập nhật số lượng sản phẩm
        $sql = "SELECT * FROM order_chitiet WHERE order_id = $order_id";
        $order_items = pdo_queryall($sql);
        write_debug_log("Đơn hàng có " . (is_array($order_items) ? count($order_items) : 0) . " sản phẩm");
        
        if(!$order_items) {
            throw new Exception("Không tìm thấy chi tiết đơn hàng");
        }
        
        // Cập nhật số lượng sản phẩm cho từng item trong đơn hàng
        foreach($order_items as $item) {
            $pro_id = $item['pro_id'];
            $color_id = $item['color_id'];
            $size_id = $item['size_id'];
            $quantity = $item['soluong'];
            
            // Kiểm tra sản phẩm tồn tại
            $sql = "SELECT soluong FROM pro_chitiet 
                    WHERE pro_id = $pro_id AND color_id = $color_id AND size_id = $size_id FOR UPDATE";
            $product = pdo_query_one($sql);
            
            if(!$product) {
                throw new Exception("Không tìm thấy sản phẩm trong kho");
            }
            
            // Cập nhật số lượng tồn kho
            $sql = "UPDATE pro_chitiet SET soluong = soluong + $quantity 
                    WHERE pro_id = $pro_id AND color_id = $color_id AND size_id = $size_id";
            pdo_execute($sql);
            write_debug_log("Đã cập nhật số lượng sản phẩm: pro_id=$pro_id, color=$color_id, size=$size_id, qty=$quantity");
        }
        
        // Cập nhật trạng thái đơn hàng thành "Đã hủy"
        $sql = "UPDATE `order` SET order_trangthai = 'Đã hủy' WHERE order_id = $order_id";
        pdo_execute($sql);
        write_debug_log("Đã cập nhật trạng thái đơn hàng thành 'Đã hủy'");
        
        // Khôi phục sản phẩm vào giỏ hàng nếu có
        if (isset($_SESSION['product_updates']) && is_array($_SESSION['product_updates']) && !empty($_SESSION['product_updates'])) {
            $kh_id = $_SESSION['acount']['kh_id'];
            write_debug_log("Khách hàng ID: $kh_id");
            
            $cart_kh = querycart_kh($kh_id);
            if (!$cart_kh) {
                addcart_kh($kh_id, 0);
                $cart_kh = querycart_kh($kh_id);
            }
            
            if ($cart_kh) {
                foreach ($_SESSION['product_updates'] as $item) {
                    $pro_id = $item['pro_id'];
                    $color_id = $item['color_id'];
                    $size_id = $item['size_id'];
                    $quantity = $item['quantity'];
                    $price = isset($item['price']) ? $item['price'] : queryonepro($pro_id)['pro_price'];
                    
                    $check_cart = check_cart($size_id, $pro_id, $color_id, $cart_kh['cart_id']);
                    if (is_array($check_cart)) {
                        update_soluong_cart($quantity, $price, $check_cart['cart_chitiet_id'], $check_cart['soluong']);
                    } else {
                        add_cartchitiet($cart_kh['cart_id'], $pro_id, $color_id, $size_id, $price, $quantity);
                    }
                }
            }
        }
        
        // Commit transaction
        pdo_execute("COMMIT");
        write_debug_log("Đã commit transaction thành công");
        
        // Xóa thông tin đơn hàng khỏi session
        unset($_SESSION['order_id']);
        unset($_SESSION['order_total']);
        unset($_SESSION['product_updates']);
        
        echo "<script>
            alert('Bạn đã hủy thanh toán. Đơn hàng đã được hủy và các sản phẩm đã được trả lại giỏ hàng của bạn.');
            window.location.href = 'index.php?act=home';
        </script>";
        
    } else {
        write_debug_log("Đơn hàng đã được hủy trước đó");
        echo "<script>
            alert('Đơn hàng đã được hủy trước đó.');
            window.location.href = 'index.php?act=home';
        </script>";
    }
    
} catch (Exception $e) {
    // Rollback nếu có lỗi
    pdo_execute("ROLLBACK");
    write_debug_log("Lỗi: " . $e->getMessage());
    echo "<script>
        alert('Có lỗi xảy ra khi hủy đơn hàng: " . $e->getMessage() . "');
        window.location.href = 'index.php?act=home';
    </script>";
}
exit;

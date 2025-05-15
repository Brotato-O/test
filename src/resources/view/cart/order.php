<?php

if (isset($_POST['placeordered'])) {
    try {
        // Bắt đầu transaction
        pdo_execute("START TRANSACTION");

        $size = $_POST['size'];
        $color = $_POST['color'];
        $soluong = $_POST['soluong'];
        $pro_id = $_POST['pro_id'];
        $kh_id = $_POST['kh_id'];
        $cart_kh = querycart_kh($kh_id);
        $address = $_POST['address'];
        $trangthai = 'Đang chờ xác nhận';
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $time = date('d-m-y');
        $tongtien = $_POST['tongtien'];

        // Kiểm tra số lượng tồn kho cho tất cả sản phẩm trước khi đặt hàng
        $out_of_stock_items = array();
        for ($i = 0; $i < count($size); $i++) {
            $pro_order = $pro_id[$i];
            $sl_order = $soluong[$i];
            $size_order = $size[$i];
            $color_order = $color[$i];
            
            $pro_chitiet = query_pro_soluong($pro_order, $color_order, $size_order);
            if (!$pro_chitiet) {
                throw new Exception("Sản phẩm không tồn tại trong kho");
            }
            
            $current_stock = $pro_chitiet['soluong'];
            if ($sl_order > $current_stock) {
                $product = queryonepro($pro_order);
                $out_of_stock_items[] = array(
                    'name' => $product['pro_name'],
                    'requested' => $sl_order,
                    'available' => $current_stock
                );
            }
        }

        // Nếu có sản phẩm hết hàng, rollback và thông báo
        if (!empty($out_of_stock_items)) {
            pdo_execute("ROLLBACK");
            $error_message = "Một số sản phẩm không đủ số lượng trong kho:\n";
            foreach ($out_of_stock_items as $item) {
                $error_message .= "- {$item['name']}: Yêu cầu {$item['requested']}, Còn {$item['available']}\n";
            }
            throw new Exception($error_message);
        }

        // Create the order
        add_order($kh_id, $time, $trangthai, $address, $tongtien);

        // Get the newly created order ID
        $sql = "select * from `order` where order_id = (select max(order_id) from `order`)";
        $order_chitiet = pdo_query_one($sql);

        $add_order_chitiet = array(
            "pro_id" => $pro_id,
            "color" => $color,
            "soluong" => $soluong,
            "size" => $size
        );

        // Process the order items
        for ($i = 0; $i < count($size); $i++) {
            $products = queryonepro($add_order_chitiet['pro_id'][$i]);
            $pro_order = $add_order_chitiet['pro_id'][$i];
            $sl_order = $add_order_chitiet['soluong'][$i];
            $size_order = $add_order_chitiet['size'][$i];
            $color_order = $add_order_chitiet['color'][$i];
            
            // Add order details
            add_chitietdonhang($order_chitiet['order_id'], $pro_order, $color_order, $size_order, $products['pro_price'], $sl_order);

            // Remove from cart
            del_cart_order($pro_order, $cart_kh['cart_id']);

            // Cập nhật số lượng tồn kho nếu là thanh toán khi nhận hàng
            if ($_POST['thanhtoan'] == 1) {
                $pro_chitiet = query_pro_soluong($pro_order, $color_order, $size_order);
                $current_stock = $pro_chitiet['soluong'];
                $new_stock = $current_stock - $sl_order;
                
                $sql = "update pro_chitiet set soluong = $new_stock where pro_id = $pro_order and size_id = $size_order and color_id = $color_order";
                pdo_execute($sql);
            }
        }

        // Commit transaction nếu mọi thứ OK
        pdo_execute("COMMIT");

        // Handle payment methods
        if ($_POST['thanhtoan'] == 2) {
            $_SESSION['order_id'] = $order_chitiet['order_id'];
            $_SESSION['order_total'] = $tongtien;
            header('Location: index.php?act=simple_payment');
            die();
        } else {
            // For AJAX requests (Cash on Delivery)
            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            $responseData = [
                'status' => 'success',
                'message' => 'Đặt hàng thành công! Cảm ơn bạn đã mua sắm.',
                'order_id' => $order_chitiet['order_id']
            ];

            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode($responseData);
                exit();
            } else {
                ?>
                <script>
                    alert('Đặt hàng thành công! Cảm ơn bạn đã mua sắm.');
                    window.location.href = 'index.php?act=home';
                </script>
                <?php
                exit();
            }
        }
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        pdo_execute("ROLLBACK");
        
        // Ghi log lỗi
        $log_file = __DIR__ . '/debug_order.log';
        $timestamp = date('Y-m-d H:i:s');
        $log_message = "[$timestamp] Lỗi đặt hàng: " . $e->getMessage() . "\n";
        file_put_contents($log_file, $log_message, FILE_APPEND);

        // Trả về thông báo lỗi
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
            exit();
        } else {
            ?>
            <script>
                alert('<?php echo addslashes($e->getMessage()); ?>');
                window.history.back();
            </script>
            <?php
            exit();
        }
    }
}
?>
<?php
    if(isset($_GET['order_id'])){
        $order_id = $_GET['order_id'];
        
        // Lấy chi tiết đơn hàng để cập nhật số lượng sản phẩm
        $sql = "SELECT * FROM order_chitiet WHERE order_id = $order_id";
        $order_items = pdo_queryall($sql);
        
        // Cập nhật số lượng sản phẩm cho từng item trong đơn hàng
        foreach($order_items as $item) {
            $pro_id = $item['pro_id'];
            $color_id = $item['color_id'];
            $size_id = $item['size_id'];
            $quantity = $item['soluong'];
            
            // Cập nhật số lượng tồn kho
            $sql = "UPDATE pro_chitiet SET soluong = soluong + $quantity 
                    WHERE pro_id = $pro_id AND color_id = $color_id AND size_id = $size_id";
            pdo_execute($sql);
        }
        
        // Cập nhật trạng thái đơn hàng thành "Đã hủy"
        $sql = "update `order` set order_trangthai = 'Đã hủy' where order_id = $order_id";
        pdo_execute($sql);
        
        header("Location:index.php?act=myAccount");
    }
?>
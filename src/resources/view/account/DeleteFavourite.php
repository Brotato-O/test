<?php
if (isset($_GET['pro_id']) && isset($_SESSION['acount'])) {
    $pro_id = $_GET['pro_id'];
    $kh_id = $_SESSION['acount']['kh_id'];
    
    // Xóa sản phẩm khỏi danh sách yêu thích
    deleteProductFromFavourite($kh_id, $pro_id);
    
    // Chuyển hướng về trang tài khoản
    header("Location: index.php?act=myAccount");
    exit();
} else {
    // Nếu không có pro_id hoặc chưa đăng nhập, chuyển về trang chủ
    header("Location: index.php?act=home");
    exit();
}
?> 
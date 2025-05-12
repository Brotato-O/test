<?php
function getallpd(){
    $sql = "SELECT 
                id,
                order_id,
                pro_id,
                pro_moi_id,
                color_id,
                size_id,
                kh_id,
                ngay_doi,
                ly_do,
                trang_thai
            FROM phieu_doi";
    
    $result = pdo_queryall($sql);
    return $result;
}
function insert_phieu_doi_tra($order_id, $pro_id, $pro_moi_id, $color_id, $size_id, $kh_id, $ngay_doi, $ly_do, $trang_thai) {
    $sql = "INSERT INTO phieu_doi (order_id, pro_id, pro_moi_id, color_id, size_id, kh_id, ngay_doi, ly_do, trang_thai)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $order_id, $pro_id, $pro_moi_id, $color_id, $size_id, $kh_id, $ngay_doi, $ly_do, $trang_thai);
}
function delete_phieu_doi_tra($id) {
    $sql = "DELETE FROM phieu_doi WHERE id = ?";
    pdo_execute($sql, $id);
}

?>
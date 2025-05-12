<?php
function query_allbaohanh() {
    $sql = "SELECT 
        pb.id,
        pb.pro_id,
        sp.pro_name,
        pb.kh_id,
        pb.ngay_bao_hanh,
        pb.noi_dung,
        pb.thoi_gian_bao_hanh
        nv.nv_name AS supplier_name
    FROM phieu_bao_hanh pb
    JOIN products sp ON pb.pro_id = sp.pro_id
    JOIN khachhang kh ON pb.kh_id = kh.kh_id
    JOIN khachhang nv ON pb.nhan_vien_id = nv.kh_id
    ";
    
    $result = pdo_queryall($sql);
    return $result;
}
function getall(){
    $sql = "SELECT 
                id,
                pro_id,
                kh_id,
                nhan_vien_id,
                ngay_bao_hanh,
                noi_dung,
                thoi_gian_bao_hanh
            FROM phieu_bao_hanh";
    
    $result = pdo_queryall($sql);
    return $result;
}
function insert_baohanh($pro_id, $kh_id, $nhan_vien_id, $ngay_bao_hanh, $noi_dung, $thoi_gian_bao_hanh) {
    $sql = "INSERT INTO phieu_bao_hanh (pro_id, kh_id, nhan_vien_id, ngay_bao_hanh, noi_dung, thoi_gian_bao_hanh)
            VALUES (?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $pro_id, $kh_id, $nhan_vien_id, $ngay_bao_hanh, $noi_dung, $thoi_gian_bao_hanh);
}
function delete_baohanh($id) {
    $sql = "DELETE FROM phieu_bao_hanh WHERE id = ?";
    pdo_execute($sql, $id);
}


?>
<?php
 function query_allpq() {
        $sql = "SELECT 
                    ct.role_id,
                    vt.vaitro_name,
                    ct.permission_id,
                    q.permission_name,
                    q.trang_thai,
                    ct.hanh_dong
                FROM 
                    chi_tiet_nhom_quyen ct
                JOIN 
                    vaitro vt ON ct.role_id = vt.vaitro_id
                JOIN 
                    quyen q ON ct.permission_id = q.permission_id";
        return pdo_queryall($sql);
    }

function delete_permission_of_role($role_id, $permission_id) {
    $sql = "DELETE FROM chi_tiet_nhom_quyen WHERE role_id = ? AND permission_id = ?";
    pdo_execute($sql, $role_id, $permission_id);
}
function insert_permission_to_role($role_id, $permission_id, $hanh_dong = 1) {
    $sql = "INSERT INTO chi_tiet_nhom_quyen (role_id, permission_id, hanh_dong) 
            VALUES (?, ?, ?)";
    pdo_execute($sql, $role_id, $permission_id, $hanh_dong);
}
function getallvt(){

    $sql =" select * from vaitro";
    $result = pdo_queryall($sql);
    return $result;
}
function getallquyen(){

    $sql =" select * from quyen";
    $result = pdo_queryall($sql);
    return $result;
}
function insert_vaitro($vaitro_name) {
    $sql = "insert into vaitro (vaitro_name) VALUES ('$vaitro_name')";
    pdo_execute($sql);
    
}
function deletevaitro($id){
    $sql = "delete from vaitro where vaitro_id = $id";
    pdo_execute($sql);
}
function check_permission_exist($role_id, $permission_id) {
    $sql = "SELECT * FROM chi_tiet_nhom_quyen WHERE role_id = ? AND permission_id = ?";
    return pdo_query_one($sql, $role_id, $permission_id);
}


?>
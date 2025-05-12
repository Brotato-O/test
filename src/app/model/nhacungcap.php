<?php
function load_ncc($ncc_id)
{
    $sql = "SELECT * FROM nhacungcap WHERE ncc_id = '$ncc_id'";
    $res = pdo_query_one($sql);
    return $res;
}

function loadAllNcc()
{
    $sql = "SELECT * FROM nhacungcap WHERE ncc_trangthai = 0";
    $res = pdo_queryall($sql);
    return $res;
}

function loadThongTinNCC($ncc_id)
{
    $sql = "SELECT * FROM nhacungcap WHERE ncc_id = '$ncc_id'";
    $res = pdo_queryall($sql);
    return $res;
}

function update_NCC($ncc_id, $ncc_name, $ncc_email, $ncc_sdt, $ncc_diachi)
{
    $sql = "UPDATE nhacungcap SET ncc_name = '$ncc_name', ncc_email = '$ncc_email', ncc_sdt = '$ncc_sdt', ncc_diachi = '$ncc_diachi' WHERE ncc_id = '$ncc_id'";
    pdo_execute($sql);
}

function delete_ncc($ncc_id)
{
    $sql = "delete from nhacungcap where ncc_id = $ncc_id";
    pdo_execute($sql);
}

function loadall_ncc($keyword = '', $sapXep = 'id', $thuTu = 'asc')
{
    $sql = "SELECT * FROM nhacungcap WHERE 1";

    if ($keyword != '') {
        $sql .= " AND ncc_name LIKE '%$keyword%'";
    }

    // Xác định cột để sắp xếp
    switch ($sapXep) {
        case 'name':
            $sql .= " ORDER BY ncc_name";
            break;
        case 'id':
        default:
            $sql .= " ORDER BY ncc_id";
            break;
    }

    // Xác định thứ tự sắp xếp
    $sql .= " " . ($thuTu == 'desc' ? 'DESC' : 'ASC');

    $listNCC = pdo_queryall($sql);
    return $listNCC;
}

<?php
function query_allreceipts(){
    $sql = "SELECT 
    ir.id,
    ir.receipt_date,
    ir.total_amount,
    ir.status,
    ir.note,
    s.ncc_name AS supplier_name,
    u.kh_name AS created_by_name
FROM import_receipts ir
JOIN nhacungcap s ON ir.ncc_id = s.ncc_id
JOIN khachhang u ON ir.created_by = u.kh_id
";
    $result = pdo_queryall($sql);
    return $result;
}
function insert_receipt_return_id($ncc_id, $receipt_date, $total_price, $created_by, $status, $note) {
    try {
        $conn = get_connect();
        $sql = "INSERT INTO import_receipts (ncc_id, receipt_date, total_amount, created_by, status, note)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ncc_id, $receipt_date, $total_price, $created_by, $status, $note]);
        return $conn->lastInsertId(); // dùng connection đã insert để lấy ID
    } catch (PDOException $e) {
        echo "❌ Lỗi khi thêm phiếu nhập: " . $e->getMessage();
        return 0;
    }
}

function insert_receipt_detail($receipt_id, $pro_id, $color_id, $size_id, $quantity, $unit_price, $total_price) {
    $sql = "INSERT INTO import_receipt_details (receipt_id, pro_id, color_id, size_id, quantity, unit_price, total_price)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $receipt_id, $pro_id, $color_id, $size_id, $quantity, $unit_price, $total_price);
}
function delete_receipt_completely($receipt_id) {
    try {
        $conn = get_connect();
        $conn->beginTransaction();

        // Xóa chi tiết trước
        $sql_details = "DELETE FROM import_receipt_details WHERE receipt_id = ?";
        $stmt_details = $conn->prepare($sql_details);
        $stmt_details->execute([$receipt_id]);

        // Xóa phiếu chính
        $sql_main = "DELETE FROM import_receipts WHERE id = ?";
        $stmt_main = $conn->prepare($sql_main);
        $stmt_main->execute([$receipt_id]);

        $conn->commit();
       
    } catch (PDOException $e) {
        $conn->rollBack();
      
    }
}


?>
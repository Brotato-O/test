<?php
function query_allreceipts($searchSupplier = '')
{
    $sql = "SELECT 
    ir.id,
    ir.receipt_date,
    ir.status,
    ir.note,
    s.ncc_name AS supplier_name,
    u.kh_name AS created_by_name
FROM import_receipts ir
JOIN nhacungcap s ON ir.ncc_id = s.ncc_id
JOIN khachhang u ON ir.created_by = u.kh_id
";

    // Add search condition if searchSupplier is provided
    if ($searchSupplier != '') {
        $sql .= " WHERE s.ncc_name LIKE '%$searchSupplier%'";
    }

    // Order by latest receipts first
    $sql .= " ORDER BY ir.id DESC";

    $result = pdo_queryall($sql);
    return $result;
}
function insert_receipt_return_id($ncc_id, $receipt_date, $created_by, $status, $note)
{
    try {
        $conn = get_connect();
        $sql = "INSERT INTO import_receipts (ncc_id, receipt_date, created_by, status, note)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$ncc_id, $receipt_date, $created_by, $status, $note]);
        return $conn->lastInsertId(); // dùng connection đã insert để lấy ID
    } catch (PDOException $e) {
        echo "❌ Lỗi khi thêm phiếu nhập: " . $e->getMessage();
        return 0;
    }
}

// Hàm lấy chi tiết của một phiếu nhập
function get_receipt_details($receipt_id)
{
    // Lấy thông tin phiếu nhập
    $sql_receipt = "SELECT 
        ir.id, 
        ir.receipt_date, 
        ir.status, 
        ir.note,
        s.ncc_id,
        s.ncc_name AS supplier_name,
        s.ncc_diachi,
        s.ncc_sdt,
        s.ncc_email,
        u.kh_name AS created_by_name
    FROM import_receipts ir
    JOIN nhacungcap s ON ir.ncc_id = s.ncc_id
    JOIN khachhang u ON ir.created_by = u.kh_id
    WHERE ir.id = ?";

    $receipt = pdo_query_one($sql_receipt, $receipt_id);

    // Lấy các chi tiết phiếu nhập
    $sql_details = "SELECT 
        ird.id,
        ird.receipt_id,
        ird.pro_id,
        ird.color_id,
        ird.size_id,
        ird.quantity,
        ird.unit_price,
        ird.total_price,
        p.pro_name,
        p.pro_img,
        c.color_name,
        c.color_ma,
        s.size_name
    FROM import_receipt_details ird
    JOIN products p ON ird.pro_id = p.pro_id
    JOIN color c ON ird.color_id = c.color_id
    JOIN size s ON ird.size_id = s.size_id
    WHERE ird.receipt_id = ?";

    $details = pdo_queryall($sql_details, $receipt_id);

    return [
        'receipt' => $receipt,
        'details' => $details
    ];
}

function insert_receipt_detail($receipt_id, $pro_id, $color_id, $size_id, $quantity, $unit_price, $total_price)
{
    $sql = "INSERT INTO import_receipt_details (receipt_id, pro_id, color_id, size_id, quantity, unit_price, total_price)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $receipt_id, $pro_id, $color_id, $size_id, $quantity, $unit_price, $total_price);

    // Không cập nhật số lượng tồn kho ngay lập tức
    // Chỉ cập nhật khi phiếu nhập được chuyển sang trạng thái "Đã nhập kho"

    return true;
}

// Hàm cập nhật số lượng tồn kho khi nhập hàng
function update_product_stock($pro_id, $color_id, $size_id, $quantity)
{
    // Kiểm tra xem đã có bản ghi trong pro_chitiet chưa
    $sql_check = "SELECT * FROM pro_chitiet WHERE pro_id = ? AND color_id = ? AND size_id = ?";
    $result = pdo_query_one($sql_check, $pro_id, $color_id, $size_id);

    if ($result) {
        // Nếu đã có, cập nhật số lượng
        $sql = "UPDATE pro_chitiet SET soluong = soluong + ? WHERE pro_id = ? AND color_id = ? AND size_id = ?";
        pdo_execute($sql, $quantity, $pro_id, $color_id, $size_id);
    } else {
        // Nếu chưa có, thêm mới
        $sql = "INSERT INTO pro_chitiet (pro_id, color_id, size_id, soluong) VALUES (?, ?, ?, ?)";
        pdo_execute($sql, $pro_id, $color_id, $size_id, $quantity);
    }

    return true;
}

// Hàm cập nhật trạng thái phiếu nhập
function update_receipt_status($receipt_id, $status, $note)
{
    try {
        // Lấy trạng thái cũ của phiếu nhập
        $sql_old_status = "SELECT status FROM import_receipts WHERE id = ?";
        $old_status = pdo_query_one($sql_old_status, $receipt_id);

        // Cập nhật trạng thái và ghi chú
        $sql = "UPDATE import_receipts SET status = ?, note = ? WHERE id = ?";
        pdo_execute($sql, $status, $note, $receipt_id);

        // Nếu trạng thái cũ là "Nháp" (0) và trạng thái mới là "Đã nhập kho" (1)
        // thì cập nhật số lượng tồn kho cho tất cả sản phẩm trong phiếu
        if ($old_status['status'] == 0 && $status == 1) {
            // Lấy tất cả sản phẩm trong phiếu nhập
            $sql_details = "SELECT pro_id, color_id, size_id, quantity 
                           FROM import_receipt_details 
                           WHERE receipt_id = ?";
            $details = pdo_queryall($sql_details, $receipt_id);

            // Cập nhật số lượng tồn kho cho từng sản phẩm
            foreach ($details as $item) {
                update_product_stock(
                    $item['pro_id'],
                    $item['color_id'],
                    $item['size_id'],
                    $item['quantity']
                );
            }
        }

        // Nếu trạng thái cũ là "Đã nhập kho" (1) và trạng thái mới là "Đã hủy" (2)
        // thì giảm số lượng tồn kho
        if ($old_status['status'] == 1 && $status == 2) {
            // Lấy tất cả sản phẩm trong phiếu nhập
            $sql_details = "SELECT pro_id, color_id, size_id, quantity 
                           FROM import_receipt_details 
                           WHERE receipt_id = ?";
            $details = pdo_queryall($sql_details, $receipt_id);

            // Giảm số lượng tồn kho cho từng sản phẩm
            foreach ($details as $item) {
                // Sử dụng giá trị âm để giảm số lượng
                update_product_stock(
                    $item['pro_id'],
                    $item['color_id'],
                    $item['size_id'],
                    -$item['quantity']
                );
            }
        }

        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Hàm xóa chi tiết phiếu nhập
function delete_receipt_detail($detail_id)
{
    try {
        // CHÍNH SÁCH QUẢN LÝ: Không cho phép xóa chi tiết phiếu nhập sau khi đã tạo
        // để đảm bảo tính toàn vẹn dữ liệu và theo dõi hàng hóa
        return false;

        // Code bên dưới không được thực thi
        // Lấy thông tin chi tiết trước khi xóa để cập nhật lại số lượng tồn kho
        $sql_get = "SELECT receipt_id, pro_id, color_id, size_id, quantity FROM import_receipt_details WHERE id = ?";
        $detail = pdo_query_one($sql_get, $detail_id);

        if ($detail) {
            // Kiểm tra trạng thái phiếu nhập
            $sql_check = "SELECT status FROM import_receipts WHERE id = ?";
            $receipt = pdo_query_one($sql_check, $detail['receipt_id']);

            // Nếu phiếu đã nhập kho (status = 1), cần giảm số lượng tồn kho khi xóa chi tiết
            if ($receipt && $receipt['status'] == 1) {
                // Cập nhật giảm số lượng tồn kho
                $sql_update = "UPDATE pro_chitiet 
                              SET soluong = GREATEST(0, soluong - ?) 
                              WHERE pro_id = ? AND color_id = ? AND size_id = ?";
                pdo_execute($sql_update, $detail['quantity'], $detail['pro_id'], $detail['color_id'], $detail['size_id']);
            }

            // Xóa chi tiết
            $sql_delete = "DELETE FROM import_receipt_details WHERE id = ?";
            pdo_execute($sql_delete, $detail_id);

            return true;
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

function delete_receipt_completely($receipt_id)
{
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
        return true;
    } catch (PDOException $e) {
        $conn->rollBack();
        return false;
    }
}

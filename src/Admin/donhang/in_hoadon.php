<?php
// Khi file này được gọi trực tiếp từ controller, các biến đã được truyền vào:
// $thongtindh: thông tin đơn hàng
// $chitietdh: chi tiết đơn hàng

// Đảm bảo rằng không có bất kỳ output nào trước khi tạo PDF
ob_clean();

// Đường dẫn chuẩn đến thư viện FPDF
$standard_fpdf_path = __DIR__ . '/../../vendor/fpdf/fpdf.php';

// Kiểm tra xem thư viện FPDF có tồn tại không
if (file_exists($standard_fpdf_path)) {
    require_once $standard_fpdf_path;
} else {
    // Thử nhiều cách khác nhau để xác định vị trí của file FPDF
    $fpdf_paths = [
        __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php', // FPDF từ Composer
        __DIR__ . '/../../vendor/fpdf/fpdf.php',         // Thư mục vendor thông thường
        __DIR__ . '/../../../vendor/fpdf/fpdf.php',      // Thư mục vendor bên ngoài src
        $_SERVER['DOCUMENT_ROOT'] . '/vendor/fpdf/fpdf.php' // Đường dẫn tuyệt đối
    ];

    $fpdf_loaded = false;
    foreach ($fpdf_paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            $fpdf_loaded = true;
            break;
        }
    }

    // Nếu không tìm thấy FPDF, hiển thị thông báo lỗi và hướng dẫn
    if (!$fpdf_loaded) {
        echo '<div style="background-color:#FFCCCC; padding:20px; margin:20px; border:1px solid #FF0000; font-family:Arial, sans-serif;">';
        echo '<h2>Lỗi: Không tìm thấy thư viện FPDF</h2>';
        echo '<p>Để sử dụng chức năng in hóa đơn, bạn cần cài đặt thư viện FPDF.</p>';
        echo '<p>Bạn có thể cài đặt thư viện này bằng cách:</p>';
        echo '<ol>';
        echo '<li><a href="indexadmin.php?act=install_fpdf" target="_blank">Nhấn vào đây để cài đặt tự động</a>, hoặc</li>';
        echo '<li>Tải thư viện FPDF từ <a href="http://www.fpdf.org/">http://www.fpdf.org/</a> và giải nén vào thư mục: ' . dirname($standard_fpdf_path) . '</li>';
        echo '</ol>';
        echo '<p>Sau khi cài đặt, hãy thử lại chức năng in hóa đơn.</p>';
        echo '</div>';
        exit;
    }
}

class PDF extends FPDF
{
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Trang ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Kiểm tra xem biến $thongtindh và $chitietdh đã được truyền vào chưa
if (!isset($thongtindh) || !isset($chitietdh) || empty($thongtindh) || empty($chitietdh)) {
    echo '<div style="background-color:#FFCCCC; padding:20px; margin:20px; border:1px solid #FF0000; font-family:Arial, sans-serif;">';
    echo '<h2>Lỗi: Thiếu thông tin đơn hàng</h2>';
    echo '<p>Không thể tạo hóa đơn vì thiếu thông tin cần thiết.</p>';
    echo '<p>Vui lòng quay lại <a href="indexadmin.php?act=donhang">danh sách đơn hàng</a> và thử lại.</p>';
    echo '</div>';
    exit;
}

// Tạo object PDF mới
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Lấy thông tin đơn hàng
$order_id = $thongtindh['order_id'];
$kh_name = $thongtindh['kh_name'];
$kh_tel = $thongtindh['kh_tel'];
$kh_address = $thongtindh['kh_address'];
$kh_mail = $thongtindh['kh_mail'];
$order_date = $thongtindh['order_date'];
$order_totalprice = $thongtindh['order_totalprice'];
$order_trangthai = $thongtindh['order_trangthai'];

// Thông tin hóa đơn
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'HOA DON BAN HANG', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'THÔNG TIN HÓA ĐƠN', 0, 1, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(120, 8, 'Mã hóa đơn:', 0);
$pdf->Cell(0, 8, $order_id, 0, 1);
$pdf->Cell(120, 8, 'Ngày lập:', 0);
$pdf->Cell(0, 8, $order_date, 0, 1);
$pdf->Cell(120, 8, 'Trạng thái:', 0);
$pdf->Cell(0, 8, $order_trangthai, 0, 1);
$pdf->Ln(5);

// Thông tin khách hàng
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'THÔNG TIN KHÁCH HÀNG', 0, 1, 'C');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(120, 8, 'Tên khách hàng:', 0);
$pdf->Cell(0, 8, $kh_name, 0, 1);
$pdf->Cell(120, 8, 'Địa chỉ:', 0);
$pdf->Cell(0, 8, $kh_address, 0, 1);
$pdf->Cell(120, 8, 'Điện thoại:', 0);
$pdf->Cell(0, 8, $kh_tel, 0, 1);
$pdf->Cell(120, 8, 'Email:', 0);
$pdf->Cell(0, 8, $kh_mail, 0, 1);
$pdf->Ln(5);

// Chi tiết đơn hàng
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'CHI TIẾT ĐƠN HÀNG', 0, 1, 'C');

// Tiêu đề bảng
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'STT', 1, 0, 'C');
$pdf->Cell(65, 10, 'Tên sản phẩm', 1, 0, 'C');
$pdf->Cell(20, 10, 'Màu sắc', 1, 0, 'C');
$pdf->Cell(15, 10, 'Size', 1, 0, 'C');
$pdf->Cell(30, 10, 'Đơn giá', 1, 0, 'C');
$pdf->Cell(15, 10, 'SL', 1, 0, 'C');
$pdf->Cell(30, 10, 'Thành tiền', 1, 1, 'C');

// Dữ liệu bảng
$pdf->SetFont('Arial', '', 9);
$i = 1;
$total = 0;
foreach ($chitietdh as $item) {
    $pro_name = isset($item['pro_name']) ? $item['pro_name'] : 'Sản phẩm #' . $i;
    $color_name = isset($item['color_name']) ? $item['color_name'] : '';
    $size_name = isset($item['size_name']) ? $item['size_name'] : '';
    $pro_price = isset($item['pro_price']) ? $item['pro_price'] : 0;
    $soluong = isset($item['soluong']) ? $item['soluong'] : 0;
    $total_price = isset($item['total_price']) ? $item['total_price'] : 0;

    $pdf->Cell(10, 8, $i, 1, 0, 'C');
    $pdf->Cell(65, 8, $pro_name, 1, 0, 'L');
    $pdf->Cell(20, 8, $color_name, 1, 0, 'C');
    $pdf->Cell(15, 8, $size_name, 1, 0, 'C');
    $pdf->Cell(30, 8, '$ ' . number_format($pro_price, 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(15, 8, $soluong, 1, 0, 'C');
    $pdf->Cell(30, 8, '$ ' . number_format($total_price, 0, ',', '.'), 1, 1, 'R');
    $i++;
    $total += $total_price;
}

// Tổng tiền
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(155, 10, 'Tổng tiền thanh toán:', 1, 0, 'R');
$pdf->Cell(30, 10, '$ ' . number_format($order_totalprice, 0, ',', '.'), 1, 1, 'R');

// Chân trang
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 6, 'Xin cảm ơn quý khách đã mua hàng tại cửa hàng của chúng tôi!', 0, 1, 'R');
$pdf->Cell(0, 6, 'Mọi thắc mắc xin vui lòng liên hệ: hotline 0123456789', 0, 1, 'R');

// Xuất file PDF
$pdf->Output('HoaDon_' . $order_id . '.pdf', 'I');
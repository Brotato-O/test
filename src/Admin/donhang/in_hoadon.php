<?php
// Khi file này được gọi trực tiếp từ controller, các biến đã được truyền vào:
// $thongtindh: thông tin đơn hàng
// $chitietdh: chi tiết đơn hàng

// Đảm bảo rằng không có bất kỳ output nào trước khi tạo PDF
ob_clean();

// Thử nhiều cách khác nhau để xác định vị trí của file FPDF
$fpdf_paths = [
    __DIR__ . '/../../vendor/setasign/fpdf/fpdf.php', // FPDF từ Composer
    __DIR__ . '/../../vendor/fpdf/fpdf.php',         // Thư mục vendor thông thường
    __DIR__ . '/../../../vendor/fpdf/fpdf.php',      // Thư mục vendor bên ngoài src
    $_SERVER['DOCUMENT_ROOT'] . '/PTTKHT/PHP_Ecommerce-main/src/vendor/fpdf/fpdf.php' // Đường dẫn tuyệt đối
];

$fpdf_loaded = false;
foreach ($fpdf_paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        $fpdf_loaded = true;
        break;
    }
}

// Nếu không tìm thấy FPDF, tạo lớp giả lập đơn giản
if (!$fpdf_loaded) {
    class FPDF
    {
        function __construct() {}
        function AliasNbPages() {}
        function AddPage() {}
        function SetFont() {}
        function Header() {}
        function Footer() {}
        function SetY() {}
        function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
        {
            echo $txt . "<br>";
        }
        function Ln()
        {
            echo "<br>";
        }
        function PageNo()
        {
            return 1;
        }
        function Output($dest = '', $name = '', $isUTF8 = false)
        {
            echo "Không thể tạo PDF: Thư viện FPDF không được tìm thấy.<br>";
            echo "Vui lòng tải thư viện FPDF từ http://www.fpdf.org/ và cài đặt đúng đường dẫn.<br>";
            echo "Đường dẫn đã thử:<br>";
            global $fpdf_paths;
            foreach ($fpdf_paths as $path) {
                echo "- $path<br>";
            }
            return "";
        }
    }

    echo '<div style="background-color:#FFCCCC; padding:10px; margin:10px; border:1px solid #FF0000;">';
    echo '<h3>Lỗi: Không tìm thấy thư viện FPDF</h3>';
    echo '<p>Ứng dụng sẽ hiển thị dữ liệu đơn hàng ở dạng HTML thay vì PDF.</p>';
    echo '<p>Để khắc phục, vui lòng tải thư viện FPDF từ <a href="http://www.fpdf.org/">http://www.fpdf.org/</a> và cài đặt vào thư mục:</p>';
    echo '<code>C:\xampp\htdocs\PTTKHT\PHP_Ecommerce-main\src\vendor\fpdf\</code>';
    echo '</div>';
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
    $pdf->Cell(10, 8, $i, 1, 0, 'C');
    $pdf->Cell(65, 8, $item['pro_name'], 1, 0, 'L');
    $pdf->Cell(20, 8, $item['color_name'], 1, 0, 'C');
    $pdf->Cell(15, 8, $item['size_name'], 1, 0, 'C');
    $pdf->Cell(30, 8, '$ ' . number_format($item['pro_price'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(15, 8, $item['soluong'], 1, 0, 'C');
    $pdf->Cell(30, 8, '$ ' . number_format($item['total_price'], 0, ',', '.'), 1, 1, 'R');
    $i++;
    $total += $item['total_price'];
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
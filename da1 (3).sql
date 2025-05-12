-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 11, 2025 lúc 02:22 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `da1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(10) NOT NULL COMMENT 'Id giỏ hàng',
  `kh_id` int(10) NOT NULL COMMENT 'ID khách hàng',
  `tongtien` int(50) NOT NULL COMMENT 'Tổng tiền'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `kh_id`, `tongtien`) VALUES
(1, 41, 0),
(2, 42, 0),
(4, 11, 0),
(5, 43, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_chitiet`
--

CREATE TABLE `cart_chitiet` (
  `cart_chitiet_id` int(10) NOT NULL COMMENT 'Chi tiết giỏ hàng',
  `cart_id` int(10) NOT NULL COMMENT 'ID giỏ hàng',
  `pro_id` int(10) NOT NULL COMMENT 'ID sản phẩm',
  `color_id` int(10) NOT NULL COMMENT 'ID màu',
  `size_id` int(10) NOT NULL COMMENT 'ID size',
  `price` int(50) NOT NULL COMMENT 'Đơn giá sản phẩm',
  `soluong` int(20) NOT NULL COMMENT 'Số lượng',
  `total_price` int(20) NOT NULL COMMENT 'Tổng tiền'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `cate_id` int(10) NOT NULL,
  `cate_name` varchar(55) NOT NULL,
  `trangthai` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`cate_id`, `cate_name`, `trangthai`) VALUES
(1, 'T-Shirts', 0),
(2, 'Shoes', 0),
(3, 'Accessories', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_kiem_ke`
--

CREATE TABLE `chi_tiet_kiem_ke` (
  `id` int(11) NOT NULL,
  `phieu_kiem_ke_id` int(11) DEFAULT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `so_luong_thuc_te` int(11) DEFAULT NULL,
  `so_luong_he_thong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_nhom_quyen`
--

CREATE TABLE `chi_tiet_nhom_quyen` (
  `role_id` int(10) NOT NULL,
  `permission_id` varchar(10) NOT NULL,
  `hanh_dong` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_nhom_quyen`
--

INSERT INTO `chi_tiet_nhom_quyen` (`role_id`, `permission_id`, `hanh_dong`) VALUES
(1, 'Q14', NULL),
(1, 'Q15', NULL),
(1, 'Q3', NULL),
(1, 'Q6', NULL),
(3, 'Q3', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `color`
--

CREATE TABLE `color` (
  `color_id` int(10) NOT NULL COMMENT 'ID màu',
  `color_name` varchar(50) NOT NULL COMMENT 'Tên màu',
  `color_ma` varchar(50) NOT NULL COMMENT 'Mã màu css'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `color`
--

INSERT INTO `color` (`color_id`, `color_name`, `color_ma`) VALUES
(1, 'Xanh', 'aquamarine'),
(2, 'Vàng', 'Yellow'),
(3, 'Trắng', '#FFFFFF');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coment`
--

CREATE TABLE `coment` (
  `cmt_id` int(10) NOT NULL COMMENT 'ID bình luận',
  `cmt_content` text NOT NULL COMMENT 'Nội dung bình luận',
  `cmt_date` varchar(50) NOT NULL DEFAULT current_timestamp() COMMENT 'Ngày bình luận',
  `pro_id` int(10) NOT NULL COMMENT 'ID Sản phẩm',
  `kh_id` int(10) NOT NULL COMMENT 'Id Khách hàng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_receipts`
--

CREATE TABLE `import_receipts` (
  `id` int(11) NOT NULL,
  `ncc_id` int(11) NOT NULL COMMENT 'ID nhà cung cấp',
  `receipt_date` datetime NOT NULL COMMENT 'Ngày nhập hàng',
  `total_amount` decimal(15,2) NOT NULL COMMENT 'Tổng giá trị đơn nhập',
  `created_by` int(11) DEFAULT NULL COMMENT 'Người tạo phiếu',
  `status` tinyint(4) DEFAULT 0 COMMENT '0: Nháp, 1: Đã nhập kho, 2: Đã hủy',
  `note` text DEFAULT NULL COMMENT 'Ghi chú'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `import_receipts`
--

INSERT INTO `import_receipts` (`id`, `ncc_id`, `receipt_date`, `total_amount`, `created_by`, `status`, `note`) VALUES
(1, 3, '2025-04-22 08:40:05', 600.00, 41, 1, NULL),
(3, 1, '2025-04-22 09:46:13', 20000.00, 41, 0, ''),
(4, 1, '2025-04-22 09:49:23', 20000.00, 41, 0, ''),
(5, 1, '2025-04-22 09:50:01', 400.00, 41, 0, ''),
(6, 1, '2025-04-22 09:52:49', 400.00, 41, 0, ''),
(7, 1, '2025-04-22 09:54:06', 400.00, 41, 0, ''),
(8, 1, '2025-04-22 09:55:29', 400.00, 41, 0, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_receipt_details`
--

CREATE TABLE `import_receipt_details` (
  `id` int(11) NOT NULL,
  `receipt_id` int(11) NOT NULL COMMENT 'ID phiếu nhập',
  `pro_id` int(11) NOT NULL COMMENT 'ID sản phẩm',
  `color_id` int(11) NOT NULL COMMENT 'ID màu sắc',
  `size_id` int(11) NOT NULL COMMENT 'ID kích cỡ',
  `quantity` int(11) NOT NULL COMMENT 'Số lượng nhập',
  `unit_price` decimal(10,2) NOT NULL COMMENT 'Đơn giá nhập',
  `total_price` decimal(12,2) NOT NULL COMMENT 'Thành tiền'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `kh_id` int(11) NOT NULL,
  `kh_name` varchar(55) NOT NULL,
  `kh_pass` varchar(55) NOT NULL,
  `kh_mail` varchar(255) NOT NULL,
  `kh_tel` varchar(55) NOT NULL,
  `kh_address` varchar(255) NOT NULL,
  `vaitro_id` int(11) NOT NULL,
  `trangthai` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`kh_id`, `kh_name`, `kh_pass`, `kh_mail`, `kh_tel`, `kh_address`, `vaitro_id`, `trangthai`) VALUES
(11, 'Abc123', 'Abc@123', 'Abc@gmail.com', '1234567891', 'Tp HCM', 1, 0),
(12, 'Abc1234', 'Abc@1234', 'Abc1234@gmail.com', '1234567891', 'TP HCM', 3, 0),
(36, 'admin', 'Phonglb2004@', 'luongbaphong20041@gmail.com', '0398748313', 'Hà Nội', 1, 0),
(39, 'PhongLB', 'Phonglb2004@', 'admin@gmail.com', '0398748313', 'Hà Nội', 2, 0),
(41, 'nguyendanhquan', 'Quan123@', 'quan23566888@gmail.com', '0967016683', 'Hà Nội', 1, 0),
(42, 'Danhquan', 'Quan123@', 'trung@gmail.com', '0967016683', 'Hà Nội', 2, 0),
(43, 'Abcc', 'Abc@123', 'onepiecekkzz@gmail.com', '0906840111', 'quan23566888@gmail.com', 2, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `ncc_id` int(10) NOT NULL COMMENT 'ID nhà cung cấp',
  `ncc_name` varchar(255) NOT NULL COMMENT 'Tên nhà cung cấp',
  `ncc_diachi` varchar(255) NOT NULL COMMENT 'Địa chỉ nhà cung cấp',
  `ncc_sdt` varchar(20) NOT NULL COMMENT 'Số điện thoại nhà cung cấp',
  `ncc_email` varchar(255) NOT NULL COMMENT 'Email nhà cung cấp',
  `ncc_trangthai` int(1) NOT NULL DEFAULT 0 COMMENT 'Trạng thái (0: hoạt động, 1: ngừng hoạt động)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`ncc_id`, `ncc_name`, `ncc_diachi`, `ncc_sdt`, `ncc_email`, `ncc_trangthai`) VALUES
(1, 'Công ty Thời trang Việt Nam', 'Số 1, Đường Lê Duẩn, Hà Nội', '0241234567', 'contact@thoitrangvn.com', 0),
(2, 'Công ty May mặc Hải Phòng', 'Số 45, Đường Trần Phú, Hải Phòng', '0225123456', 'info@maymachp.com', 0),
(3, 'Công ty Dệt may Đà Nẵng', 'Số 78, Đường Nguyễn Văn Linh, Đà Nẵng', '0236123456', 'contact@detmaydn.com', 0),
(4, 'Công ty Thời trang Sài Gòn', 'Số 123, Đường Nguyễn Huệ, TP.HCM', '0281234567', 'info@thoitrangsg.com', 0),
(5, 'Công ty Vải sợi Bắc Ninh', 'Số 56, Đường Nguyễn Trãi, Bắc Ninh', '0222123456', 'contact@vaisoi.com', 0),
(6, 'Công ty Phụ liệu may mặc', 'Số 89, Đường Lê Lợi, Hải Dương', '0220123456', 'info@phulieu.com', 0),
(7, 'Công ty Thời trang cao cấp', 'Số 34, Đường Tràng Tiền, Hà Nội', '0241234568', 'contact@caocap.com', 0),
(8, 'Công ty Vải vóc nhập khẩu', 'Số 67, Đường Hai Bà Trưng, TP.HCM', '0281234568', 'info@vainhapkhau.com', 0),
(9, 'Công ty Phụ kiện thời trang', 'Số 12, Đường Lý Thường Kiệt, Đà Nẵng', '0236123457', 'contact@phukien.com', 0),
(10, 'Công ty Thời trang trẻ em', 'Số 45, Đường Lê Văn Sỹ, TP.HCM', '0281234569', 'info@treem.com', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `order_id` int(10) NOT NULL COMMENT 'ID hóa đơn',
  `kh_id` int(10) NOT NULL COMMENT 'ID khách hàng',
  `order_date` varchar(20) NOT NULL COMMENT 'Ngày đặt hàng',
  `order_trangthai` varchar(50) NOT NULL COMMENT 'Trạng thái đơn hàng',
  `order_adress` varchar(250) NOT NULL COMMENT 'Địa chỉ giao hàng',
  `order_totalprice` int(50) NOT NULL COMMENT 'Tổng tiền hóa đơn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`order_id`, `kh_id`, `order_date`, `order_trangthai`, `order_adress`, `order_totalprice`) VALUES
(137, 41, '11-05-25', 'Đang chờ xác nhận', '', 210),
(138, 41, '11-05-25', 'Đang chờ xác nhận', '', 330),
(139, 41, '11-05-25', 'Đang chờ xác nhận', '', 130),
(140, 41, '11-05-25', 'Đang chờ xác nhận', '', 130),
(141, 41, '11-05-25', 'Đang chờ xác nhận', '', 130),
(142, 41, '11-05-25', 'Đang chờ xác nhận', '', 343),
(143, 41, '11-05-25', 'Đang chờ xác nhận', 'Tan Binh', 121);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_chitiet`
--

CREATE TABLE `order_chitiet` (
  `order_chitiet_id` int(10) NOT NULL COMMENT 'ID chi tiết hóa đơn',
  `order_id` int(10) NOT NULL COMMENT 'ID hóa đơn',
  `pro_id` int(10) NOT NULL COMMENT 'ID sản phẩm',
  `color_id` int(10) NOT NULL COMMENT 'Mã màu',
  `size_id` int(10) NOT NULL COMMENT 'Id size',
  `pro_price` int(50) NOT NULL COMMENT 'Đơn giá sản phẩm',
  `soluong` int(20) NOT NULL COMMENT 'Số lượng sản phẩm',
  `total_price` int(25) NOT NULL COMMENT 'Tổng tiền hóa đơn chi tiết'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_chitiet`
--

INSERT INTO `order_chitiet` (`order_chitiet_id`, `order_id`, `pro_id`, `color_id`, `size_id`, `pro_price`, `soluong`, `total_price`) VALUES
(112, 137, 1, 3, 2, 200, 1, 200),
(113, 137, 1, 3, 2, 200, 1, 200),
(114, 138, 76, 3, 2, 120, 1, 120),
(115, 138, 1, 3, 2, 200, 1, 200),
(116, 138, 76, 3, 2, 120, 1, 120),
(117, 139, 76, 3, 3, 120, 1, 120),
(118, 139, 76, 3, 3, 120, 1, 120),
(119, 140, 76, 3, 3, 120, 1, 120),
(120, 141, 76, 3, 3, 120, 1, 120),
(121, 141, 76, 3, 3, 120, 1, 120),
(122, 142, 76, 3, 3, 111, 3, 333),
(123, 142, 76, 3, 3, 111, 3, 333),
(124, 143, 76, 3, 3, 111, 1, 111),
(125, 143, 76, 3, 3, 111, 1, 111);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_bao_hanh`
--

CREATE TABLE `phieu_bao_hanh` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `kh_id` int(11) DEFAULT NULL,
  `nhan_vien_id` int(11) DEFAULT NULL,
  `ngay_bao_hanh` date DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `thoi_gian_bao_hanh` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_doi`
--

CREATE TABLE `phieu_doi` (
  `id` int(10) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pro_id` int(10) NOT NULL,
  `pro_moi_id` int(10) DEFAULT NULL,
  `color_id` int(10) DEFAULT NULL,
  `size_id` int(10) DEFAULT NULL,
  `kh_id` int(11) NOT NULL,
  `ngay_doi` date DEFAULT NULL,
  `ly_do` text DEFAULT NULL,
  `trang_thai` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieu_kiem_ke`
--

CREATE TABLE `phieu_kiem_ke` (
  `id` int(11) NOT NULL,
  `nhan_vien_id` int(11) DEFAULT NULL,
  `ngay_kiem_ke` date DEFAULT NULL,
  `so_luong_thuc_te` int(11) DEFAULT 0,
  `chenh_lech` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `pro_id` int(10) NOT NULL,
  `pro_name` varchar(255) NOT NULL,
  `pro_img` varchar(255) NOT NULL,
  `pro_price` float NOT NULL,
  `pro_desc` text NOT NULL,
  `pro_brand` varchar(55) NOT NULL,
  `pro_stock` int(11) NOT NULL,
  `cate_id` int(10) NOT NULL,
  `ncc_id` int(10) NOT NULL DEFAULT 1 COMMENT 'ID nhà cung cấp',
  `trangthai` int(1) NOT NULL,
  `pro_viewer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`pro_id`, `pro_name`, `pro_img`, `pro_price`, `pro_desc`, `pro_brand`, `pro_stock`, `cate_id`, `ncc_id`, `trangthai`, `pro_viewer`) VALUES
(1, 'Brazil 2024 Stadium Home', 'ao1.jpg', 200, 'We updated the most iconic kit in the football world with an all-over print that celebrates Brazil\'s architecture, music and natural wonders. Look inside the shirt for a hidden detail celebrating national pride.\r\nColour Shown: Dynamic Yellow/Lemon Chiffon/Green Spark\r\nStyle: FJ4284-706\r\nCountry/Region of Origin: Indonesia', 'Lining', 150, 1, 1, 0, 14),
(2, 'FFF (Men\'s Team) 2024/25 Stadium Away', 'ao2.jpg', 150, 'French fashion and the FFF collide in their 2024/25 Away kit. The design has classic pinstripes commonly found in fashion houses and also on France shirts from the 1980s and 2000s. The oversized Cockerel crest continues the celebration of vintage shirts.', 'Lining', 150, 1, 1, 0, 12),
(3, 'Nike Rise 365 Run Energy', 'ao3.jpg', 120, 'This lightweight running top is made from breathable, sweat-wicking mesh in a relaxed fit. Graphics celebrate those feel-good chemicals released in the mind by running.', 'Lining', 150, 1, 2, 0, 13),
(4, 'Liverpool F.C. 2024/25 Stadium Home', 'ao4.jpg', 210, 'Our Stadium collection pairs replica design details with sweat-wicking technology to give you a game-ready look inspired by your favourite team.', 'Nice', 150, 1, 3, 0, 11),
(5, 'Liverpool F.C. Academy Pro', 'ao5.jpg', 220, 'After conquering the basics, take your skills to the next level. A classic, traditional fit works together with moisture-wicking technology to help keep you cool when your training heats up.', 'Nice', 110, 1, 1, 0, 9),
(6, 'Liverpool F.C. 2024/25 Match Away', 'ao6.jpg', 250, 'Our Match collection lets you wear exactly what the pros wear. We paired authentic design details with lightweight, quick-drying technology to help keep you cool and comfortable on the pitch.', 'Nice', 110, 1, 1, 0, 15),
(7, 'Paris Saint-Germain 2024/25 Stadium Away', 'ao7.jpg', 230, 'Like other shirts from our Stadium collection, this one pairs replica design details with sweat-wicking fabric to give you a game-ready look inspired by your favourite team.', 'Nice', 90, 1, 1, 0, 12),
(8, 'Manchester United \'91 Away Jersey', 'ao8.jpg', 160, 'Manchester United became kings of Europe\'s cup winners in 1991 and this football jersey is part of a collection marking that special victory. A one-to-one remake of the adidas shirts the players wore while they celebrated on the Rotterdam pitch, it includes intricate cuff and collar detailing and a subtle all-over pattern. A special cup final badge stands out from comfortable jacquard fabric clad in white away colours.', 'Lining', 80, 1, 7, 0, 15),
(9, 'Nike Mercurial Superfly 10 Elite x Air Max 95 SE', 'g1.jpg', 450, 'As we celebrate the 30th anniversary of the Air Max 95, it\'s only right we toast the rarefied AIR allegiance between the lifestyle icon and meteoric Mercurial. This special Superfly 10 Elite nods to our most iconic Air Max colourway and combines it with our most responsive Mercurial ever. From the glossy heel to the embroidered Swoosh logo to the plate graphic, this mash-up matches the original shoe worn by lightning-fast superstars and one of the greatest teams ever.', 'Nice', 100, 2, 1, 0, 12),
(10, 'Nike Mercurial Superfly 10 Academy', 'g2.jpg', 120, 'Looking to take your speed to the next level? We made these Academy boots with an improved heel Air Zoom unit. It gives you the propulsive feel needed to break through the back line. The result is the most responsive Mercurial we\'ve ever made, so you can dictate pace and tempo all match long.', 'Nice', 120, 2, 1, 0, 13),
(11, 'Nike Mercurial Superfly 10 Club', 'g3.jpg', 60, 'Whether you\'re starting out or just playing for fun, the Club boot gets you on the pitch without compromising on quality. The Superfly 10 is made with speed in mind. Mix that velocity with touch and comfort? It’s goal time.', 'Nice', 80, 2, 1, 0, 16),
(12, 'Nike Mercurial Vapor 16 Academy \'Kylian Mbappé\'', 'g6.jpg', 110, 'Looking to take your speed to the next level? We made these Academy boots with an improved heel Air Zoom unit. It gives you and Kylian Mbappé the propulsive feel needed to break through the back line. The result is the most responsive Mercurial we\'ve ever made, so you can dictate pace and tempo all match long.', 'Nice', 110, 2, 1, 0, 25),
(13, 'Nike Tiempo Legend 10 Club', 'g7.jpg', 80, 'Even Legends find ways to evolve. Whether you\'re starting out or just playing for fun, the latest iteration of these Club shoes gets you on the pitch without compromising on quality. The synthetic leather contours to your foot and doesn\'t overstretch, giving you better control. Lighter and sleeker than any other Tiempo to date, the Legend 10 is for any position on the pitch, whether you\'re sending a pinpoint pass through the defence or tracking back to stop a break-away.', 'Nice', 110, 2, 1, 0, 14),
(14, 'Nike Mercurial Superfly 10 Club\r\n', 'g8.jpg', 80, 'Whether you\'re starting out or just playing for fun, Club shoes get you on the pitch without compromising on quality. The Superfly 10 is made with speed in mind. Mix that velocity with touch and comfort? It’s goal time.', 'Nice', 110, 2, 1, 0, 15),
(16, 'Nike Everyday Cushioned', 'pk1.jpg', 25, 'Power through your workout with the Nike Everyday Cushioned Socks. The thick terry sole gives you extra comfort for foot drills and lifts, while a ribbed arch band wraps your midfoot for a supportive feel.', 'Nice', 120, 3, 3, 0, 20),
(17, 'Nike Everyday Cushioned', 'pk2.jpg', 20, 'Power through your workout with the Nike Everyday Cushioned Socks. The thick terry sole gives you extra comfort for foot drills and lifts, while a ribbed arch band wraps your midfoot for a supportive feel.', 'Nice', 110, 3, 2, 0, 12),
(18, 'Jordan', 'pk3.jpg', 22, 'Your go-to, everyday, soft and reliable socks. Sweat-wicking technology keeps your feet cool and dry while a snug arch band feels supportive.', 'Nice', 100, 3, 4, 0, 22),
(75, 'Nike Mercurial Superfly 8 Club TF', 'g4.jpg', 90, 'The Nike Mercurial Superfly 8 Club elevates a favourite with gold and silver accents for a look that\'s fit for champions. Grippy texture on top gives you precise control, while a rubber sole helps supercharge traction on turf.\r\n\r\n', 'Nice', 20, 2, 1, 0, 20),
(76, 'Nike Mercurial Superfly 10 Elite', 'g5.jpg', 111, 'adas', 'Nice', 22, 2, 1, 0, 26);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products_favourite`
--

CREATE TABLE `products_favourite` (
  `pro_favourite_id` int(10) NOT NULL,
  `kh_id` int(10) NOT NULL,
  `pro_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products_favourite`
--

INSERT INTO `products_favourite` (`pro_favourite_id`, `kh_id`, `pro_id`) VALUES
(130, 41, 46),
(131, 41, 49);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pro_chitiet`
--

CREATE TABLE `pro_chitiet` (
  `ctiet_pro_id` int(10) NOT NULL COMMENT 'Id chi tiết sản phẩm',
  `pro_id` int(10) NOT NULL COMMENT 'ID sản phẩm',
  `color_id` int(10) NOT NULL COMMENT 'ID màu',
  `size_id` int(10) NOT NULL COMMENT 'ID size',
  `soluong` int(10) NOT NULL COMMENT 'Số Lượng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `pro_chitiet`
--

INSERT INTO `pro_chitiet` (`ctiet_pro_id`, `pro_id`, `color_id`, `size_id`, `soluong`) VALUES
(14, 1, 3, 2, 7),
(15, 6, 2, 2, 10),
(16, 76, 3, 3, -4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ql_nhom_quyen`
--

CREATE TABLE `ql_nhom_quyen` (
  `id` int(11) NOT NULL,
  `ten_nhom_quyen` varchar(100) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `trang_thai` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quyen`
--

CREATE TABLE `quyen` (
  `permission_id` varchar(10) NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `trang_thai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quyen`
--

INSERT INTO `quyen` (`permission_id`, `permission_name`, `trang_thai`) VALUES
('Q1', 'Truy cập quản lý', 1),
('Q10', 'Quản lý thương hiệu', 1),
('Q11', 'Quản lý phiếu nhập', 1),
('Q12', 'Quản lý phiếu bảo hành', 1),
('Q13', 'Quản lý phiếu đổi/trả', 1),
('Q14', 'Quản lý phân quyền', 1),
('Q15', 'Quản lý vai trò', 1),
('Q2', 'Quản lý danh mục', 1),
('Q3', 'Quản lí sản phẩm', 1),
('Q4', 'Quản lí người dùng', 1),
('Q5', 'Quản lí bình luận', 1),
('Q6', 'Quản lí thống kê', 1),
('Q7', 'Quản lí đơn hàng', 1),
('Q8', 'Quản lí nhà cung cấp', 1),
('Q9', 'Quản lí màu', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size`
--

CREATE TABLE `size` (
  `size_id` int(10) NOT NULL COMMENT 'ID size',
  `size_name` varchar(50) NOT NULL COMMENT 'Tên size'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `size`
--

INSERT INTO `size` (`size_id`, `size_name`) VALUES
(1, 'M'),
(2, 'L'),
(3, 'XL');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuong_hieu`
--

CREATE TABLE `thuong_hieu` (
  `id` int(11) NOT NULL,
  `ten_thuong_hieu` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thuong_hieu`
--

INSERT INTO `thuong_hieu` (`id`, `ten_thuong_hieu`, `mo_ta`) VALUES
(1, 'Lining', 'Thương hiệu thời trang thể thao cao cấp'),
(2, 'Nice', 'Phong cách trẻ trung, năng động'),
(3, 'Need', 'Chuyên các sản phẩm thời trang linen'),
(4, 'Thosc', 'Thương hiệu cá tính, độc đáo'),
(5, 'Densnis', 'Đường nét thêu tay tinh xảo, thủ công');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ton_kho`
--

CREATE TABLE `ton_kho` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `soluong` int(11) NOT NULL DEFAULT 0,
  `ngay_cap_nhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vaitro`
--

CREATE TABLE `vaitro` (
  `vaitro_id` int(10) NOT NULL COMMENT 'ID vai trò',
  `vaitro_name` varchar(250) NOT NULL COMMENT 'Vai trò'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vaitro`
--

INSERT INTO `vaitro` (`vaitro_id`, `vaitro_name`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Nhân Viên'),
(4, 'Nhân Viên Kho'),
(9, 'a');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `lk_cart_kh` (`kh_id`);

--
-- Chỉ mục cho bảng `cart_chitiet`
--
ALTER TABLE `cart_chitiet`
  ADD PRIMARY KEY (`cart_chitiet_id`),
  ADD KEY `lk_chitetcart_cart` (`cart_id`),
  ADD KEY `lk_chitetcart_color` (`color_id`),
  ADD KEY `lk_chitetcart_size` (`size_id`),
  ADD KEY `lk_cartchitiet_pro` (`pro_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cate_id`);

--
-- Chỉ mục cho bảng `chi_tiet_kiem_ke`
--
ALTER TABLE `chi_tiet_kiem_ke`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phieu_kiem_ke_id` (`phieu_kiem_ke_id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Chỉ mục cho bảng `chi_tiet_nhom_quyen`
--
ALTER TABLE `chi_tiet_nhom_quyen`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Chỉ mục cho bảng `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`color_id`);

--
-- Chỉ mục cho bảng `coment`
--
ALTER TABLE `coment`
  ADD PRIMARY KEY (`cmt_id`),
  ADD KEY `lk_cmt_kh` (`kh_id`),
  ADD KEY `lk_cmt_pro` (`pro_id`);

--
-- Chỉ mục cho bảng `import_receipts`
--
ALTER TABLE `import_receipts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ncc_id` (`ncc_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Chỉ mục cho bảng `import_receipt_details`
--
ALTER TABLE `import_receipt_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipt_id` (`receipt_id`),
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`kh_id`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`ncc_id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `lk_order_khs` (`kh_id`);

--
-- Chỉ mục cho bảng `order_chitiet`
--
ALTER TABLE `order_chitiet`
  ADD PRIMARY KEY (`order_chitiet_id`),
  ADD KEY `lk_orderchitiet_order` (`order_id`),
  ADD KEY `lk_orderchitiet_color` (`color_id`),
  ADD KEY `lk_orderchitiet_size` (`size_id`),
  ADD KEY `lk_orderchitiet_pro` (`pro_id`);

--
-- Chỉ mục cho bảng `phieu_bao_hanh`
--
ALTER TABLE `phieu_bao_hanh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `fk_baohanh_khachhang` (`kh_id`),
  ADD KEY `fk_baohanh_nhanvien` (`nhan_vien_id`);

--
-- Chỉ mục cho bảng `phieu_doi`
--
ALTER TABLE `phieu_doi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_phieudoi_order` (`order_id`),
  ADD KEY `fk_phieudoi_pro` (`pro_id`),
  ADD KEY `fk_phieudoi_promoi` (`pro_moi_id`),
  ADD KEY `fk_phieudoi_color` (`color_id`),
  ADD KEY `fk_phieudoi_size` (`size_id`),
  ADD KEY `fk_phieudoi_khachhang` (`kh_id`);

--
-- Chỉ mục cho bảng `phieu_kiem_ke`
--
ALTER TABLE `phieu_kiem_ke`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kiemke_nhanvien` (`nhan_vien_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `cate_id` (`cate_id`),
  ADD KEY `ncc_id` (`ncc_id`);

--
-- Chỉ mục cho bảng `products_favourite`
--
ALTER TABLE `products_favourite`
  ADD PRIMARY KEY (`pro_favourite_id`),
  ADD KEY `FK_kh` (`kh_id`),
  ADD KEY `Fk_pro` (`pro_id`);

--
-- Chỉ mục cho bảng `pro_chitiet`
--
ALTER TABLE `pro_chitiet`
  ADD PRIMARY KEY (`ctiet_pro_id`),
  ADD KEY `lk_pro_color` (`color_id`),
  ADD KEY `lk_pro_size` (`size_id`),
  ADD KEY `lk_proctiet_pro` (`pro_id`);

--
-- Chỉ mục cho bảng `ql_nhom_quyen`
--
ALTER TABLE `ql_nhom_quyen`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quyen`
--
ALTER TABLE `quyen`
  ADD PRIMARY KEY (`permission_id`);

--
-- Chỉ mục cho bảng `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`size_id`);

--
-- Chỉ mục cho bảng `thuong_hieu`
--
ALTER TABLE `thuong_hieu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ton_kho`
--
ALTER TABLE `ton_kho`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_kho` (`pro_id`,`color_id`,`size_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Chỉ mục cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  ADD PRIMARY KEY (`vaitro_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Id giỏ hàng', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `cart_chitiet`
--
ALTER TABLE `cart_chitiet`
  MODIFY `cart_chitiet_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Chi tiết giỏ hàng', AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `cate_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_kiem_ke`
--
ALTER TABLE `chi_tiet_kiem_ke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `color`
--
ALTER TABLE `color`
  MODIFY `color_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID màu', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `coment`
--
ALTER TABLE `coment`
  MODIFY `cmt_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID bình luận', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `import_receipts`
--
ALTER TABLE `import_receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `import_receipt_details`
--
ALTER TABLE `import_receipt_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `kh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  MODIFY `ncc_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID nhà cung cấp', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID hóa đơn', AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT cho bảng `order_chitiet`
--
ALTER TABLE `order_chitiet`
  MODIFY `order_chitiet_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID chi tiết hóa đơn', AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT cho bảng `phieu_bao_hanh`
--
ALTER TABLE `phieu_bao_hanh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `phieu_doi`
--
ALTER TABLE `phieu_doi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `phieu_kiem_ke`
--
ALTER TABLE `phieu_kiem_ke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `pro_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT cho bảng `products_favourite`
--
ALTER TABLE `products_favourite`
  MODIFY `pro_favourite_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT cho bảng `pro_chitiet`
--
ALTER TABLE `pro_chitiet`
  MODIFY `ctiet_pro_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Id chi tiết sản phẩm', AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `ql_nhom_quyen`
--
ALTER TABLE `ql_nhom_quyen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `size`
--
ALTER TABLE `size`
  MODIFY `size_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID size', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `thuong_hieu`
--
ALTER TABLE `thuong_hieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `ton_kho`
--
ALTER TABLE `ton_kho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `vaitro`
--
ALTER TABLE `vaitro`
  MODIFY `vaitro_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID vai trò', AUTO_INCREMENT=10;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `lk_cart_kh` FOREIGN KEY (`kh_id`) REFERENCES `khachhang` (`kh_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `cart_chitiet`
--
ALTER TABLE `cart_chitiet`
  ADD CONSTRAINT `lk_cartchitiet_pro` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lk_chitetcart_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lk_chitetcart_color` FOREIGN KEY (`color_id`) REFERENCES `color` (`color_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lk_chitetcart_size` FOREIGN KEY (`size_id`) REFERENCES `size` (`size_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chi_tiet_kiem_ke`
--
ALTER TABLE `chi_tiet_kiem_ke`
  ADD CONSTRAINT `chi_tiet_kiem_ke_ibfk_1` FOREIGN KEY (`phieu_kiem_ke_id`) REFERENCES `phieu_kiem_ke` (`id`),
  ADD CONSTRAINT `chi_tiet_kiem_ke_ibfk_2` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`);

--
-- Các ràng buộc cho bảng `chi_tiet_nhom_quyen`
--
ALTER TABLE `chi_tiet_nhom_quyen`
  ADD CONSTRAINT `chi_tiet_nhom_quyen_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `vaitro` (`vaitro_id`),
  ADD CONSTRAINT `chi_tiet_nhom_quyen_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `quyen` (`permission_id`);

--
-- Các ràng buộc cho bảng `coment`
--
ALTER TABLE `coment`
  ADD CONSTRAINT `lk_cmt_kh` FOREIGN KEY (`kh_id`) REFERENCES `khachhang` (`kh_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lk_cmt_pro` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `import_receipts`
--
ALTER TABLE `import_receipts`
  ADD CONSTRAINT `import_receipts_ibfk_1` FOREIGN KEY (`ncc_id`) REFERENCES `nhacungcap` (`ncc_id`),
  ADD CONSTRAINT `import_receipts_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `khachhang` (`kh_id`);

--
-- Các ràng buộc cho bảng `import_receipt_details`
--
ALTER TABLE `import_receipt_details`
  ADD CONSTRAINT `fk_receipt` FOREIGN KEY (`receipt_id`) REFERENCES `import_receipts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `import_receipt_details_ibfk_1` FOREIGN KEY (`receipt_id`) REFERENCES `import_receipts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `import_receipt_details_ibfk_2` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`),
  ADD CONSTRAINT `import_receipt_details_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `color` (`color_id`),
  ADD CONSTRAINT `import_receipt_details_ibfk_4` FOREIGN KEY (`size_id`) REFERENCES `size` (`size_id`);

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `lk_order_khs` FOREIGN KEY (`kh_id`) REFERENCES `khachhang` (`kh_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `order_chitiet`
--
ALTER TABLE `order_chitiet`
  ADD CONSTRAINT `lk_orderchitiet_color` FOREIGN KEY (`color_id`) REFERENCES `color` (`color_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lk_orderchitiet_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lk_orderchitiet_pro` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lk_orderchitiet_size` FOREIGN KEY (`size_id`) REFERENCES `size` (`size_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `phieu_bao_hanh`
--
ALTER TABLE `phieu_bao_hanh`
  ADD CONSTRAINT `fk_baohanh_khachhang` FOREIGN KEY (`kh_id`) REFERENCES `khachhang` (`kh_id`),
  ADD CONSTRAINT `fk_baohanh_nhanvien` FOREIGN KEY (`nhan_vien_id`) REFERENCES `khachhang` (`kh_id`),
  ADD CONSTRAINT `phieu_bao_hanh_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`),
  ADD CONSTRAINT `phieu_bao_hanh_ibfk_2` FOREIGN KEY (`kh_id`) REFERENCES `khachhang` (`kh_id`),
  ADD CONSTRAINT `phieu_bao_hanh_ibfk_3` FOREIGN KEY (`nhan_vien_id`) REFERENCES `khachhang` (`kh_id`);

--
-- Các ràng buộc cho bảng `phieu_doi`
--
ALTER TABLE `phieu_doi`
  ADD CONSTRAINT `fk_phieudoi_color` FOREIGN KEY (`color_id`) REFERENCES `color` (`color_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_phieudoi_khachhang` FOREIGN KEY (`kh_id`) REFERENCES `khachhang` (`kh_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_phieudoi_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_phieudoi_pro` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_phieudoi_promoi` FOREIGN KEY (`pro_moi_id`) REFERENCES `products` (`pro_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_phieudoi_size` FOREIGN KEY (`size_id`) REFERENCES `size` (`size_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `phieu_kiem_ke`
--
ALTER TABLE `phieu_kiem_ke`
  ADD CONSTRAINT `fk_kiemke_nhanvien` FOREIGN KEY (`nhan_vien_id`) REFERENCES `khachhang` (`kh_id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_nhacungcap` FOREIGN KEY (`ncc_id`) REFERENCES `nhacungcap` (`ncc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `category` (`cate_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `pro_chitiet`
--
ALTER TABLE `pro_chitiet`
  ADD CONSTRAINT `lk_pro_color` FOREIGN KEY (`color_id`) REFERENCES `color` (`color_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lk_pro_size` FOREIGN KEY (`size_id`) REFERENCES `size` (`size_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lk_proctiet_pro` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `ton_kho`
--
ALTER TABLE `ton_kho`
  ADD CONSTRAINT `ton_kho_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`),
  ADD CONSTRAINT `ton_kho_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `color` (`color_id`),
  ADD CONSTRAINT `ton_kho_ibfk_3` FOREIGN KEY (`size_id`) REFERENCES `size` (`size_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

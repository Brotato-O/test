-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 22, 2025 lúc 04:56 PM
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

--
-- Đang đổ dữ liệu cho bảng `cart_chitiet`
--

INSERT INTO `cart_chitiet` (`cart_chitiet_id`, `cart_id`, `pro_id`, `color_id`, `size_id`, `price`, `soluong`, `total_price`) VALUES
(36, 2, 66, 3, 3, 300, 1, 300),
(79, 1, 66, 2, 1, 300, 1, 300),
(80, 2, 66, 2, 3, 300, 1, 300),
(81, 1, 63, 1, 1, 130, 1, 130);

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
(9, 'blazer', 0),
(10, 'hoodies', 0),
(11, 'caps', 0),
(12, 'trourser', 0),
(13, 't-shirt', 0),
(14, 'shorts', 0),
(15, 'sweater', 0);

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

--
-- Đang đổ dữ liệu cho bảng `coment`
--

INSERT INTO `coment` (`cmt_id`, `cmt_content`, `cmt_date`, `pro_id`, `kh_id`) VALUES
(8, 'ỵgj', '2023-12-01 08:55:45', 66, 41),
(9, 'sản phẩm tốt\r\n', '2023-12-03 20:33:25', 66, 41),
(10, 'Sản Phẩm Chất lượng cao\r\n', '2023-12-04 11:02:22', 65, 41),
(11, 'đấ\r\ndsadsa', '2025-04-16 12:13:02', 58, 36);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_receipts`
--

CREATE TABLE `import_receipts` (
  `id` int(11) NOT NULL,
  `ncc_id` int(11) NOT NULL COMMENT 'ID nhà cung cấp',
  `receipt_date` datetime NOT NULL COMMENT 'Ngày nhập hàng',
  `created_by` int(11) DEFAULT NULL COMMENT 'Người tạo phiếu',
  `status` tinyint(4) DEFAULT 0 COMMENT '0: Nháp, 1: Đã nhập kho, 2: Đã hủy',
  `note` text DEFAULT NULL COMMENT 'Ghi chú'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `import_receipts`
--

INSERT INTO `import_receipts` (`id`, `ncc_id`, `receipt_date`, `created_by`, `status`, `note`) VALUES
(1, 3, '2025-04-22 08:40:05', 41, 1, NULL),
(3, 1, '2025-04-22 09:46:13', 41, 0, ''),
(4, 1, '2025-04-22 09:49:23', 41, 0, ''),
(5, 1, '2025-04-22 09:50:01', 41, 0, ''),
(6, 1, '2025-04-22 09:52:49', 41, 0, ''),
(7, 1, '2025-04-22 09:54:06', 41, 0, ''),
(8, 1, '2025-04-22 09:55:29', 41, 0, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `import_receipt_details`
--

CREATE TABLE `import_receipt_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_id` int(11) NOT NULL COMMENT 'ID phiếu nhập',
  `pro_id` int(11) NOT NULL COMMENT 'ID sản phẩm',
  `color_id` int(11) NOT NULL COMMENT 'ID màu sắc',
  `size_id` int(11) NOT NULL COMMENT 'ID kích cỡ',
  `quantity` int(11) NOT NULL COMMENT 'Số lượng nhập',
  `unit_price` decimal(10,2) NOT NULL COMMENT 'Đơn giá nhập',
  `total_price` decimal(12,2) NOT NULL COMMENT 'Thành tiền',
  PRIMARY KEY (`id`)
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
(26, 41, '24-11-23', 'Đã hủy', '', 310),
(33, 41, '24-11-23', 'Đang giao hàng', '', 770),
(100, 41, '01-12-23', 'Đã hủy', '', 455),
(104, 41, '02-12-23', 'Đã giao hàng', '', 140),
(130, 41, '03-12-23', 'Đã hủy', '', 440),
(131, 41, '03-12-23', 'Đang giao hàng', '', 310),
(132, 41, '04-12-23', 'Đã hủy', '', 310),
(133, 41, '04-12-23', 'Đã hủy', '', 310),
(134, 41, '04-12-23', 'Đang giao hàng', '', 310),
(135, 41, '06-12-23', 'Đang giao hàng', '', 310),
(136, 11, '16-04-25', 'Đang giao hàng', 'Tan Binh', 310);

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
(72, 100, 66, 2, 1, 300, 1, 300),
(73, 100, 61, 2, 3, 145, 1, 145),
(77, 104, 63, 1, 1, 130, 1, 130),
(103, 130, 66, 1, 2, 300, 1, 300),
(104, 130, 63, 1, 1, 130, 1, 130),
(105, 131, 66, 1, 2, 300, 1, 300),
(106, 132, 66, 1, 2, 300, 1, 300),
(107, 133, 66, 1, 2, 300, 1, 300),
(108, 134, 66, 1, 2, 300, 1, 300),
(109, 135, 66, 1, 3, 300, 1, 300),
(110, 136, 66, 2, 1, 300, 1, 300),
(111, 136, 66, 2, 1, 300, 1, 300);

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

--
-- Đang đổ dữ liệu cho bảng `phieu_bao_hanh`
--

INSERT INTO `phieu_bao_hanh` (`id`, `pro_id`, `kh_id`, `nhan_vien_id`, `ngay_bao_hanh`, `noi_dung`, `thoi_gian_bao_hanh`) VALUES
(1, 44, 11, 41, '2025-04-09', 'khâu', 11);

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

--
-- Đang đổ dữ liệu cho bảng `phieu_doi`
--

INSERT INTO `phieu_doi` (`id`, `order_id`, `pro_id`, `pro_moi_id`, `color_id`, `size_id`, `kh_id`, `ngay_doi`, `ly_do`, `trang_thai`) VALUES
(1, 100, 57, 52, 2, 2, 11, '2025-04-03', NULL, 'đổi'),
(2, 131, 57, NULL, NULL, NULL, 11, '2025-04-02', NULL, 'trả/ hoàn tiền');

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
(41, 'Fleece Hoodies For Men and Women Patchwork Stripe Hooded', 'clothes_1.jpg', 130, 'Usually We Will Send Out the Goods Within 3 - 7 Days by Fast and Reliable Shipping Methods. As different computers display colors differently, the color of the actual item may very slightly from the above images. Your Happy Shopping Experience and Five Star Feedback is Very Important to Us. Please Feel Free to Contact Us if You Have Any Questions. We Will Try Our Best to Serve You.', 'Lining', 230, 10, 1, 0, 1),
(43, 'School Leavers Hoodie - School Leavers 2023 Hoodie - Class Of 2023 Hoodie', 'clothes_2.jpg', 300, 'Usually We Will Send Out the Goods Within 3 - 7 Days by Fast and Reliable Shipping Methods. As different computers display colors differently, the color of the actual item may very slightly from the above images. Your Happy Shopping Experience and Five Star Feedback is Very Important to Us. Please Feel Free to Contact Us if You Have Any Questions. We Will Try Our Best to Serve You.', 'Nice', 230, 10, 1, 0, 0),
(44, 'Branded Premium Basic Mesh Shorts', 'clothes_3.jpg', 200, 'Branded Premium Basic Mesh Shorts Mesh 2 Pockets Eric Emanuel New York City Skyline Basketball shorts', 'Lining', 130, 14, 1, 0, 0),
(45, 'High Waist Trousers Pants Palazzo Bottoms Casual Loose Wide Leg Long Harem', 'clothes_4.jpg', 50, 'Usually We Will Send Out the Goods Within 3 - 7 Days by Fast and Reliable Shipping Methods. As different computers display colors differently, the color of the actual item may very slightly from the above images. Your Happy Shopping Experience and Five Star Feedback is Very Important to Us. Please Feel Free to Contact Us if You Have Any Questions. We Will Try Our Best to Serve You.', 'Lining', 230, 12, 1, 0, 0),
(46, 'Wizard Frog Corduroy Hat, Handmade Embroidered Corduroy Dad Cap', 'clothes_5.jpg', 50, 'All clothes are tailored and handmade with love and attention to details. Pure natural linen materials, comfortable, breathable, refreshing and soft fabric', 'Nice', 300, 11, 1, 0, 1),
(47, 'Women Linen Blazer, Linen Jacket Linen Blazer 3/4 Sleeves Coat', 'clothes_6.jpg', 300, 'All clothes are tailored and handmade with love and attention to details. Pure natural linen materials, comfortable, breathable, refreshing and soft fabric', 'Nice', 130, 9, 1, 0, 2),
(48, 'Masculine-cut Blazer with Contrasting Details', 'clothes_7.jpg', 150, 'An oversize blazer with masculine cut and contrasting seam details. An avant-garde piece with linen and tulle elements. Bold addition to any elegant outfit.', 'Need', 400, 9, 1, 0, 0),
(49, 'Sorrows, Sorrows, Prayers Tshirt, Queen Charlotte Fan Shirt, Bridgerton T-Shirt', 'clothes_8.jpg', 100, 'Unisex Heavy Cotton Tee Gildan 5000: Medium fabric - Classic fit - Runs true to size - 100% cotton (fiber content may vary for different colors) - Tear-away label. Unisex Heavy Blend™ Crewneck Sweatshirt Gildan 18000: Medium-heavy fabric - Loose fit - Runs true to size - 50% cotton, 50% polyester - Sewn-in label', 'Lining', 450, 13, 1, 0, 2),
(51, 'Hat Embroidered Hat Dad Hat Womens Baseball Cap Man Hat', 'clothes_10.jpg', 50, 'Usually We Will Send Out the Goods Within 3 - 7 Days by Fast and Reliable Shipping Methods. As different computers display colors differently, the color of the actual item may very slightly from the above images. Your Happy Shopping Experience and Five Star Feedback is Very Important to Us. Please Feel Free to Contact Us if You Have Any Questions. We Will Try Our Best to Serve You.', 'Lining', 230, 11, 1, 0, 0),
(52, 'Chicken Sweatshirt, Farm Life Sweater, Chicken Lover Sweater, Easter Retro Sweater', 'clothes_11.jpg', 130, 'Welcome to Prime Tee Lab. Your all-inclusive stop for all custom sweatshirt, hoodie, and gift needs. We print on the highest quality garments! Our state of the art printers help us bring you the most vibrant and long lasting colorful designs.', 'Nice', 300, 15, 1, 0, 0),
(53, 'Have A Good Day Hoodie- Trendy sweatshirt, hoodie', 'clothes_12.jpg', 300, 'Have A Good Day Hoodie- Trendy sweatshirt, hoodie, Sweatshirt and hoodies with words on back. Hey there, welcome to my store! I hope you will love my store.', 'Thosc', 300, 10, 1, 0, 5),
(54, 'Floral Embroidered Cap, Baseball Cap, Custom Embroidery Hat, Hand Embroidery Hat', 'clothes_13.jpg', 50, 'A pretty hand embroidered cap that is perfect for everyday wear! Available in different colors and designs. Feel free to send me a message for any custom work!', 'Lining', 300, 11, 1, 0, 2),
(55, 'Drawstring Pants - Spring Summer Trousers - Pockets', 'clothes_14.jpg', 300, 'Stay comfortable and stylish with these cotton and linen drawstring pants for women. Designed with a basic style and loose fit, these mid-waist trousers have a nine-point length and trendy button details. Plus, they come with pockets to keep your essentials handy. Available in light gray, white, dark gray,', 'Nice', 130, 12, 1, 0, 1),
(56, 'Loose linen blazer PLACID Long sleeve light linen jacket  Linen womens clothing', 'clothes_15.jpg', 300, 'Womens linen blazer PLACID in lightweight linen with front button closure is an autumn wardrobes essential', 'Need', 230, 9, 1, 0, 2),
(57, 'Baseball Hat with Embroidery - Embroidered & Cap Color of your choice! Dad Hat', 'clothes_16.jpg', 130, 'Due to the current covid situation, there may be delays in international shipment. We hope for your kind understanding. Please let us know if you have a specific date that you would like to receive by. Orders that have been shipped out are non-refundable.', 'Thosc', 300, 11, 1, 0, 1),
(58, 'Embroidered Silly Goose Sweatshirt, Embroidered Goose Crewneck Sweats', 'clothes_17.jpg', 120, 'This embroidered Silly Goose sweatshirt is super soft and cozy. Perfect to lounge around, run errands, or walk your dog. Our crewnecks use the highest quality material for ultra-soft and comfortable wear, with advanced embroidery to ensure vibrant colors and detailed graphics.', 'Densnis', 320, 15, 1, 0, 2),
(59, 'Embroidered Hat Initial cap Personalized Ball cap Custom Hat Mens Hat 90s Vintagea', 'clothes_18.jpg', 100, 'Personalize these comfortable and stylish dad hats to say whatever you like. A traditional baseball cap is a great way to show off your style. one-of-a-kind gift for any occasion such as Mothers Day, Fathers Day, birthday gifts, Bachelor party, Christmas etc. We can not only customize the text', 'Need', 230, 11, 1, 0, 4),
(60, 'Thin Cotton Blazer Loose Linen Jackets Pockets Soft Linen Coats Three Quarter Single Button', 'clothes_19.jpg', 300, 'Cotton Blazer Loose Linen Jackets Pockets Soft Linen Coats Three Quarter Single Button. Please refer to the final image for size chart before ordering (and choose the correct size).', 'Densnis', 230, 9, 1, 0, 3),
(61, 'Fashion Sweaters Men Autumn Solid Color Wool Sweaters Slim Fit', 'clothes_20.jpg', 145, 'Fashion Sweaters Men Autumn Solid Color Wool Sweaters Slim Fit Men Street Wear Mens Clothes Knitted Sweater Men Pullovers', 'Lining', 130, 15, 1, 0, 2),
(62, 'portrait from photo to shirt, outline photo sweatshirt, Custom Photo, custom portrait, Couple Hoodie', 'clothes_21.jpg', 130, 'Set-in sleeve 1x1 rib at neck collar Inside back neck tape in self fabric Tubular construction Sleeve hem and bottom hem with wide double topstitch Comfortable crew neckline', 'Need', 300, 10, 1, 0, 5),
(63, 'Cotton Corduroy Pant Elastic Waist Pants Womens Soft Warm trousers baggy pants Casual', 'clothes_22.jpg', 130, 'All our items are Tailored and Handmade and Made to Order ,I can make Any Size . I design new styles every week, please collect my store. I believe that you will meet your favorite styles.', 'Densnis', 125, 12, 1, 0, 5),
(64, 'Knitted Sweater Little Dinosaur, Unisex, Winter Harajuku', 'clothes_23.jpg', 160, 'Super soft comfortable knitted sweater. A perfect gift for streetwear style lovers and a perfect harajuku outfit.', 'Thosc', 300, 15, 1, 0, 4),
(65, 'Japanese Harajuku Style Hoodies, Streetwear Oversized Hoodie, Thick Winter Autumn Pullover', 'clothes_24.jpg', 300, 'Recommend ordering two sizes up. MATERIAL: Cotton, PolyesterIt is printed with eco-friendly ink. Soft and comfy hoodie with a print of Japanese graphic art. This kawaii clothing pullover is an excellent addition to your wardrobe.', 'Densnis', 230, 10, 1, 0, 11),
(66, 'Unleash Your Summer Swag with High-Quality Fear Of God Shorts for Men and Women', 'clothes_25.jpg', 300, 'Upgrade your summer wardrobe with our exclusive collection of Essentials Shorts for both men and women! Discover the perfect blend of comfort and style with our high-quality Fear Of God shorts, designed to elevate your streetwear game to new heights. Whether youre hitting the beach or strolling through the city, these trendy FOG shorts are a must-have for any fashion-conscious individual. Embrace the essence of urban fashion and make a bold statement this summer with our eye-catching streetwear essentials. Get ready to turn heads and exude confidence wherever you go!', 'Lining', 300, 14, 1, 0, 40);

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
(1, 44, 57),
(3, 44, 44),
(11, 44, 65),
(12, 44, 62),
(23, 44, 64),
(24, 44, 64),
(25, 44, 65),
(30, 44, 62),
(31, 44, 63),
(34, 48, 57),
(35, 48, 54),
(36, 48, 44),
(37, 48, 41),
(38, 48, 59),
(39, 48, 51),
(40, 48, 56),
(41, 48, 46),
(42, 44, 43),
(116, 41, 66),
(117, 41, 65),
(119, 41, 64),
(120, 41, 63),
(127, 41, 59),
(128, 41, 62),
(129, 41, 53),
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
-- Product ID: 41 - Fleece Hoodies
(14, 41, 1, 1, 70),  -- Xanh, M
(15, 41, 1, 2, 80),  -- Xanh, L
(16, 41, 2, 2, 80),  -- Vàng, L

-- Product ID: 43 - School Leavers Hoodie
(17, 43, 2, 1, 75),  -- Vàng, M
(18, 43, 2, 3, 80),  -- Vàng, XL
(19, 43, 3, 2, 75),  -- Trắng, L

-- Product ID: 44 - Branded Premium Basic Mesh Shorts
(20, 44, 1, 1, 40),  -- Xanh, M
(21, 44, 1, 2, 50),  -- Xanh, L
(22, 44, 3, 1, 40),  -- Trắng, M

-- Product ID: 45 - High Waist Trousers
(23, 45, 2, 2, 75),  -- Vàng, L
(24, 45, 3, 1, 80),  -- Trắng, M
(25, 45, 3, 3, 75),  -- Trắng, XL

-- Product ID: 46 - Wizard Frog Corduroy Hat
(26, 46, 1, 1, 100), -- Xanh, M
(27, 46, 2, 1, 100), -- Vàng, M
(28, 46, 3, 1, 100), -- Trắng, M

-- Product ID: 47 - Women Linen Blazer
(29, 47, 1, 1, 40),  -- Xanh, M
(30, 47, 1, 2, 45),  -- Xanh, L
(31, 47, 3, 2, 45),  -- Trắng, L

-- Product ID: 48 - Masculine-cut Blazer
(32, 48, 1, 2, 130), -- Xanh, L
(33, 48, 1, 3, 135), -- Xanh, XL
(34, 48, 3, 3, 135), -- Trắng, XL

-- Product ID: 49 - Sorrows Tshirt
(35, 49, 1, 1, 150), -- Xanh, M
(36, 49, 2, 2, 150), -- Vàng, L
(37, 49, 3, 3, 150), -- Trắng, XL

-- Product ID: 51 - Hat Embroidered Hat
(38, 51, 1, 1, 75),  -- Xanh, M
(39, 51, 2, 1, 75),  -- Vàng, M
(40, 51, 3, 1, 80),  -- Trắng, M

-- Product ID: 52 - Chicken Sweatshirt
(41, 52, 1, 1, 100), -- Xanh, M
(42, 52, 1, 2, 100), -- Xanh, L
(43, 52, 2, 2, 100), -- Vàng, L

-- Product ID: 53 - Have A Good Day Hoodie
(44, 53, 1, 2, 100), -- Xanh, L
(45, 53, 2, 1, 100), -- Vàng, M
(46, 53, 3, 3, 100), -- Trắng, XL

-- Product ID: 54 - Floral Embroidered Cap
(47, 54, 1, 1, 100), -- Xanh, M
(48, 54, 2, 1, 100), -- Vàng, M
(49, 54, 3, 1, 100), -- Trắng, M

-- Product ID: 55 - Drawstring Pants
(50, 55, 1, 1, 40),  -- Xanh, M
(51, 55, 1, 2, 45),  -- Xanh, L
(52, 55, 3, 3, 45),  -- Trắng, XL

-- Product ID: 56 - Loose linen blazer
(53, 56, 1, 1, 75),  -- Xanh, M
(54, 56, 1, 2, 80),  -- Xanh, L
(55, 56, 3, 2, 75),  -- Trắng, L

-- Product ID: 57 - Baseball Hat with Embroidery
(56, 57, 1, 1, 100), -- Xanh, M
(57, 57, 2, 1, 100), -- Vàng, M
(58, 57, 3, 1, 100), -- Trắng, M

-- Product ID: 58 - Embroidered Silly Goose Sweatshirt
(59, 58, 1, 1, 105), -- Xanh, M
(60, 58, 1, 2, 110), -- Xanh, L
(61, 58, 2, 3, 105), -- Vàng, XL

-- Product ID: 59 - Embroidered Hat Initial cap
(62, 59, 1, 1, 75),  -- Xanh, M
(63, 59, 2, 1, 80),  -- Vàng, M
(64, 59, 3, 1, 75),  -- Trắng, M

-- Product ID: 60 - Thin Cotton Blazer
(65, 60, 1, 2, 75),  -- Xanh, L
(66, 60, 1, 3, 80),  -- Xanh, XL
(67, 60, 3, 2, 75),  -- Trắng, L

-- Product ID: 61 đã có trong dữ liệu ban đầu
-- thêm một màu và kích thước khác
(68, 61, 1, 2, 60),  -- Xanh, L
(69, 61, 3, 1, 59),  -- Trắng, M

-- Product ID: 62 - portrait from photo to shirt
(70, 62, 1, 1, 100), -- Xanh, M
(71, 62, 1, 2, 100), -- Xanh, L
(72, 62, 2, 3, 100), -- Vàng, XL

-- Product ID: 63 đã có trong dữ liệu ban đầu
-- thêm một màu và kích thước khác
(73, 63, 2, 2, 40),  -- Vàng, L
(74, 63, 3, 3, 41),  -- Trắng, XL

-- Product ID: 64 - Knitted Sweater Little Dinosaur
(75, 64, 1, 1, 100), -- Xanh, M
(76, 64, 1, 2, 100), -- Xanh, L
(77, 64, 2, 3, 100), -- Vàng, XL

-- Product ID: 65 - Japanese Harajuku Style Hoodies
(78, 65, 1, 2, 75),  -- Xanh, L
(79, 65, 2, 1, 80),  -- Vàng, M
(80, 65, 3, 3, 75),  -- Trắng, XL

-- Product ID: 66 đã có trong dữ liệu ban đầu
-- thêm một màu và kích thước khác
(81, 66, 2, 3, 100), -- Vàng, XL
(82, 66, 3, 2, 100); -- Trắng, L
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
  -- ADD PRIMARY KEY (`id`),
  ADD KEY `receipt_id` (`receipt_id`),
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `size_id` (`size_id`);


INSERT INTO `import_receipt_details` (`receipt_id`, `pro_id`, `color_id`, `size_id`, `quantity`, `unit_price`, `total_price`) VALUES
-- Phiếu nhập 1 (ID: 1 - Công ty Dệt may Đà Nẵng)
(1, 66, 2, 1, 10, 200.00, 2000.00),
(1, 66, 3, 2, 5, 200.00, 1000.00),
(1, 65, 1, 2, 8, 180.00, 1440.00),

-- Phiếu nhập 3 (ID: 3 - Công ty Thời trang Việt Nam)
(3, 41, 1, 1, 15, 80.00, 1200.00),
(3, 43, 2, 3, 10, 250.00, 2500.00),
(3, 53, 3, 3, 12, 220.00, 2640.00),

-- Phiếu nhập 4 (ID: 4 - Công ty Thời trang Việt Nam)
(4, 52, 1, 2, 20, 90.00, 1800.00),
(4, 49, 2, 1, 15, 70.00, 1050.00),
(4, 61, 1, 2, 10, 100.00, 1000.00),

-- Phiếu nhập 5 (ID: 5 - Công ty Thời trang Việt Nam)
(5, 63, 1, 1, 8, 90.00, 720.00),
(5, 64, 2, 3, 10, 120.00, 1200.00),

-- Phiếu nhập 6 (ID: 6 - Công ty Thời trang Việt Nam)
(6, 56, 1, 2, 6, 180.00, 1080.00),
(6, 47, 3, 2, 5, 250.00, 1250.00),

-- Phiếu nhập 7 (ID: 7 - Công ty Thời trang Việt Nam)
(7, 58, 2, 3, 12, 85.00, 1020.00),
(7, 54, 1, 1, 15, 35.00, 525.00),

-- Phiếu nhập 8 (ID: 8 - Công ty Thời trang Việt Nam)
(8, 44, 3, 1, 10, 150.00, 1500.00),
(8, 45, 2, 2, 8, 40.00, 320.00);
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
  MODIFY `cart_chitiet_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Chi tiết giỏ hàng', AUTO_INCREMENT=83;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID hóa đơn', AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT cho bảng `order_chitiet`
--
ALTER TABLE `order_chitiet`
  MODIFY `order_chitiet_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID chi tiết hóa đơn', AUTO_INCREMENT=112;

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
  MODIFY `pro_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT cho bảng `products_favourite`
--
ALTER TABLE `products_favourite`
  MODIFY `pro_favourite_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT cho bảng `pro_chitiet`
--
ALTER TABLE `pro_chitiet`
  MODIFY `ctiet_pro_id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Id chi tiết sản phẩm', AUTO_INCREMENT=14;

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

-- --------------------------------------------------------
-- Add auto-assignment of permissions to roles
-- --------------------------------------------------------

-- Clear existing permissions assignments
DELETE FROM `chi_tiet_nhom_quyen`;

-- Admin role (vaitro_id = 1) - Gets all permissions
INSERT INTO `chi_tiet_nhom_quyen` (`role_id`, `permission_id`) VALUES
(1, 'Q1'),  -- Truy cập quản lý
(1, 'Q2'),  -- Quản lý danh mục
(1, 'Q3'),  -- Quản lí sản phẩm
(1, 'Q4'),  -- Quản lí người dùng
(1, 'Q5'),  -- Quản lí bình luận
(1, 'Q6'),  -- Quản lí thống kê
(1, 'Q7'),  -- Quản lí đơn hàng
(1, 'Q8'),  -- Quản lí nhà cung cấp
(1, 'Q9'),  -- Quản lí màu
(1, 'Q10'), -- Quản lý thương hiệu
(1, 'Q11'), -- Quản lý phiếu nhập
(1, 'Q12'), -- Quản lý phiếu bảo hành
(1, 'Q13'), -- Quản lý phiếu đổi/trả
(1, 'Q14'), -- Quản lý phân quyền
(1, 'Q15'); -- Quản lý vai trò

-- Staff role (vaitro_id = 3) - Gets selected permissions
INSERT INTO `chi_tiet_nhom_quyen` (`role_id`, `permission_id`) VALUES
(3, 'Q1'),  -- Truy cập quản lý
(3, 'Q2'),  -- Quản lý danh mục
(3, 'Q3'),  -- Quản lí sản phẩm
(3, 'Q5'),  -- Quản lí bình luận
(3, 'Q7'),  -- Quản lí đơn hàng
(3, 'Q9'),  -- Quản lí màu
(3, 'Q12'), -- Quản lý phiếu bảo hành
(3, 'Q13'); -- Quản lý phiếu đổi/trả

-- Warehouse Staff role (vaitro_id = 4) - Gets inventory-related permissions
INSERT INTO `chi_tiet_nhom_quyen` (`role_id`, `permission_id`) VALUES
(4, 'Q1'),  -- Truy cập quản lý
(4, 'Q3'),  -- Quản lí sản phẩm (read-only)
(4, 'Q8'),  -- Quản lí nhà cung cấp
(4, 'Q11'); -- Quản lý phiếu nhập

-- --------------------------------------------------------
-- Additional order data for visualization
-- --------------------------------------------------------

-- For additional order data to enable visualization of sales trends across 
-- different time periods (months, quarters, years), please run the 
-- 'order_data_update.sql' script after this main database setup.
--
-- The additional data includes orders from 2022-2025 with varied products and quantities
-- to enable meaningful chart visualization in the admin dashboard.
-- SQL script to add order data at different time periods for visualization

-- Insert orders for 2022
INSERT INTO `order` (`kh_id`, `order_date`, `order_trangthai`, `order_adress`, `order_totalprice`) VALUES
(42, '15-01-22', 'Đã giao hàng', 'Hà Nội', 430),
(39, '22-02-22', 'Đã giao hàng', 'Hà Nội', 650),
(43, '10-03-22', 'Đã giao hàng', 'Hồ Chí Minh', 300),
(42, '05-04-22', 'Đã giao hàng', 'Hà Nội', 490),
(39, '18-05-22', 'Đã giao hàng', 'Hà Nội', 260),
(43, '23-06-22', 'Đã giao hàng', 'Hồ Chí Minh', 450),
(42, '09-07-22', 'Đã giao hàng', 'Hà Nội', 350),
(39, '14-08-22', 'Đã giao hàng', 'Hà Nội', 500),
(43, '28-09-22', 'Đã giao hàng', 'Hồ Chí Minh', 430),
(42, '07-10-22', 'Đã giao hàng', 'Hà Nội', 600),
(39, '19-11-22', 'Đã giao hàng', 'Hà Nội', 380),
(43, '24-12-22', 'Đã hủy', 'Hồ Chí Minh', 720);

-- Insert orders for 2023 (first half - lower sales)
INSERT INTO `order` (`kh_id`, `order_date`, `order_trangthai`, `order_adress`, `order_totalprice`) VALUES
(42, '08-01-23', 'Đã giao hàng', 'Hà Nội', 280),
(39, '17-01-23', 'Đã giao hàng', 'Hà Nội', 310),
(43, '25-01-23', 'Đã hủy', 'Hồ Chí Minh', 250),
(42, '05-02-23', 'Đã giao hàng', 'Hà Nội', 360),
(39, '14-02-23', 'Đã giao hàng', 'Hà Nội', 420),
(43, '23-02-23', 'Đã hủy', 'Hồ Chí Minh', 180),
(42, '08-03-23', 'Đã giao hàng', 'Hà Nội', 390),
(39, '17-03-23', 'Đã giao hàng', 'Hà Nội', 280),
(43, '26-03-23', 'Đã hủy', 'Hồ Chí Minh', 430),
(42, '05-04-23', 'Đã giao hàng', 'Hà Nội', 350),
(39, '15-04-23', 'Đã giao hàng', 'Hà Nội', 310),
(43, '22-04-23', 'Đã hủy', 'Hồ Chí Minh', 270),
(42, '07-05-23', 'Đã giao hàng', 'Hà Nội', 400),
(39, '16-05-23', 'Đã giao hàng', 'Hà Nội', 320),
(43, '25-05-23', 'Đã hủy', 'Hồ Chí Minh', 380),
(42, '08-06-23', 'Đã giao hàng', 'Hà Nội', 290),
(39, '19-06-23', 'Đã giao hàng', 'Hà Nội', 350),
(43, '28-06-23', 'Đã hủy', 'Hồ Chí Minh', 430);

-- Insert orders for 2023 (second half - higher sales, growth period)
INSERT INTO `order` (`kh_id`, `order_date`, `order_trangthai`, `order_adress`, `order_totalprice`) VALUES
(42, '10-07-23', 'Đã giao hàng', 'Hà Nội', 520),
(39, '17-07-23', 'Đã giao hàng', 'Hà Nội', 480),
(43, '24-07-23', 'Đã hủy', 'Hồ Chí Minh', 610),
(42, '06-08-23', 'Đã giao hàng', 'Hà Nội', 590),
(39, '13-08-23', 'Đã giao hàng', 'Hà Nội', 650),
(43, '21-08-23', 'Đã hủy', 'Hồ Chí Minh', 570),
(42, '05-09-23', 'Đã giao hàng', 'Hà Nội', 630),
(39, '14-09-23', 'Đã giao hàng', 'Hà Nội', 590),
(43, '22-09-23', 'Đã hủy', 'Hồ Chí Minh', 680),
(42, '07-10-23', 'Đã giao hàng', 'Hà Nội', 750),
(39, '16-10-23', 'Đã giao hàng', 'Hà Nội', 820),
(43, '23-10-23', 'Đã hủy', 'Hồ Chí Minh', 790),
(42, '08-11-23', 'Đã giao hàng', 'Hà Nội', 910),
(39, '15-11-23', 'Đã giao hàng', 'Hà Nội', 860),
(43, '22-11-23', 'Đã hủy', 'Hồ Chí Minh', 900),
(42, '04-12-23', 'Đã giao hàng', 'Hà Nội', 1050),
(39, '11-12-23', 'Đã giao hàng', 'Hà Nội', 980),
(43, '18-12-23', 'Đã hủy', 'Hồ Chí Minh', 1120);

-- Insert orders for 2024 (continued growth and seasonal patterns)
INSERT INTO `order` (`kh_id`, `order_date`, `order_trangthai`, `order_adress`, `order_totalprice`) VALUES
(42, '07-01-24', 'Đã giao hàng', 'Hà Nội', 780),
(39, '14-01-24', 'Đã giao hàng', 'Hà Nội', 720),
(43, '22-01-24', 'Đã hủy', 'Hồ Chí Minh', 800),
(42, '05-02-24', 'Đã giao hàng', 'Hà Nội', 920),
(39, '12-02-24', 'Đã giao hàng', 'Hà Nội', 1090),
(43, '20-02-24', 'Đã hủy', 'Hồ Chí Minh', 1150),
(42, '04-03-24', 'Đã giao hàng', 'Hà Nội', 890),
(39, '11-03-24', 'Đã giao hàng', 'Hà Nội', 750),
(43, '18-03-24', 'Đã hủy', 'Hồ Chí Minh', 810),
(42, '03-04-24', 'Đã giao hàng', 'Hà Nội', 680),
(39, '10-04-24', 'Đã giao hàng', 'Hà Nội', 730),
(43, '17-04-24', 'Đã hủy', 'Hồ Chí Minh', 690),
(42, '01-05-24', 'Đã giao hàng', 'Hà Nội', 620),
(39, '08-05-24', 'Đã giao hàng', 'Hà Nội', 580),
(43, '15-05-24', 'Đã hủy', 'Hồ Chí Minh', 640),
(42, '03-06-24', 'Đã giao hàng', 'Hà Nội', 540),
(39, '10-06-24', 'Đã giao hàng', 'Hà Nội', 600),
(43, '17-06-24', 'Đã hủy', 'Hồ Chí Minh', 560),
(42, '01-07-24', 'Đang giao hàng', 'Hà Nội', 590),
(39, '08-07-24', 'Đang giao hàng', 'Hà Nội', 630),
(43, '15-07-24', 'Đã hủy', 'Hồ Chí Minh', 540),
(42, '05-08-24', 'Đang giao hàng', 'Hà Nội', 700),
(39, '12-08-24', 'Đang giao hàng', 'Hà Nội', 750),
(43, '19-08-24', 'Đã hủy', 'Hồ Chí Minh', 800);

-- Insert orders for 2025 Q1 (current year in the data)
INSERT INTO `order` (`kh_id`, `order_date`, `order_trangthai`, `order_adress`, `order_totalprice`) VALUES
(42, '06-01-25', 'Đã giao hàng', 'Hà Nội', 870),
(39, '13-01-25', 'Đã giao hàng', 'Hà Nội', 920),
(43, '20-01-25', 'Đã hủy', 'Hồ Chí Minh', 860),
(42, '03-02-25', 'Đã giao hàng', 'Hà Nội', 950),
(39, '10-02-25', 'Đã giao hàng', 'Hà Nội', 1020),
(43, '17-02-25', 'Đã hủy', 'Hồ Chí Minh', 980),
(42, '05-03-25', 'Đã giao hàng', 'Hà Nội', 910),
(39, '12-03-25', 'Đã giao hàng', 'Hà Nội', 890),
(43, '19-03-25', 'Đã hủy', 'Hồ Chí Minh', 940),
(42, '02-04-25', 'Đang giao hàng', 'Hà Nội', 1100),
(39, '09-04-25', 'Đang giao hàng', 'Hà Nội', 1050),
(43, '16-04-25', 'Đang giao hàng', 'Hồ Chí Minh', 1150);

-- Adding extra cancelled orders for better statistics
INSERT INTO `order` (`kh_id`, `order_date`, `order_trangthai`, `order_adress`, `order_totalprice`) VALUES
(42, '14-03-22', 'Đã hủy', 'Hà Nội', 480),
(39, '25-06-22', 'Đã hủy', 'Hà Nội', 550),
(43, '18-09-22', 'Đã hủy', 'Hồ Chí Minh', 470),
(42, '21-02-23', 'Đã hủy', 'Hà Nội', 330),
(39, '05-05-23', 'Đã hủy', 'Hà Nội', 450),
(43, '14-08-23', 'Đã hủy', 'Hồ Chí Minh', 620),
(42, '09-10-23', 'Đã hủy', 'Hà Nội', 780),
(39, '28-11-23', 'Đã hủy', 'Hà Nội', 840),
(43, '03-01-24', 'Đã hủy', 'Hồ Chí Minh', 750),
(42, '17-03-24', 'Đã hủy', 'Hà Nội', 870),
(39, '22-05-24', 'Đã hủy', 'Hà Nội', 600),
(43, '08-07-24', 'Đã hủy', 'Hồ Chí Minh', 680);

-- Now, create the corresponding order_chitiet records
-- We'll use a script to generate these after we know the order IDs generated above
-- For now, we'll prepare a placeholder for the next step

-- The following SET variable will be used to store the starting ID for new orders
SET @start_order_id = (SELECT MAX(order_id) FROM `order` WHERE order_id < 137);

-- Creating order_chitiet records for the orders we just inserted
-- Using commonly purchased products from the existing data

-- Function to select random products with appropriate quantities and calculate correct totals
-- This would typically be done with a stored procedure, but we'll use INSERT statements directly here

-- Order details for 2022 orders (12 orders, start_order_id + 1 to start_order_id + 12)
INSERT INTO `order_chitiet` (`order_id`, `pro_id`, `color_id`, `size_id`, `pro_price`, `soluong`, `total_price`) VALUES
(@start_order_id + 1, 66, 2, 1, 300, 1, 300),
(@start_order_id + 1, 63, 1, 1, 130, 1, 130),
(@start_order_id + 2, 65, 1, 2, 300, 2, 600),
(@start_order_id + 2, 54, 1, 1, 50, 1, 50),
(@start_order_id + 3, 66, 2, 1, 300, 1, 300),
(@start_order_id + 4, 61, 2, 3, 145, 2, 290),
(@start_order_id + 4, 49, 1, 1, 100, 2, 200),
(@start_order_id + 5, 63, 1, 1, 130, 2, 260),
(@start_order_id + 6, 66, 2, 1, 300, 1, 300),
(@start_order_id + 6, 58, 1, 1, 120, 1, 120),
(@start_order_id + 6, 54, 2, 1, 50, 1, 50),
(@start_order_id + 7, 65, 2, 1, 300, 1, 300),
(@start_order_id + 7, 55, 3, 3, 300, 1, 300),
(@start_order_id + 8, 64, 1, 1, 160, 1, 160),
(@start_order_id + 8, 62, 1, 2, 130, 1, 130),
(@start_order_id + 8, 53, 3, 3, 300, 1, 300),
(@start_order_id + 9, 63, 3, 3, 130, 2, 260),
(@start_order_id + 9, 58, 1, 2, 120, 1, 120),
(@start_order_id + 9, 54, 1, 1, 50, 1, 50),
(@start_order_id + 10, 66, 2, 1, 300, 1, 300),
(@start_order_id + 10, 60, 1, 2, 300, 1, 300),
(@start_order_id + 11, 63, 1, 1, 130, 2, 260),
(@start_order_id + 11, 58, 1, 1, 120, 1, 120),
(@start_order_id + 12, 65, 2, 1, 300, 2, 600),
(@start_order_id + 12, 58, 1, 1, 120, 1, 120);

-- Adding order details for additional cancelled orders
INSERT INTO `order_chitiet` (`order_id`, `pro_id`, `color_id`, `size_id`, `pro_price`, `soluong`, `total_price`) VALUES
(@start_order_id + 85, 66, 2, 1, 300, 1, 300),
(@start_order_id + 85, 63, 1, 1, 130, 1, 130),
(@start_order_id + 85, 54, 2, 1, 50, 1, 50),
(@start_order_id + 86, 65, 1, 2, 300, 1, 300),
(@start_order_id + 86, 63, 1, 1, 130, 2, 260),
(@start_order_id + 87, 66, 2, 1, 300, 1, 300),
(@start_order_id + 87, 58, 1, 1, 120, 1, 120),
(@start_order_id + 87, 54, 2, 1, 50, 1, 50),
(@start_order_id + 88, 66, 2, 1, 300, 1, 300),
(@start_order_id + 88, 54, 2, 1, 50, 1, 50),
(@start_order_id + 89, 65, 2, 1, 300, 1, 300),
(@start_order_id + 89, 58, 1, 1, 120, 1, 120),
(@start_order_id + 89, 54, 2, 1, 50, 1, 50),
(@start_order_id + 90, 66, 2, 1, 300, 2, 600),
(@start_order_id + 90, 54, 2, 1, 50, 1, 50),
(@start_order_id + 91, 65, 2, 1, 300, 2, 600),
(@start_order_id + 91, 63, 1, 1, 130, 1, 130),
(@start_order_id + 91, 54, 2, 1, 50, 1, 50),
(@start_order_id + 92, 66, 2, 1, 300, 2, 600),
(@start_order_id + 92, 63, 1, 1, 130, 2, 260),
(@start_order_id + 93, 66, 2, 1, 300, 2, 600),
(@start_order_id + 93, 58, 1, 1, 120, 1, 120),
(@start_order_id + 93, 54, 2, 1, 50, 1, 50),
(@start_order_id + 94, 65, 2, 1, 300, 2, 600),
(@start_order_id + 94, 63, 1, 1, 130, 2, 260),
(@start_order_id + 95, 66, 2, 1, 300, 1, 300),
(@start_order_id + 95, 63, 1, 1, 130, 2, 260),
(@start_order_id + 95, 49, 1, 1, 100, 1, 100),
(@start_order_id + 96, 65, 2, 1, 300, 2, 600),
(@start_order_id + 96, 58, 1, 1, 120, 1, 120);

-- Continue with the remaining original order_chitiet data
-- Order details for 2023 first half (18 orders, start_order_id + 13 to start_order_id + 30)
INSERT INTO `order_chitiet` (`order_id`, `pro_id`, `color_id`, `size_id`, `pro_price`, `soluong`, `total_price`) VALUES
(@start_order_id + 13, 63, 1, 1, 130, 1, 130),
(@start_order_id + 13, 58, 1, 1, 120, 1, 120),
(@start_order_id + 13, 54, 2, 1, 50, 1, 50),
(@start_order_id + 14, 65, 2, 1, 300, 1, 300),
(@start_order_id + 14, 49, 1, 1, 100, 1, 100),
(@start_order_id + 15, 63, 1, 1, 130, 1, 130),
(@start_order_id + 15, 58, 1, 1, 120, 1, 120),
(@start_order_id + 16, 66, 2, 1, 300, 1, 300),
(@start_order_id + 16, 61, 2, 3, 145, 1, 145),
(@start_order_id + 17, 65, 2, 1, 300, 1, 300),
(@start_order_id + 17, 58, 1, 1, 120, 1, 120),
(@start_order_id + 18, 63, 1, 1, 130, 1, 130),
(@start_order_id + 18, 54, 2, 1, 50, 1, 50),
(@start_order_id + 19, 66, 2, 1, 300, 1, 300),
(@start_order_id + 19, 58, 1, 1, 120, 1, 120),
(@start_order_id + 20, 63, 1, 1, 130, 1, 130),
(@start_order_id + 20, 58, 1, 1, 120, 1, 120),
(@start_order_id + 20, 54, 2, 1, 50, 1, 50),
(@start_order_id + 21, 66, 2, 1, 300, 1, 300),
(@start_order_id + 21, 58, 1, 1, 120, 1, 120),
(@start_order_id + 22, 65, 2, 1, 300, 1, 300),
(@start_order_id + 22, 54, 2, 1, 50, 1, 50),
(@start_order_id + 23, 63, 1, 1, 130, 1, 130),
(@start_order_id + 23, 58, 1, 1, 120, 1, 120),
(@start_order_id + 24, 66, 2, 1, 300, 1, 300),
(@start_order_id + 24, 58, 1, 1, 120, 1, 120),
(@start_order_id + 25, 63, 1, 1, 130, 1, 130),
(@start_order_id + 25, 61, 1, 2, 145, 1, 145),
(@start_order_id + 25, 54, 2, 1, 50, 1, 50),
(@start_order_id + 26, 66, 2, 1, 300, 1, 300),
(@start_order_id + 26, 58, 1, 1, 120, 1, 120),
(@start_order_id + 27, 65, 2, 1, 300, 1, 300),
(@start_order_id + 27, 54, 2, 1, 50, 1, 50),
(@start_order_id + 28, 63, 1, 1, 130, 1, 130),
(@start_order_id + 28, 65, 2, 1, 300, 1, 300),
(@start_order_id + 29, 66, 2, 1, 300, 1, 300),
(@start_order_id + 29, 49, 3, 3, 100, 1, 100),
(@start_order_id + 30, 63, 1, 1, 130, 1, 130),
(@start_order_id + 30, 65, 2, 1, 300, 1, 300); 
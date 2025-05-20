<?php
include '../app/model/connectdb.php';
include '../app/model/cate.php';
include '../app/model/product.php';
include '../app/model/khachhang.php';
include '../app/model/binhluan.php';
include '../app/model/size.php';
include '../app/model/color.php';
include '../app/model/thongke.php';
include '../app/model/donhang.php';
include '../app/model/nhacungcap.php';
include '../app/model/brand.php';
include '../app/model/phieunhap.php';
include '../app/model/bh.php';
include '../app/model/doitra.php';
include '../app/model/qlpq.php';
session_start();
ob_start();

// Kiểm tra đăng nhập và quyền truy cập
if (!isset($_SESSION['acount']) || !isset($_SESSION['acount']['vaitro_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập admin
    header("Location: admin_login.php");
    exit;
} else if ($_SESSION['acount']['vaitro_id'] == 2) {
    // Nếu là user thường, không cho phép truy cập
    header("Location: admin_login.php?error=unauthorized");
    exit;
}

$vaitro_id = $_SESSION['acount']['vaitro_id'];

// Lấy kết nối
$pdo = get_connect();
if ($pdo) {
    // Lấy quyền của người dùng
    $permissions = getUserPermissions($vaitro_id, $pdo);
} else {
    echo "Kết nối cơ sở dữ liệu không thành công.";
    exit;
}

// Hàm lấy quyền của người dùng
function getUserPermissions($role_id, $pdo)
{
    $query = "SELECT q.permission_name, q.trang_thai 
              FROM chi_tiet_nhom_quyen ct 
              JOIN quyen q ON ct.permission_id = q.permission_id 
              WHERE ct.role_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$role_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Kiểm tra quyền truy cập
function hasPermission($action, $permissions)
{
    foreach ($permissions as $permission) {
        if ($permission['permission_name'] === $action && $permission['trang_thai'] === 1) {
            return true;
        }
    }
    return false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="bg-white">
    <div class="grid-container">
        <?php
        if (isset($_GET['act'])) {
            $acts = $_GET['act'];
            switch ($acts) {
                case 'home':
                    # code...

                    echo '
      <!-- Header -->
      <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>
        <div class="header-left">
          <span class="material-icons-outlined">search</span>
        </div>
        <div class="header-right">
          <a href=""><span class="material-icons-outlined">account_circle</span></a>
        </div>
      </header>
      <!-- End Header -->';
                    break;

                default:
                    # code...
                    break;
            }
        }

        ?>

        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <span class="material-icons-outlined">inventory</span> Admin
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>

            <?php
            // Get current active page
            $current_act = isset($_GET['act']) ? $_GET['act'] : 'home';
            ?>

            <ul class="sidebar-list">
                <li class="sidebar-list-item <?php echo ($current_act == 'home') ? 'active' : ''; ?>">
                    <a href="indexadmin.php?act=home">
                        <span class="material-icons-outlined"><i class="bi bi-house-door-fill"></i></span> Trang chủ
                    </a>
                </li>

                <?php if (hasPermission('Quản lý danh mục', $permissions)) { ?>
                    <li class="sidebar-list-item <?php echo ($current_act == 'cate') ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=cate">
                            <span class="material-icons-outlined"><i class="bi bi-card-list"></i></span> Danh mục
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lí sản phẩm', $permissions)) { ?>
                    <li
                        class="sidebar-list-item <?php echo (in_array($current_act, ['pro', 'thempro', 'suapro', 'chitietadmin', 'thungrac_product'])) ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=pro">
                            <span class="material-icons-outlined">fact_check</span> Sản phẩm
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lí người dùng', $permissions)) { ?>
                    <li class="sidebar-list-item <?php echo ($current_act == 'listtk') ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=listtk">
                            <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Người dùng
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lí bình luận', $permissions)) { ?>
                    <li class="sidebar-list-item <?php echo ($current_act == 'listbl') ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=listbl">
                            <span class="material-icons-outlined"><i class="bi bi-chat-text-fill"></i></span> Bình luận
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lí thống kê', $permissions)) { ?>
                    <li
                        class="sidebar-list-item <?php echo (in_array($current_act, ['thongke', 'thongke_sanpham', 'thongke_doanhthu', 'thongke_donhang'])) ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=thongke_sanpham">
                            <span class="material-icons-outlined">poll</span> Thống kê đơn hàng
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lí đơn hàng', $permissions)) { ?>
                    <li
                        class="sidebar-list-item <?php echo (in_array($current_act, ['donhang', 'chitietdh', 'suadonhang', 'in_hoadon'])) ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=donhang">
                            <span class="material-icons-outlined"><i class="bi bi-cart-check-fill"></i></span> Danh sách đơn
                            hàng
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lí nhà cung cấp', $permissions)) { ?>
                    <li
                        class="sidebar-list-item <?php echo (in_array($current_act, ['ncc', 'themNCC', 'suaNCC'])) ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=ncc">
                            <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Nhà cung
                            cấp
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lí màu', $permissions)) { ?>
                    <li
                        class="sidebar-list-item <?php echo (in_array($current_act, ['color', 'addcolor', 'updatecolor'])) ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=color">
                            <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Quản lý màu
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lý thương hiệu', $permissions)) { ?>
                    <li
                        class="sidebar-list-item <?php echo (in_array($current_act, ['thuonghieu', 'addbrand', 'suabrand'])) ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=thuonghieu">
                            <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Quản lý
                            thương hiệu
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lý phiếu nhập', $permissions)) { ?>
                    <li
                        class="sidebar-list-item <?php echo (in_array($current_act, ['phieunhap', 'addphieunhap', 'suaphieunhap'])) ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=phieunhap">
                            <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Quản lý
                            phiếu nhập
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lý thống kê nhập kho', $permissions)) { ?>
                    <li
                        class="sidebar-list-item <?php echo (in_array($current_act, ['thongke_nhapkho'])) ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=thongke_nhapkho">
                            <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Quản lý
                            thống kê nhập kho
                        </a>
                    </li>
                <?php } ?>


                <?php if (hasPermission('Quản lý phiếu bảo hành', $permissions)) { ?>
                    <li
                        class="sidebar-list-item <?php echo (in_array($current_act, ['bh', 'addbh1', 'addbh'])) ? 'active' : ''; ?>">
                        <a href="indexadmin.php?act=bh">
                            <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Quản lý
                            phiếu bảo hành
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lý phiếu đổi/trả', $permissions)) { ?>
                    <li class="sidebar-list-item">
                        <a href="indexadmin.php?act=doitra">
                            <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Quản lý
                            phiếu đổi/trả
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lý phân quyền', $permissions)) { ?>
                    <li class="sidebar-list-item">
                        <a href="indexadmin.php?act=pq">
                            <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Quản lý
                            phân quyền
                        </a>
                    </li>
                <?php } ?>

                <?php if (hasPermission('Quản lý vai trò', $permissions)) { ?>
                    <li class="sidebar-list-item">
                        <a href="indexadmin.php?act=vaitro">
                            <span class="material-icons-outlined"><i class="bi bi-person-vcard-fill"></i></span> Quản lý vai
                            trò
                        </a>
                    </li>
                <?php } ?>
                <li class="sidebar-list-item">
                    <a href="logout_admin.php" class="text-danger">
                        <span class="material-icons-outlined"><i class="bi bi-box-arrow-right"></i></span> Đăng xuất
                    </a>
                </li>
            </ul>
        </aside>

        <!-- End Sidebar -->
        <?php
        if (isset($_GET['act'])) {
            $act = $_GET['act'];
            switch ($act) {
                case 'xoavt':
                    if (isset($_GET['vaitro_id'])) {
                        $vaitro_id = $_GET['vaitro_id'];


                        deletevaitro($vaitro_id);
                    }
                    $listvt = getallvt();
                    include './qlvaitro/vaitro.php';
                    break;
                case 'addvt':
                    if (isset($_POST['addvt'])) {
                        $vaitro_name = $_POST['vaitro_name'];

                        insert_vaitro($vaitro_name);
                    }
                    $listvt = getallvt();
                    include './qlvaitro/vaitro.php';
                    break;
                case 'addvt1':
                    include './qlvaitro/addvt.php';
                    break;
                case 'vaitro':
                    $listvt = getallvt();

                    include './qlvaitro/vaitro.php';
                    break;
                case 'pq':
                    $listpq = query_allpq();
                    include './qlphanquyen/qlpq.php';
                    break;
                case 'xoapq':
                    if (isset($_GET['role_id']) && isset($_GET['permission_id'])) {
                        $role_id = $_GET['role_id'];
                        $per_id = $_GET['permission_id'];
                        delete_permission_of_role($role_id, $per_id);
                    }
                    $listpq = query_allpq();
                    include './qlphanquyen/qlpq.php';
                    break;
                case 'addpq1':
                    include './qlphanquyen/addpq.php';
                    break;

                case 'addpq':
                    if (isset($_POST['addpq'])) {

                        $role_id = $_POST['vaitro_id'];  // Sử dụng đúng tên input
                        $permission_id = $_POST['permission_id'];
                        $hanh_dong = $_POST['hanh_dong'] ?? null;

                        if ($hanh_dong === '') {
                            $hanh_dong = null;
                        }
                        // Kiểm tra quyền đã tồn tại chưa
                        if (check_permission_exist($role_id, $permission_id)) {
                            $thongbao = "❌ Quyền này đã tồn tại trong vai trò được chọn.";
                        } else {
                            insert_permission_to_role($role_id, $permission_id, $hanh_dong);
                            $thongbao = "✅ Thêm quyền thành công.";
                        }
                        // insert_permission_to_role($role_id, $permission_id, $hanh_dong);
                    }
                    $listpq = query_allpq();
                    include './qlphanquyen/qlpq.php';
                    break;

                case 'doitra':
                    $listdoitra = getallpd();
                    include './phieudoitra/doitra.php';
                    break;
                case 'bh':
                    $listbh = getall();
                    include './phieubh/bh.php';
                    break;
                case 'phieunhap':
                    $listreceipts = query_allreceipts();
                    include './phieunhap/phieunhap.php';
                    break;
                case 'thuonghieu':
                    $listbrand = query_allbrand();
                    include './qlthuonghieu/thuonghieu.php';
                    break;
                case 'color':
                    $listcolor = query_allcolor1();
                    include './qlmau/color.php';
                    break;
                case "ncc":
                    // Lấy các tham số sắp xếp từ form
                    $sapXep = isset($_POST['sapXepNCC']) ? $_POST['sapXepNCC'] : 'id';
                    $thuTu = isset($_POST['thuTu']) ? $_POST['thuTu'] : 'asc';
                    $keyword = isset($_POST['searchNCC']) ? $_POST['searchNCC'] : '';

                    // Gọi hàm loadall_ncc với tham số sắp xếp
                    $listNCC = loadall_ncc($keyword, $sapXep, $thuTu);

                    // Include file listNCC.php để hiển thị danh sách
                    include "nhacungcap/listNCC.php";
                    break;

                case 'suaNCC':
                    if (isset($_GET['ncc_id']) && $_GET['ncc_id'] > 0) {
                        $ncc_id = $_GET['ncc_id'];
                        $listNCC = load_ncc($ncc_id);
                    }
                    include './nhacungcap/updateNCC.php';
                    break;
                case 'updateNCC':
                    if (isset($_POST['update'])) {
                        $ncc_id = $_POST['ncc_id'];
                        $ncc_name = $_POST['ncc_name'];
                        $ncc_email = $_POST['ncc_email'];
                        $ncc_sdt = $_POST['ncc_tel'];
                        $ncc_diachi = $_POST['ncc_address'];

                        update_NCC($ncc_id, $ncc_name, $ncc_email, $ncc_sdt, $ncc_diachi);
                    }
                    $listNCC = loadAllNcc();
                    include './nhacungcap/listNCC.php';
                    break;

                case 'xoaNCC':
                    if (isset($_GET['ncc_id'])) {
                        $ncc_id = $_GET['ncc_id'];
                        delete_ncc($ncc_id);
                    }
                    $listNCC = loadAllNcc();
                    include "./nhacungcap/listNCC.php";
                    break;
                    break;
                case 'home':
                    $dh = thongke_donhang();
                    $top5 = loadall_sanpham_top5();
                    $kh = countkh();
                    $bl = countbl();
                    $donhang = countOrderIds();
                    $pro = countProId();
                    include './viewadmin/home.php';
                    break;
                case 'cate':
                    $resultcate = query_allcate();
                    include './cate/listcate.php';
                    break;

                case "thungrac_cate":
                    $resultcate = query_allcates();
                    include './cate/thungrac.php';
                    break;

                case 'addcate':

                    include './cate/addcate.php';
                    break;
                case 'themcate':
                    if (isset($_POST['themdm'])) {
                        $cate_name = $_POST['cate_name'];
                        addcate($cate_name);
                    }

                    $resultcate = query_allcate();
                    include './cate/listcate.php';

                    break;
                case 'suacate':
                    if (isset($_GET['cate_idsua'])) {
                        $cate_id = $_GET['cate_idsua'];
                        $cate_one = query_onecate($cate_id);

                        include './cate/updatecate.php';
                    }
                    break;

                case 'updatecate':
                    if (isset($_POST['suadm'])) {
                        $cate_name = $_POST['cate_name'];
                        $cate_id = $_POST['cate_id'];
                        updatecate($cate_name, $cate_id);
                    }

                    $resultcate = query_allcate();
                    include './cate/listcate.php';

                    break;

                case 'delcate':
                    if (isset($_GET['cate_idxoa'])) {
                        $cate_id = $_GET['cate_idxoa'];


                        deletecate($cate_id);
                    }
                    $resultcate = query_allcate();
                    include './cate/listcate.php';
                    break;
                case 'soft_delcate':
                    if (isset($_GET['cate_idxoa'])) {
                        $cate_id = $_GET['cate_idxoa'];


                        soft_deletecate($cate_id);
                    }
                    $resultcate = query_allcate();
                    include './cate/listcate.php';
                    break;
                case 'khoiphuc_cate':
                    if (isset($_GET['cate_idxoa'])) {
                        $cate_id = $_GET['cate_idxoa'];


                        khoiphuc_cate($cate_id);
                    }
                    $resultcate = query_allcates();
                    include './cate/thungrac.php';
                    break;
                case 'pro':
                    // Lấy các tham số sắp xếp từ form
                    $sort_by = isset($_POST['sapXepPro']) ? $_POST['sapXepPro'] : 'id';
                    $sort_order = isset($_POST['thuTu']) ? $_POST['thuTu'] : 'asc';
                    $key = isset($_POST['search_name']) ? $_POST['search_name'] : '';

                    // Phân trang
                    $items_per_page = 7; // 7 sản phẩm mỗi trang
                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $current_page = max(1, $current_page); // Đảm bảo trang hiện tại ít nhất là 1
                    $offset = ($current_page - 1) * $items_per_page;

                    // Gọi hàm queryallpro_with_sorting với tham số sắp xếp
                    $result_pro = queryallpro_with_sorting($key, 0, $sort_by, $sort_order, $offset, $items_per_page);
                    $total_products = count_products($key, 0);
                    $total_pages = ceil($total_products / $items_per_page);

                    include './sanpham/listproduct.php';
                    break;
                case 'thungrac_product':
                    $result_pro = queryallpros();
                    include './sanpham/thungrac.php';
                    break;
                case 'thempro':

                    include './sanpham/addpro.php';
                    break;
                case 'addbh1':

                    include './phieubh/addbh.php';
                    break;
                case 'addbh':
                    if (isset($_POST['addbh'])) {
                        $pro_id = $_POST['pro_id'];
                        $kh_id = $_POST['kh_id'];
                        $nhan_vien_id = $_SESSION['acount']['kh_id'] ?? 0;
                        $ngay_bao_hanh = date('Y-m-d');
                        $noi_dung = $_POST['noidung'];
                        $thoi_gian_bao_hanh = (int) $_POST['thoigian'];

                        insert_baohanh($pro_id, $kh_id, $nhan_vien_id, $ngay_bao_hanh, $noi_dung, $thoi_gian_bao_hanh);
                    }

                    $listbh = getall();
                    include './phieubh/bh.php';
                    break;
                case 'xoabh':
                    if (isset($_GET['id'])) {
                        $bh_id = $_GET['id'];
                        delete_baohanh($bh_id);
                    }
                    $listbh = getall();
                    include './phieubh/bh.php';
                    break;
                case 'adddt1':

                    include './phieudoitra/adddt.php';
                    break;
                case 'adddt':

                    if (isset($_POST['adddt'])) {

                        $order_id = $_POST['order_id'] ?? null;
                        $pro_id = $_POST['pro_id'] ?? null;
                        $pro_moi_id = $_POST['pro_moi_id'] ?? null;
                        $color_id = $_POST['color_id'] ?? null;
                        $size_id = $_POST['size_id'] ?? null;
                        $kh_id = $_POST['kh_id'] ?? null;
                        $ngay_doi = date('Y-m-d');
                        $ly_do = $_POST['lydo'] ?? '';
                        $trang_thai = $_POST['trangthai'] ?? '';
                        if ($pro_moi_id === '') {
                            $pro_moi_id = null;
                        }
                        if ($color_id === '') {
                            $color_id = null;
                        }
                        if ($size_id === '') {
                            $size_id = null;
                        }


                        insert_phieu_doi_tra($order_id, $pro_id, $pro_moi_id, $color_id, $size_id, $kh_id, $ngay_doi, $ly_do, $trang_thai);
                    }
                    $listdoitra = getallpd();
                    include './phieudoitra/doitra.php';
                    break;
                case 'xoadt':
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        delete_phieu_doi_tra($id);
                    }
                    $listdoitra = getallpd();
                    include './phieudoitra/doitra.php';
                    break;

                case 'addpn1':

                    include './phieunhap/addpn.php';
                    break;
                case 'addpn':
                    if (isset($_POST['addpn'])) {
                        // Thông tin nhà cung cấp từ select box
                        $ncc_id = $_POST['ncc_id'];

                        // Thông tin phiếu nhập
                        $receipt_date = date('Y-m-d'); // Only store the date without time
                        $created_by = $_SESSION['acount']['kh_id'] ?? 0;
                        $status = 0; // Trạng thái mặc định là nháp
                        $note = $_POST['note'] ?? '';

                        // Thêm phiếu nhập và lấy ID mới nhất
                        $last_receipt_id = insert_receipt_return_id($ncc_id, $receipt_date, $created_by, $status, $note);

                        if ($last_receipt_id > 0) {
                            // Chuyển hướng đến trang thêm sản phẩm vào phiếu nhập
                            header("Location: indexadmin.php?act=themsp_phieunhap&id=" . $last_receipt_id);
                            exit;
                        } else {
                            echo "<script>alert('❌ Không thể tạo phiếu nhập. Vui lòng thử lại!');</script>";
                            include './phieunhap/addpn.php';
                            break;
                        }
                    }

                    $listreceipts = query_allreceipts();
                    include './phieunhap/phieunhap.php';
                    break;
                case 'xoapn':
                    if (isset($_GET['id'])) {
                        $pn_id = $_GET['id'];
                        delete_receipt_completely($pn_id);
                    }
                    $listreceipts = query_allreceipts();
                    include './phieunhap/phieunhap.php';
                    break;
                case 'chitietpn':
                    if (isset($_GET['id'])) {
                        $receipt_id = $_GET['id'];
                        $receipt_details = get_receipt_details($receipt_id);
                        include './phieunhap/chitietpn.php';
                    } else {
                        header("Location: indexadmin.php?act=phieunhap");
                        exit;
                    }
                    break;
                case 'in_phieunhap':
                    if (isset($_GET['id'])) {
                        $receipt_id = $_GET['id'];
                        $receipt_details = get_receipt_details($receipt_id);

                        // Kiểm tra xem có dữ liệu phiếu nhập không
                        if (!empty($receipt_details['receipt'])) {
                            include "./phieunhap/in_phieunhap.php";
                        } else {
                            echo "Không tìm thấy phiếu nhập!";
                        }
                    } else {
                        echo "Không tìm thấy mã phiếu nhập!";
                    }
                    break;
                case 'suapn':
                    if (isset($_GET['id'])) {
                        $receipt_id = $_GET['id'];
                        $receipt_details = get_receipt_details($receipt_id);
                        include './phieunhap/suapn.php';
                    } else {
                        header("Location: indexadmin.php?act=phieunhap");
                        exit;
                    }
                    break;
                case 'updatepn':
                    if (isset($_POST['update_status'])) {
                        $receipt_id = $_POST['receipt_id'];
                        $status = $_POST['status'];
                        $note = $_POST['note'];
                        // Gọi hàm cập nhật trạng thái phiếu nhập
                        $result = update_receipt_status($receipt_id, $status, $note);
                        if ($result) {
                            // Thông báo thành công
                            echo "<script>alert('Cập nhật trạng thái phiếu nhập thành công!');</script>";
                        } else {
                            // Thông báo lỗi
                            echo "<script>alert('Lỗi cập nhật trạng thái phiếu nhập!');</script>";
                        }
                    }
                    // Chuyển hướng về trang danh sách phiếu nhập thay vì chi tiết
                    header("Location: indexadmin.php?act=phieunhap");
                    exit;
                    break;
                case 'addpnchitiet':
                    // Vô hiệu hóa chức năng thêm chi tiết phiếu nhập sau khi đã tạo
                    $_SESSION['error'] = "Không thể thêm chi tiết phiếu nhập sau khi đã tạo để đảm bảo tính toàn vẹn dữ liệu kế toán.";
                    if (isset($_POST['receipt_id'])) {
                        header("Location: indexadmin.php?act=suapn&id=" . $_POST['receipt_id']);
                    } else {
                        header("Location: indexadmin.php?act=phieunhap");
                    }
                    exit;
                    break;
                case 'themsp_phieunhap':
                    if (isset($_GET['id'])) {
                        $receipt_id = $_GET['id'];
                        $receipt_details = get_receipt_details($receipt_id);

                        // Lấy danh sách sản phẩm, màu sắc, kích cỡ để hiển thị trong form
                        $list_products = queryallpro('', 0);
                        $list_colors = query_allcolor1();
                        $list_sizes = query_allsize();

                        include './phieunhap/themsp_phieunhap.php';
                    } else {
                        header("Location: indexadmin.php?act=phieunhap");
                        exit;
                    }
                    break;

                case 'add_product_to_receipt':
                    if (isset($_POST['add_product'])) {
                        $receipt_id = $_POST['receipt_id'];
                        $pro_id = $_POST['pro_id'];
                        $color_id = $_POST['color_id'];
                        $size_id = $_POST['size_id'];
                        $quantity = $_POST['quantity'];
                        $unit_price = $_POST['unit_price'];
                        $total_price = $quantity * $unit_price;

                        // Thêm chi tiết phiếu nhập
                        $result = insert_receipt_detail($receipt_id, $pro_id, $color_id, $size_id, $quantity, $unit_price, $total_price);

                        if ($result) {
                            echo "<script>alert('Thêm sản phẩm vào phiếu nhập thành công!');</script>";
                        } else {
                            echo "<script>alert('Lỗi khi thêm sản phẩm vào phiếu nhập!');</script>";
                        }

                        // Quay lại trang thêm sản phẩm
                        header("Location: indexadmin.php?act=themsp_phieunhap&id=" . $receipt_id);
                        exit;
                    }
                    break;

                case 'complete_receipt':
                    if (isset($_POST['receipt_id'])) {
                        $receipt_id = $_POST['receipt_id'];

                        // Chuyển hướng đến trang danh sách phiếu nhập
                        header("Location: indexadmin.php?act=phieunhap");
                        exit;
                    }
                    break;

                case 'xoapnchitiet':
                    // Vô hiệu hóa chức năng xóa chi tiết phiếu nhập
                    $_SESSION['error'] = "Không thể xóa chi tiết phiếu nhập để đảm bảo tính toàn vẹn dữ liệu kế toán.";
                    if (isset($_GET['receipt_id'])) {
                        header("Location: indexadmin.php?act=suapn&id=" . $_GET['receipt_id']);
                    } else {
                        header("Location: indexadmin.php?act=phieunhap");
                    }
                    exit;
                    break;
                case 'addcolor1':

                    include './qlmau/addcolor.php';
                    break;
                case 'addbrand1':

                    include './qlthuonghieu/addbrand.php';
                    break;
                case 'addbrand':
                    if (isset($_POST['addbrand'])) {
                        $brand_name = $_POST['brand_name'];
                        $mo_ta = $_POST['mo_ta'];
                        insert_brand($brand_name, $mo_ta);
                    }
                    $listbrand = query_allbrand();
                    include './qlthuonghieu/thuonghieu.php';
                    break;
                case 'xoabrand':
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        deletebrand($id);
                    }
                    $listbrand = query_allbrand();
                    include './qlthuonghieu/thuonghieu.php';
                    break;
                case 'suabrand':
                    if (isset($_GET['brand_idsua'])) {
                        $brand_id = $_GET['brand_idsua'];
                        $brand_one =   queryonebrand($brand_id);
                    }
                    include './qlthuonghieu/updatebrand.php';
                    break;
                case 'updatebrand':
                    if (isset($_POST['updatebrd'])) {
                        $id = $_POST['id'];
                        $brand_one =   queryonebrand($id);
                        $brand_name = $_POST['ten_thuong_hieu'];
                        $mo_ta = $_POST['mo_ta'];
                        updatebrd($brand_name, $mo_ta, $id);
                    }

                    $listbrand = query_allbrand();
                    include './qlthuonghieu/thuonghieu.php';
                    break;
                case 'addcolor':
                    if (isset($_POST['addcolor'])) {
                        $color_name = $_POST['color_name'];
                        $color_ma = $_POST['color_ma'];
                        insert_color($color_name, $color_ma);
                    }
                    $listcolor = query_allcolor1();
                    include './qlmau/color.php';
                    break;
                case 'xoacolor':
                    if (isset($_GET['color_id'])) {
                        $color_id = $_GET['color_id'];


                        deletecolor($color_id);
                    }
                    $listcolor = query_allcolor1();
                    include './qlmau/color.php';
                    break;
                case 'addpro':
                    if (isset($_POST['addsp'])) {
                        $pro_name = $_POST['pro_name'];
                        $cate_id = $_POST['cate_id'];
                        $pro_price = $_POST['pro_price'];
                        $pro_brand = $_POST['pro_brand'];
                        $pro_mota = $_POST['pro_mota'];

                        // Handle image upload
                        $img_name = '';
                        if ($_FILES['pro_img']['error'] == 0) {
                            $img_name = $_FILES['pro_img']['name'];
                            $img_tmp = $_FILES['pro_img']['tmp_name'];
                            $upload_result = move_uploaded_file($img_tmp, "./sanpham/img/" . $img_name);

                            if (!$upload_result) {
                                echo "<script>alert('Lỗi khi tải hình ảnh lên!');</script>";
                                include './sanpham/addpro.php';
                                break;
                            }
                        } else {
                            echo "<script>alert('Vui lòng chọn hình ảnh cho sản phẩm!');</script>";
                            include './sanpham/addpro.php';
                            break;
                        }

                        // Validate product price
                        if (!is_numeric($pro_price) || $pro_price <= 0) {
                            echo "<script>alert('Giá sản phẩm không hợp lệ!');</script>";
                            include './sanpham/addpro.php';
                            break;
                        }

                        // Add the product and get back the new product ID
                        $new_product_id = addpro($pro_name, $img_name, $pro_price, $pro_mota, $cate_id, 0, $pro_brand);

                        if ($new_product_id > 0) {
                            echo "<script>alert('Thêm sản phẩm thành công!');</script>";
                            $result_pro = queryallpro('', 0);
                            include './sanpham/listproduct.php';
                        } else {
                            // If product addition failed, show an error and stay on the add form
                            echo "<script>alert('Có lỗi xảy ra khi thêm sản phẩm! Vui lòng kiểm tra lại thông tin.');</script>";
                            include './sanpham/addpro.php';
                        }
                        break;
                    }

                    // If not submitting the form, show the add form
                    include './sanpham/addpro.php';
                    break;
                case 'suapro':
                    if (isset($_GET['pro_idsua'])) {
                        $pro_id = $_GET['pro_idsua'];
                        $pro_one =   queryonepro($pro_id);
                    }
                    include './sanpham/updatepro.php';
                    break;
                case 'updatepro':
                    if (isset($_POST['updatesp'])) {
                        $pro_id = $_POST['pro_id'];
                        $pro_one =   queryonepro($pro_id);
                        $pro_brand = $_POST['pro_brand'];
                        $pro_name = $_POST['pro_name'];
                        $cate_id = $_POST['cate_id'];
                        $pro_price = $_POST['pro_price'];

                        $pro_mota = $_POST['pro_mota'];
                        if ($_FILES['pro_img']['name'] == null) {
                            $img_name = $pro_one['pro_img'];
                        } else {
                            $img_name = $_FILES['pro_img']['name'];
                        }
                        $img_tmp = $_FILES['pro_img']['tmp_name'];
                        move_uploaded_file($img_tmp, "./sanpham/img/" . $img_name);
                        updatepro($pro_name, $pro_price, $pro_brand, $img_name, $pro_mota, $cate_id, $pro_id);
                    }

                    $result_pro = queryallpro('', 0);
                    include './sanpham/listproduct.php';
                    break;
                case 'delpro':
                    if (isset($_GET['pro_idxoa'])) {
                        $pro_id = $_GET['pro_idxoa'];

                        if (kiemtra_sp_dangtrongdonhang($pro_id)) {
                            echo "<script>alert('Sản phẩm đang có trong đơn hàng chưa hoàn tất. Vui lòng thực hiện xóa mềm thay vì xóa cứng!');</script>";
                        } else if (kiemtra_sp_trongphieunhap($pro_id)) {
                            echo "<script>alert('Sản phẩm đang có trong phiếu nhập. Không thể xóa cứng sản phẩm này!');</script>";
                        } else {
                            deletepro($pro_id);
                            echo "<script>alert('Xóa cứng sản phẩm thành công.');</script>";
                        }
                    }
                    $result_pro = queryallpros();
                    include './sanpham/thungrac.php';
                    break;
                case "soft_delpro":
                    if (isset($_GET['pro_idxoa'])) {
                        $pro_id = $_GET['pro_idxoa'];


                        soft_deletepro($pro_id);
                    }
                    $result_pro = queryallpro('', 0);
                    include './sanpham/listproduct.php';
                    break;
                case "khoiphuc_product":
                    if (isset($_GET['pro_idxoa'])) {
                        $pro_id = $_GET['pro_idxoa'];


                        khoiphuc_product($pro_id);
                    }
                    $result_pro = queryallpros();
                    include './sanpham/thungrac.php';
                    break;
                case 'search':
                    // Lấy các tham số sắp xếp từ form
                    $sort_by = isset($_POST['sapXepPro']) ? $_POST['sapXepPro'] : 'id';
                    $sort_order = isset($_POST['thuTu']) ? $_POST['thuTu'] : 'asc';
                    $key = isset($_POST['search_name']) ? $_POST['search_name'] : '';

                    // Phân trang
                    $items_per_page = 7; // 7 sản phẩm mỗi trang
                    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $current_page = max(1, $current_page); // Đảm bảo trang hiện tại ít nhất là 1
                    $offset = ($current_page - 1) * $items_per_page;

                    // Gọi hàm queryallpro_with_sorting với tham số sắp xếp
                    $result_pro = queryallpro_with_sorting($key, 0, $sort_by, $sort_order, $offset, $items_per_page);
                    $total_products = count_products($key, 0);
                    $total_pages = ceil($total_products / $items_per_page);

                    include './sanpham/listproduct.php';
                    break;
                // bình luận 
                case "listbl":
                    $listbl = load_binhluan();
                    include "binhluan/list_bl.php";
                    break;
                case "xoabl":
                    if (isset($_GET['cmt_id'])) {
                        $cmt_id = $_GET['cmt_id'];
                        delete_binhluan($cmt_id);
                    }
                    $listbl = load_binhluan();
                    include "binhluan/list_bl.php";
                    break;
                // khách hàng
                case "listtk":
                    $listtk = loadall_taikhoan();
                    include "taikhoan/list_kh.php";
                    break;
                case "thungrac_kh":
                    $listtk = loadall_taikhoans();
                    include "taikhoan/thungrac.php";
                    break;
                case "xoatk":
                    if (isset($_GET['kh_id']) && $_GET['kh_id'] > 0) {
                        $kh_id  = $_GET['kh_id'];
                        delete_taikhoan($kh_id);
                    }

                    $listtk = loadall_taikhoan();
                    include "taikhoan/list_kh.php";
                    break;
                case "soft_xoatk":
                    if (isset($_GET['kh_id']) && $_GET['kh_id'] > 0) {
                        $kh_id  = $_GET['kh_id'];
                        soft_deletekh($kh_id);
                        $message = "Đã khóa tài khoản thành công.";
                    }

                    $listtk = loadall_taikhoan();
                    include "taikhoan/list_kh.php";
                    break;
                case "mokhoatk":
                    if (isset($_GET['kh_id']) && $_GET['kh_id'] > 0) {
                        $kh_id  = $_GET['kh_id'];
                        openkh($kh_id);
                        $message = "Đã mở khóa tài khoản thành công.";
                    }

                    $listtk = loadall_taikhoan();
                    include "taikhoan/list_kh.php";
                    break;
                case "khoiphuc_kh":
                    if (isset($_GET['kh_id']) && $_GET['kh_id'] > 0) {
                        $kh_id  = $_GET['kh_id'];
                        khoiphuc_kh($kh_id);
                    }

                    $listtk = loadall_taikhoans();
                    include "taikhoan/thungrac.php";
                    break;
                case "suatk":
                    if (isset($_GET['kh_id']) && $_GET['kh_id'] > 0) {
                        $kh_id = $_GET['kh_id'];
                        $tk = loadone_taikhoan($kh_id);
                    }
                    include "taikhoan/updatetk.php";
                    break;
                case "updatetk":
                    if (isset($_POST['update'])) {
                        $kh_id  = $_POST['kh_id'];
                        $kh_name = $_POST['kh_name'];
                        $kh_pass = $_POST['kh_pass'];
                        $kh_mail = $_POST['kh_mail'];
                        $kh_tel = $_POST['kh_tel'];
                        $kh_address = $_POST['kh_address'];
                        $vaitro_id = $_POST['vaitro_id'];

                        update_taikhoan($kh_id, $kh_name, $kh_pass, $kh_mail, $kh_tel, $kh_address, $vaitro_id);
                    }

                    $listtk = loadall_taikhoan();
                    include "taikhoan/list_kh.php";
                    break;

                case 'chitietadmin':
                    include 'sanpham/chitietproadmin.php';

                    break;
                case 'thempro_chitiet':
                    include 'sanpham/addprochitiet.php';

                    break;
                case 'addpro_ct':
                    if (isset($_POST['addsp_ct'])) {
                        $pro_id = $_POST['pro_id'];
                        $color = $_POST['color_id'];
                        $size = $_POST['size_id'];
                        $soluong = $_POST['soluong'];
                    }
                    addpro_chitiet($pro_id, $size, $color, $soluong);



                    header("Location:indexadmin.php?act=chitietadmin&pro_id=" . $pro_id);
                    exit();
                    break;
                case 'delprochitiet':
                    if (isset($_GET['prochitiet_idxoa']) && isset($_GET['pro_id'])) {
                        $id_pro_ct = $_GET['prochitiet_idxoa'];
                        $pro_id = $_GET['pro_id'];
                        del_prochitiet($id_pro_ct);
                        header("Location:indexadmin.php?act=chitietadmin&pro_id=" . $pro_id);
                    }
                    // include 'sanpham/chitietproadmin.php';
                    break;

                case 'suaprochitiet':
                    include 'sanpham/updateprochitiet.php';







                    break;
                case 'upchitietpro':
                    if (isset($_POST['update_chitietpro'])) {
                        $soluong  = $_POST['soluong'];
                        $pro_chitiet_id = $_POST['id'];
                        $pro_id = $_POST['id_pro'];
                        updateprochitiet($pro_chitiet_id, $soluong);
                    }
                    header("location:indexadmin.php?act=chitietadmin&pro_id=" . $pro_id);
                    break;

                case 'donhang':

                    $kyw = "";
                    $start_date = "";
                    $end_date = "";

                    // Kiểm tra nếu có tìm kiếm
                    if (isset($_POST['timkiem'])) {
                        // echo "Start date: " . $_POST['start_date'] . "<br>";
                        // echo "End date: " . $_POST['end_date'] . "<br>";

                        if (!empty($_POST['kyw'])) {
                            $kyw = $_POST['kyw'];
                        }
                        if (!empty($_POST['start_date'])) {
                            $start_date = $_POST['start_date'];
                        }
                        if (!empty($_POST['end_date'])) {
                            $end_date = $_POST['end_date'];
                        }
                        if (!empty($end_date) && empty($start_date)) {
                            $start_date = "1970-01-01";
                        }

                        if (!empty($start_date) && empty($end_date)) {
                            $end_date = date("Y-m-d");
                        }
                    }

                    // Gọi hàm tìm kiếm với các điều kiện
                    $listdh = loadall_donhang($kyw, $start_date, $end_date);
                    include "./donhang/listdh.php";
                    break;
                case "xoadonhang":
                    if (isset($_GET['order_id'])) {
                        $order_id = $_GET['order_id'];
                        delete_donhang($order_id);
                    }
                    $listdh = loadall_donhang();
                    include "./donhang/listdh.php";
                    break;
                case "suadonhang":
                    if (isset($_GET['order_id']) && $_GET['order_id'] != "") {
                        $order_id = $_GET['order_id'];
                        $dh = loadall_one_donhang($order_id);
                    }
                    include "./donhang/update.php";
                    break;
                case "updatedonhang":
                    if (isset($_POST['themdh'])) {
                        $order_id = $_POST['order_id'];
                        $order_trangthai_moi = $_POST['order_trangthai'];
                        // Lấy trạng thái hiện tại từ DB
                        $donhang = loadone_donhang($order_id);
                        $order_trangthai_cu = $donhang['order_trangthai'];

                        // Định nghĩa thứ tự
                        $trangthai_chuyendoi = [
                            "Đang chờ xác nhận" => ["Đang giao hàng", "Đã nhận hàng", "Đã hủy"],
                            "Đang giao hàng" => ["Đã nhận hàng", "Đã hủy"],
                            "Đã nhận hàng" => [],
                            "Đã hủy" => []
                        ];

                        if (in_array($order_trangthai_moi, $trangthai_chuyendoi[$order_trangthai_cu])) {
                            updatedh($order_trangthai_moi, $order_id);
                            $message = "Cập nhật trạng thái đơn hàng thành công!";
                        } else {
                            $message = "Không thể cập nhật trạng thái đơn hàng từ '{$order_trangthai_cu}' sang '{$order_trangthai_moi}'!";
                        }
                    }

                    $listdh = loadall_donhang();
                    include "./donhang/listdh.php";
                    break;
                case "chitietdh":
                    if (isset($_GET['order_id']) && $_GET['order_id'] != "") {
                        $order_id = $_GET['order_id'];
                    }
                    $chitietdh = loadall_chitietdh($order_id);
                    include "./donhang/chitetdh.php";
                    break;
                // thống kê (điểm vào mặc định chuyển đến thống kê sản phẩm)
                case 'thongke':
                    header("Location: indexadmin.php?act=thongke_sanpham");
                    exit;
                    break;

                // thống kê sản phẩm bán chạy
                case 'thongke_sanpham':
                    // Xác định số lượng sản phẩm muốn hiển thị (mặc định là 10)
                    $top_limit = isset($_POST['top_limit']) ? (int)$_POST['top_limit'] : 10;

                    // Giới hạn giá trị hợp lệ
                    if ($top_limit < 1) $top_limit = 1;
                    if ($top_limit > 100) $top_limit = 100;

                    // Lấy dữ liệu thống kê sản phẩm bán chạy
                    $sp_banchay = thongke_sanpham_banchay($top_limit);
                    include "./Thongke/thongke_sanpham.php";
                    break;

                // thống kê doanh thu
                case 'thongke_doanhthu':
                    // Xác định kiểu thống kê (mặc định là tháng)
                    $kieu_thongke = isset($_POST['kieu_thongke']) ? $_POST['kieu_thongke'] : 'thang';

                    // Thiết lập các biến hiển thị tương ứng với kiểu thống kê
                    switch ($kieu_thongke) {
                        case 'thang':
                            $kieu_thongke_text = 'tháng';
                            $label_thoi_gian = 'Tháng';
                            $label_prefix = 'Tháng ';
                            break;
                        case 'quy':
                            $kieu_thongke_text = 'quý';
                            $label_thoi_gian = 'Quý';
                            $label_prefix = 'Quý ';
                            break;
                        case 'nam':
                            $kieu_thongke_text = 'năm';
                            $label_thoi_gian = 'Năm';
                            $label_prefix = '';
                            break;
                    }

                    // Lấy dữ liệu thống kê doanh thu
                    $doanh_thu = thongke_doanhthu($kieu_thongke);
                    include "./Thongke/thongke_doanhthu.php";
                    break;

                // thống kê đơn hàng
                case 'thongke_donhang':
                    // Xác định kiểu thống kê (mặc định là tháng)
                    $kieu_thongke = isset($_POST['kieu_thongke']) ? $_POST['kieu_thongke'] : 'thang';

                    // Thiết lập các biến hiển thị tương ứng với kiểu thống kê
                    switch ($kieu_thongke) {
                        case 'thang':
                            $kieu_thongke_text = 'tháng';
                            $label_thoi_gian = 'Tháng';
                            $label_prefix = 'Tháng ';
                            break;
                        case 'quy':
                            $kieu_thongke_text = 'quý';
                            $label_thoi_gian = 'Quý';
                            $label_prefix = 'Quý ';
                            break;
                        case 'nam':
                            $kieu_thongke_text = 'năm';
                            $label_thoi_gian = 'Năm';
                            $label_prefix = '';
                            break;
                    }

                    // Lấy dữ liệu thống kê đơn hàng
                    $don_hang = thongke_donhang_theothoigian($kieu_thongke);
                    include "./Thongke/thongke_donhang.php";
                    break;

                // thống kê khách hàng
                case 'thongke_khachhang':
                    // Lấy dữ liệu khách hàng và đơn hàng chi tiết
                    include "./Thongke/thongke_khachhang.php";
                    break;

                // xem chi tiết đơn hàng từ trang thống kê khách hàng
                case 'donhang_detail':
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $order_id = $_GET['id'];
                        $chitietdh = loadall_chitietdh($order_id);
                        include "./donhang/chitetdh.php";
                    } else {
                        include "./viewadmin/home.php";
                    }
                    break;

                case 'bieudo':
                    $kieu_thongke = isset($_GET['kieu']) ? $_GET['kieu'] : 'thang';

                    // Thiết lập các biến hiển thị tương ứng với kiểu thống kê
                    switch ($kieu_thongke) {
                        case 'thang':
                            $kieu_thongke_text = 'tháng';
                            $label_thoi_gian = 'Tháng';
                            $label_prefix = 'Tháng ';
                            $chart_title = 'Biểu đồ doanh thu theo tháng';
                            break;
                        case 'quy':
                            $kieu_thongke_text = 'quý';
                            $label_thoi_gian = 'Quý';
                            $label_prefix = 'Quý ';
                            $chart_title = 'Biểu đồ doanh thu theo quý';
                            break;
                        case 'nam':
                            $kieu_thongke_text = 'năm';
                            $label_thoi_gian = 'Năm';
                            $label_prefix = '';
                            $chart_title = 'Biểu đồ doanh thu theo năm';
                            break;
                    }

                    $doanh_thu = thongke_doanhthu($kieu_thongke);
                    include "./Thongke/bieudo.php";
                    break;
                case 'bieudobl':
                    $kieu_thongke = isset($_GET['kieu']) ? $_GET['kieu'] : 'thang';

                    // Thiết lập các biến hiển thị tương ứng với kiểu thống kê
                    switch ($kieu_thongke) {
                        case 'thang':
                            $kieu_thongke_text = 'tháng';
                            $label_thoi_gian = 'Tháng';
                            $label_prefix = 'Tháng ';
                            $chart_title = 'Biểu đồ đơn hàng theo tháng';
                            break;
                        case 'quy':
                            $kieu_thongke_text = 'quý';
                            $label_thoi_gian = 'Quý';
                            $label_prefix = 'Quý ';
                            $chart_title = 'Biểu đồ đơn hàng theo quý';
                            break;
                        case 'nam':
                            $kieu_thongke_text = 'năm';
                            $label_thoi_gian = 'Năm';
                            $label_prefix = '';
                            $chart_title = 'Biểu đồ đơn hàng theo năm';
                            break;
                    }

                    $don_hang = thongke_donhang_theothoigian($kieu_thongke);
                    include "./Thongke/bieudobl.php";
                    break;

                case 'thongke_nhapkho_chitiet':
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $phieunhap_id = (int)$_GET['id'];
                        $chitiet = thongke_nhapkho_chitiet($phieunhap_id);

                        // Get receipt info
                        $sql = "SELECT 
                                    ir.id, 
                                    ir.receipt_date, 
                                    ir.status,
                                    ir.note,
                                    ncc.ncc_name, 
                                    kh.kh_name as nguoi_tao,
                                    DATE_FORMAT(ir.created_at, '%d/%m/%Y %H:%i') as created_time
                                FROM 
                                    import_receipts ir
                                LEFT JOIN 
                                    nhacungcap ncc ON ir.supplier_id = ncc.ncc_id
                                LEFT JOIN 
                                    khachhang kh ON ir.created_by = kh.kh_id
                                WHERE 
                                    ir.id = $phieunhap_id";
                        $receipt_info = pdo_query_one($sql);

                        // Output HTML content
                        include "./Thongke/thongke_nhapkho_chitiet.php";
                    } else {
                        echo '<div class="alert alert-danger">Không tìm thấy thông tin phiếu nhập</div>';
                    }
                    // Don't include any other view or code after this
                    exit(); // Need to exit to ensure only the HTML content is returned for AJAX
                    break;

                // Tự động cài đặt FPDF
                case 'install_fpdf':
                    include "./donhang/install_fpdf.php";
                    break;

                case "in_hoadon":
                    if (isset($_GET['order_id']) && $_GET['order_id'] != "") {
                        $order_id = $_GET['order_id'];

                        // Lấy thông tin đơn hàng kèm thông tin khách hàng
                        $sql = "SELECT o.*, k.kh_name, k.kh_mail, k.kh_tel, k.kh_address 
                                FROM `order` o 
                                JOIN khachhang k ON o.kh_id = k.kh_id 
                                WHERE order_id = $order_id";
                        $thongtindh = pdo_query_one($sql);

                        // Lấy chi tiết đơn hàng
                        $chitietdh = loadall_chitietdh($order_id);

                        // Bao gồm file in_hoadon.php để tạo PDF
                        include "./donhang/in_hoadon.php";
                    }
                    break;

                // thống kê nhập kho
                case 'thongke_nhapkho':
                    // Xác định thời gian thống kê
                    $thang = isset($_POST['thang']) ? (int)$_POST['thang'] : date('m');
                    $nam = isset($_POST['nam']) ? (int)$_POST['nam'] : date('Y');

                    // Hàm này cần được định nghĩa trong model/thongke.php
                    $nhapkho = thongke_nhapkho($thang, $nam);

                    include "./Thongke/thongke_nhapkho.php";
                    break;

                default:
                    include './viewadmin/home.php';

                    break;
            }
        }
        include './viewadmin/footter.php';
        ?>
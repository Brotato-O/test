<?php
// Tạo mảng các tháng để hiển thị trong dropdown
$months = [];
for ($i = 1; $i <= 12; $i++) {
    $months[$i] = 'Tháng ' . $i;
}

// Tạo mảng các năm để hiển thị trong dropdown (năm hiện tại và 5 năm trước)
$current_year = date('Y');
$years = [];
for ($i = $current_year - 5; $i <= $current_year; $i++) {
    $years[$i] = 'Năm ' . $i;
}

// Kiểm tra xem biến $nhapkho có tồn tại không (được truyền từ controller)
$nhapkho = $nhapkho ?? [];

// Lấy tổng số liệu
$thang_current = $thang ?? date('m');
$nam_current = $nam ?? date('Y');
$tong_thongke = thongke_nhapkho_tong($thang_current, $nam_current) ?? [
    'tong_so_phieu' => 0,
    'tong_so_luong' => 0,
    'tong_gia_tri' => 0,
];

// Hàm định dạng trạng thái
function formatStatus($status)
{
    switch ($status) {
        case 0:
            return '<span class="badge bg-warning">Nháp</span>';
        case 1:
            return '<span class="badge bg-success">Đã nhập kho</span>';
        case 2:
            return '<span class="badge bg-danger">Đã hủy</span>';
        default:
            return '<span class="badge bg-secondary">Không xác định</span>';
    }
}
?>

<!-- Add CSS for color boxes -->
<style>
.color-box {
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 3px;
    margin-right: 5px;
    vertical-align: middle;
    border: 1px solid #ccc;
}
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Thống kê nhập kho</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="indexadmin.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Thống kê nhập kho</li>
    </ol>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-1"></i>
            Lọc dữ liệu
        </div>
        <div class="card-body">
            <form action="indexadmin.php?act=thongke_nhapkho" method="post" class="row g-3">
                <div class="col-md-4">
                    <label for="thang" class="form-label">Tháng</label>
                    <select class="form-select" name="thang" id="thang">
                        <?php foreach ($months as $key => $value) : ?>
                        <option value="<?= $key ?>" <?= ($key == $thang_current) ? 'selected' : '' ?>><?= $value ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="nam" class="form-label">Năm</label>
                    <select class="form-select" name="nam" id="nam">
                        <?php foreach ($years as $key => $value) : ?>
                        <option value="<?= $key ?>" <?= ($key == $nam_current) ? 'selected' : '' ?>><?= $value ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Áp dụng</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="row">
        <div class="col-xl-4 col-md-4">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Tổng số phiếu nhập</h5>
                            <h2><?= number_format($tong_thongke['tong_so_phieu'] ?? 0) ?></h2>
                        </div>
                        <i class="fas fa-file-invoice fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Tổng số lượng</h5>
                            <h2><?= number_format($tong_thongke['tong_so_luong'] ?? 0) ?></h2>
                        </div>
                        <i class="fas fa-boxes fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-4">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Tổng giá trị</h5>
                            <h2><?= number_format($tong_thongke['tong_gia_tri'] ?? 0) ?> VNĐ</h2>
                        </div>
                        <i class="fas fa-money-bill-wave fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Chi tiết nhập kho <?= $months[$thang_current] ?? '' ?> <?= $nam_current ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="nhapkhoTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ngày nhập</th>
                            <th>Nhà cung cấp</th>
                            <th>Người tạo</th>
                            <th>Số SP</th>
                            <th>Số lượng</th>
                            <th>Giá trị</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($nhapkho)) : ?>
                        <tr>
                            <td colspan="9" class="text-center">Không có dữ liệu nhập kho trong thời gian này</td>
                        </tr>
                        <?php else : ?>
                        <?php foreach ($nhapkho as $item) : ?>
                        <tr>
                            <td><?= $item['phieunhap_id'] ?></td>
                            <td><?= date('d/m/Y', strtotime($item['ngay_nhap'])) ?></td>
                            <td><?= $item['ten_nhacungcap'] ?></td>
                            <td><?= $item['ten_nguoitao'] ?></td>
                            <td><?= number_format($item['so_sanpham_nhap']) ?></td>
                            <td><?= number_format($item['tong_so_luong']) ?></td>
                            <td><?= number_format($item['tong_gia_tri']) ?> VNĐ</td>
                            <td><?= formatStatus($item['trang_thai']) ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info viewDetails"
                                    data-id="<?= $item['phieunhap_id'] ?>">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Chi tiết phiếu nhập -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Chi tiết phiếu nhập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // DataTable initialization
    $('#nhapkhoTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json'
        }
    });

    // Handle view details button click
    document.querySelectorAll('.viewDetails').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            showDetails(id);
        });
    });

    function showDetails(id) {
        const detailContent = document.getElementById('detailContent');
        detailContent.innerHTML = `
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Đang tải...</span>
                </div>
            </div>
        `;

        // Hiển thị modal
        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
        detailModal.show();

        // Gọi AJAX để lấy chi tiết
        fetch(`indexadmin.php?act=thongke_nhapkho_chitiet&id=${id}`)
            .then(response => response.text())
            .then(data => {
                detailContent.innerHTML = data;
            })
            .catch(error => {
                detailContent.innerHTML =
                    `<div class="alert alert-danger">Có lỗi xảy ra khi tải dữ liệu: ${error}</div>`;
            });
    }
});
</script>
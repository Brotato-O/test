<!-- main -->
<div class="container">
    <style>
    .trang-thai-huy {
        background-color: #ffeeee;
        color: #dc3545;
    }

    .trang-thai-dang-giao {
        background-color: #fff8e1;
        color: #ff9800;
    }

    .trang-thai-da-giao {
        background-color: #e8f5e9;
        color: #28a745;
    }
    </style>

    <!-- Thanh menu thống kê -->
    <div class="row mb-4">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link" href="indexadmin.php?act=thongke_sanpham">Thống kê sản phẩm bán chạy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="indexadmin.php?act=thongke_doanhthu">Thống kê doanh thu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active bg-primary" href="indexadmin.php?act=thongke_donhang">Thống kê đơn
                        hàng</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Form chọn kiểu thống kê -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="indexadmin.php?act=thongke_donhang" method="POST" class="d-flex">
                <select class="form-select me-2" name="kieu_thongke" id="kieu_thongke">
                    <option value="thang"
                        <?= isset($_POST['kieu_thongke']) && $_POST['kieu_thongke'] == 'thang' ? 'selected' : '' ?>>Theo
                        tháng</option>
                    <option value="quy"
                        <?= isset($_POST['kieu_thongke']) && $_POST['kieu_thongke'] == 'quy' ? 'selected' : '' ?>>Theo
                        quý</option>
                    <option value="nam"
                        <?= isset($_POST['kieu_thongke']) && $_POST['kieu_thongke'] == 'nam' ? 'selected' : '' ?>>Theo
                        năm</option>
                </select>
                <button type="submit" class="btn btn-primary w-50">Xem thống kê</button>
            </form>
        </div>
    </div>

    <!-- PHẦN 3: THỐNG KÊ ĐƠN HÀNG -->
    <h2 class="border border-4 mb-4 text-black-50 p-3 text-center rounded">Thống kê đơn hàng theo
        <?= $kieu_thongke_text ?></h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-bg-secondary"><?= $label_thoi_gian ?></th>
                    <th class="text-bg-secondary">Trạng thái</th>
                    <th class="text-bg-secondary">Số đơn hàng</th>
                    <th class="text-bg-secondary">Tổng giá trị</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($don_hang)) {
                    foreach ($don_hang as $dh) {
                        extract($dh);
                        $trang_thai_class = '';
                        if ($order_trangthai == 'Đã hủy') {
                            $trang_thai_class = 'trang-thai-huy';
                        } elseif ($order_trangthai == 'Đang giao hàng') {
                            $trang_thai_class = 'trang-thai-dang-giao';
                        } elseif ($order_trangthai == 'Đã giao hàng') {
                            $trang_thai_class = 'trang-thai-da-giao';
                        }
                ?>
                <tr class="<?= $trang_thai_class ?>">
                    <td><?= $label_prefix . $thoi_gian ?></td>
                    <td><?= $order_trangthai ?></td>
                    <td><?= $so_don_hang ?></td>
                    <td>$<?= number_format($tong_gia_tri, 2) ?></td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="my-4">
        <a href="indexadmin.php?act=bieudobl&kieu=<?= $kieu_thongke ?>" class="btn btn-outline-secondary">
            Xem biểu đồ đơn hàng
        </a>
    </div>
</div>
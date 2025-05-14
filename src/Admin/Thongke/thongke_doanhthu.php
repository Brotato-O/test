<!-- main -->
<div class="container">
    <!-- Thanh menu thống kê -->
    <div class="row mb-4">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link" href="indexadmin.php?act=thongke_sanpham">Thống kê sản phẩm bán chạy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active bg-primary" href="indexadmin.php?act=thongke_doanhthu">Thống kê doanh
                        thu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="indexadmin.php?act=thongke_donhang">Thống kê đơn hàng</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Form chọn kiểu thống kê -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="indexadmin.php?act=thongke_doanhthu" method="POST" class="d-flex">
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

    <!-- PHẦN 2: THỐNG KÊ DOANH THU -->
    <h2 class="border border-4 mb-4 text-black-50 p-3 text-center rounded">Thống kê doanh thu theo
        <?= $kieu_thongke_text ?></h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-bg-secondary"><?= $label_thoi_gian ?></th>
                    <th class="text-bg-secondary">Doanh thu</th>
                    <th class="text-bg-secondary">Số đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($doanh_thu)) {
                    foreach ($doanh_thu as $dt) {
                        extract($dt);
                ?>
                <tr>
                    <td><?= $label_prefix . $thoi_gian ?></td>
                    <td>$<?= number_format($doanh_thu, 2) ?></td>
                    <td><?= $so_don_hang ?></td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="my-4">
        <a href="indexadmin.php?act=bieudo&kieu=<?= $kieu_thongke ?>" class="btn btn-outline-secondary">
            Xem biểu đồ doanh thu
        </a>
    </div>
</div>
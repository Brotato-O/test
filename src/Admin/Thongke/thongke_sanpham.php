<!-- main -->
<div class="container">
    <?php
    $page = 'sanpham';
    include 'menu_thongke.php';
    ?>

    <!-- Form chọn số lượng sản phẩm hiển thị -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form action="indexadmin.php?act=thongke_sanpham" method="POST" class="d-flex">
                <div class="input-group">
                    <span class="input-group-text">Hiển thị Top</span>
                    <input type="number" class="form-control" name="top_limit" value="<?= $top_limit ?>" min="1"
                        max="100">
                    <span class="input-group-text">sản phẩm bán chạy nhất</span>
                    <button type="submit" class="btn btn-primary">Xem</button>
                </div>
            </form>
        </div>
    </div>

    <!-- PHẦN 1: THỐNG KÊ SẢN PHẨM BÁN CHẠY -->
    <h2 class="border border-4 mb-4 text-black-50 p-3 text-center rounded">Thống kê Top <?= $top_limit ?> sản phẩm bán
        chạy nhất</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-bg-secondary">ID</th>
                    <th class="text-bg-secondary">Hình ảnh</th>
                    <th class="text-bg-secondary">Tên sản phẩm</th>
                    <th class="text-bg-secondary">Giá</th>
                    <th class="text-bg-secondary">Số lượng đã bán</th>
                    <th class="text-bg-secondary">Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($sp_banchay as $sp) {
                    extract($sp);
                ?>
                    <tr>
                        <td><?= $pro_id ?></td>
                        <td><img src="./sanpham/img/<?= $pro_img ?>" width="100" height="100" alt="<?= $pro_name ?>"></td>
                        <td><?= $pro_name ?></td>
                        <td>$<?= number_format($pro_price, 2) ?></td>
                        <td><?= $so_luong_ban ?></td>
                        <td>$<?= number_format($doanh_thu, 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
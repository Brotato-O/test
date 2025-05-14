<!-- main -->
   <?php if (!empty($message)): ?>
          <script>
              alert("<?= $message ?>");
          </script>
      <?php endif; ?>
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Danh sách đơn hàng</h2>
    <form action="" class="mb-4" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-4">
                <input class="w-100 p-1" type="text" placeholder="Nhập mã đơn hàng" name="kyw"
                    value="<?= isset($_POST['kyw']) ? $_POST['kyw'] : '' ?>">
            </div>
            <div class="col-sm-3">
                <input class="w-100 p-1" type="date" name="start_date"
                    value="<?= isset($_POST['start_date']) ? $_POST['start_date'] : '' ?>">
            </div>
            <div class="col-sm-3">
                <input class="w-100 p-1" type="date" name="end_date"
                    value="<?= isset($_POST['end_date']) ? $_POST['end_date'] : '' ?>">
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-secondary w-100" name="timkiem">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <Th class="text-bg-secondary"></Th>
                    <th class="text-bg-secondary">Mã đơn hàng</th>
                    <th class="text-bg-secondary">Khách hàng</th>
                    <th class="text-bg-secondary">Số lượng hàng</th>
                    <Th class="text-bg-secondary">Giá trị đơn hàng</Th>
                    <Th class="text-bg-secondary">Tình trạng đơn hàng</Th>
                    <Th class="text-bg-secondary">Ngày đặt hàng</Th>
                    <Th class="text-bg-secondary">Thao tác</Th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Phân trang
                $items_per_page = 7; // 7 đơn hàng mỗi trang
                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $current_page = max(1, $current_page); // Đảm bảo trang hiện tại ít nhất là 1
                $offset = ($current_page - 1) * $items_per_page;

                // Lấy dữ liệu đơn hàng theo phân trang
                if (isset($_POST['timkiem'])) {
                    $kyw = $_POST['kyw'] ?? '';
                    $start_date = $_POST['start_date'] ?? '';
                    $end_date = $_POST['end_date'] ?? '';
                    $listdh = loadall_donhang($kyw, $start_date, $end_date, $offset, $items_per_page);
                    $total_orders = count_all_donhang($kyw, $start_date, $end_date);
                } else {
                    $listdh = loadall_donhang('', '', '', $offset, $items_per_page);
                    $total_orders = count_all_donhang('', '', '');
                }

                $total_pages = ceil($total_orders / $items_per_page);

                foreach ($listdh as $donhang) {
                    extract($donhang);
                    $countsp = load_cart_count($sl);
                ?>
                    <tr>
                        <td><input type="checkbox" name="checkbox" id=""></td>
                        <td><?= $order_id ?></td>
                        <td>
                            <?= $kh_name . '<br>' . $kh_mail . '<br>' . $order_adress . '<br>' . $kh_tel ?>
                        </td>
                        <td><?= $countsp ?></td>
                        <td><?= $order_totalprice ?></td>
                        <td><?= $order_trangthai ?></td>
                        <td><?= $order_date ?></td>
                        <td>
                            <a href="indexadmin.php?act=suadonhang&order_id=<?php echo $order_id ?>" class="mb-2"><input
                                    class="mb-2 text-bg-secondary rounded" type="button" name="" value="Sửa" id=""></a>
                            <a href="indexadmin.php?act=chitietdh&order_id=<?php echo $order_id ?>"><input
                                    class="mb-2 text-bg-danger rounded" type="button" name="" value="Chi tiết đh" id=""></a>
                            <a href="indexadmin.php?act=xoadonhang&order_id=<?php echo $order_id ?>"><input
                                    class="mb-2 text-bg-success rounded" onclick="return confirm('Bạn có chắc muốn xoá ?')"
                                    type="button" name="" value="Xoá" id=""></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_orders > $items_per_page): ?>
        <div class="d-flex justify-content-center mt-4 mb-4">
            <nav aria-label="Điều hướng trang">
                <ul class="pagination">
                    <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="indexadmin.php?act=donhang&page=<?php echo $current_page - 1; ?>"
                                aria-label="Trước">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                            <a class="page-link" href="indexadmin.php?act=donhang&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="indexadmin.php?act=donhang&page=<?php echo $current_page + 1; ?>"
                                aria-label="Tiếp">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>

    <div class="">
        <button type="button" class="btn btn-secondary btn-sm ">Chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Bỏ chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Xoá các mục đã chọn</button>
    </div>
</div>
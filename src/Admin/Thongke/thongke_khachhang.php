<!-- main -->
<div class="container">
    <?php
    $page = 'khachhang';
    include 'menu_thongke.php';
    ?>

    <!-- Form chọn khoảng thời gian và số khách hàng -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="indexadmin.php?act=thongke_khachhang" method="POST" class="row g-3">
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" id="date_from" name="date_from"
                        value="<?= isset($_POST['date_from']) ? $_POST['date_from'] : '' ?>">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" id="date_to" name="date_to"
                        value="<?= isset($_POST['date_to']) ? $_POST['date_to'] : '' ?>">
                </div>
                <div class="col-md-3">
                    <label for="top_limit" class="form-label">Số lượng khách hàng</label>
                    <input type="number" class="form-control" id="top_limit" name="top_limit" min="1" max="20"
                        value="<?= isset($_POST['top_limit']) ? $_POST['top_limit'] : 5 ?>">
                </div>
                <div class="col-md-3">
                    <label for="sort_order" class="form-label">Sắp xếp</label>
                    <select class="form-select" id="sort_order" name="sort_order">
                        <option value="desc"
                            <?= (isset($_POST['sort_order']) && $_POST['sort_order'] == 'desc') ? 'selected' : '' ?>>
                            Giảm dần (Cao → Thấp)
                        </option>
                        <option value="asc"
                            <?= (isset($_POST['sort_order']) && $_POST['sort_order'] == 'asc') ? 'selected' : '' ?>>
                            Tăng dần (Thấp → Cao)
                        </option>
                    </select>
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Xem thống kê</button>
                </div>
            </form>
        </div>
    </div>

    <!-- THỐNG KÊ KHÁCH HÀNG MUA HÀNG NHIỀU NHẤT -->
    <?php
    // Default values
    $top_limit = isset($_POST['top_limit']) ? intval($_POST['top_limit']) : 5;
    $date_from = isset($_POST['date_from']) && $_POST['date_from'] != '' ? $_POST['date_from'] : null;
    $date_to = isset($_POST['date_to']) && $_POST['date_to'] != '' ? $_POST['date_to'] : null;
    $sort_order = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'desc';

    // Format dates for display - chỉ hiển thị khoảng thời gian nếu người dùng đã nhập
    $show_date_range = !empty($date_from) && !empty($date_to);
    $date_from_display = $date_from ? date('d/m/Y', strtotime($date_from)) : '';
    $date_to_display = $date_to ? date('d/m/Y', strtotime($date_to)) : '';

    // Lấy dữ liệu khách hàng top - chỉ khi có khoảng thời gian
    $khach_hang_top = $show_date_range ? get_top_khachhang($date_from, $date_to, $top_limit, $sort_order) : [];

    // Lấy dữ liệu đơn hàng chi tiết cho mỗi khách hàng - chỉ hiển thị đơn hàng đã giao
    $don_hang_chi_tiet = [];
    if (!empty($khach_hang_top)) {
        foreach ($khach_hang_top as $kh) {
            $user_id = $kh['user_id'];
            $don_hang_chi_tiet[$user_id] = get_donhang_by_user($user_id, $date_from, $date_to);
        }
    }
    ?>

    <h2 class="border border-4 mb-4 text-black-50 p-3 text-center rounded">
        Thống kê Top <?= $top_limit ?> khách hàng mua nhiều nhất
        <?php if ($show_date_range): ?>
        <br>
        <small class="text-muted">Từ ngày <?= $date_from_display ?> đến ngày <?= $date_to_display ?></small>
        <?php endif; ?>
    </h2>

    <?php if (empty($khach_hang_top)): ?>
    <!-- Thông báo khi không có dữ liệu -->
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        <?php if (empty($_POST['date_from']) || empty($_POST['date_to'])): ?>
        Vui lòng nhập khoảng thời gian để xem thống kê khách hàng.
        <?php else: ?>
        Không có dữ liệu đơn hàng đã hoàn thành trong khoảng thời gian này.
        <?php endif; ?>
    </div>
    <?php else: ?>
    <!-- Bảng thống kê khách hàng -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th class="text-bg-secondary">ID</th>
                    <th class="text-bg-secondary">Tên khách hàng</th>
                    <th class="text-bg-secondary">Email</th>
                    <th class="text-bg-secondary">Tổng số đơn hàng</th>
                    <th class="text-bg-secondary">Tổng giá trị mua hàng</th>
                    <th class="text-bg-secondary">Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (!empty($khach_hang_top)) {
                        foreach ($khach_hang_top as $kh) {
                            extract($kh);
                    ?>
                <tr>
                    <td><?= $user_id ?></td>
                    <td><?= $user_name ?></td>
                    <td><?= $user_email ?></td>
                    <td><?= $so_don_hang ?></td>
                    <td>$<?= number_format($tong_mua, 2) ?></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary toggle-details" data-user-id="<?= $user_id ?>">
                            Hiện chi tiết
                        </button>
                    </td>
                </tr>
                <tr class="order-details order-details-<?= $user_id ?>" style="display: none;">
                    <td colspan="6" class="p-0">
                        <table class="table table-sm mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Trạng thái</th>
                                    <th>Giá trị</th>
                                    <th>Xem chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                            if (!empty($don_hang_chi_tiet[$user_id])) {
                                                foreach ($don_hang_chi_tiet[$user_id] as $dh) {
                                                    extract($dh);
                                            ?>
                                <tr>
                                    <td>#<?= $order_id ?></td>
                                    <td><?= $order_date ?></td>
                                    <td><?= $order_trangthai ?></td>
                                    <td>$<?= number_format($order_tong, 2) ?></td>
                                    <td>
                                        <a href="indexadmin.php?act=donhang_detail&id=<?= $order_id ?>"
                                            class="btn btn-sm btn-info">Xem</a>
                                    </td>
                                </tr>
                                <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center'>Không có dữ liệu đơn hàng</td></tr>";
                                            }
                                            ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Không có dữ liệu</td></tr>";
                    }
                    ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- JavaScript để hiển thị/ẩn chi tiết đơn hàng -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-details');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const detailsRow = document.querySelector('.order-details-' + userId);

                if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                    detailsRow.style.display = 'table-row';
                    this.textContent = 'Ẩn chi tiết';
                    this.classList.replace('btn-outline-primary', 'btn-outline-danger');
                } else {
                    detailsRow.style.display = 'none';
                    this.textContent = 'Hiện chi tiết';
                    this.classList.replace('btn-outline-danger', 'btn-outline-primary');
                }
            });
        });
    });
    </script>
</div>
<!-- main -->
<div class="container">
    <?php if (isset($receipt_details) && !empty($receipt_details['receipt'])): ?>
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Chi tiết phiếu nhập
        #<?= $receipt_details['receipt']['id'] ?></h2>

    <!-- Thông tin phiếu nhập -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Thông tin phiếu nhập</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">Thông tin phiếu</h6>
                    <p><strong>Mã phiếu nhập:</strong> <?= $receipt_details['receipt']['id'] ?></p>
                    <p><strong>Ngày nhập:</strong> <?= $receipt_details['receipt']['receipt_date'] ?></p>
                    <p><strong>Người tạo:</strong> <?= $receipt_details['receipt']['created_by_name'] ?></p>
                    <p><strong>Trạng thái:</strong>
                        <?php
                            $status = $receipt_details['receipt']['status'];
                            switch ($status) {
                                case 0:
                                    echo '<span class="badge bg-warning">Nháp</span>';
                                    break;
                                case 1:
                                    echo '<span class="badge bg-success">Đã nhập kho</span>';
                                    break;
                                case 2:
                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                    break;
                                default:
                                    echo '<span class="badge bg-secondary">Không xác định</span>';
                            }
                            ?>
                    </p>
                    <?php if (!empty($receipt_details['receipt']['note'])): ?>
                    <p><strong>Ghi chú:</strong> <?= $receipt_details['receipt']['note'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Thông tin nhà cung cấp</h6>
                    <p><strong>Nhà cung cấp:</strong> <?= $receipt_details['receipt']['supplier_name'] ?></p>
                    <p><strong>Địa chỉ:</strong> <?= $receipt_details['receipt']['ncc_diachi'] ?></p>
                    <p><strong>Số điện thoại:</strong> <?= $receipt_details['receipt']['ncc_sdt'] ?></p>
                    <p><strong>Email:</strong> <?= $receipt_details['receipt']['ncc_email'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chi tiết sản phẩm -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Chi tiết sản phẩm</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-secondary">
                        <tr>
                            <th>Mã CT</th>
                            <th>Sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Màu sắc</th>
                            <th>Kích cỡ</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total_amount = 0;
                            if (isset($receipt_details['details']) && !empty($receipt_details['details'])):
                                foreach ($receipt_details['details'] as $item):
                                    $total_amount += $item['total_price'];
                            ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['pro_name'] ?></td>
                            <td>
                                <?php if (!empty($item['pro_img'])): ?>
                                <img src="./sanpham/img/<?= $item['pro_img'] ?>" width="60" height="60"
                                    alt="<?= $item['pro_name'] ?>" class="img-thumbnail">
                                <?php else: ?>
                                <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="d-inline-block me-2"
                                    style="width: 20px; height: 20px; background-color: <?= $item['color_ma'] ?>; border: 1px solid #ccc;"></span>
                                <?= $item['color_name'] ?>
                            </td>
                            <td><?= $item['size_name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$ <?= number_format($item['unit_price'], 0, ',', '.') ?></td>
                            <td>$ <?= number_format($item['total_price'], 0, ',', '.') ?></td>
                        </tr>
                        <?php
                                endforeach;
                            else:
                                ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có dữ liệu chi tiết phiếu nhập</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="text-end fw-bold">Tổng tiền:</td>
                            <td class="fw-bold">$ <?= number_format($total_amount, 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <?php if ($receipt_details['receipt']['status'] == 0): ?>
        <a href="indexadmin.php?act=suapn&id=<?= $receipt_details['receipt']['id'] ?>" class="btn btn-primary me-2">
            <i class="bi bi-pencil"></i> Cập nhật phiếu nhập
        </a>
        <?php endif; ?>
        <a href="indexadmin.php?act=in_phieunhap&id=<?= $receipt_details['receipt']['id'] ?>"
            class="btn btn-danger me-2" target="_blank">
            <i class="bi bi-printer"></i> In phiếu nhập
        </a>
        <a href="indexadmin.php?act=phieunhap" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
    </div>
    <?php else: ?>
    <div class="alert alert-danger">
        <h4 class="alert-heading">Không tìm thấy phiếu nhập!</h4>
        <p>Không tìm thấy thông tin phiếu nhập yêu cầu hoặc phiếu nhập không tồn tại.</p>
        <hr>
        <a href="indexadmin.php?act=phieunhap" class="btn btn-outline-danger">Quay lại danh sách phiếu nhập</a>
    </div>
    <?php endif; ?>
</div>
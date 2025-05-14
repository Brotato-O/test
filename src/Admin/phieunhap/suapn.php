<!-- main -->
<div class="container">
    <?php if (isset($receipt_details) && !empty($receipt_details['receipt'])): ?>
        <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Cập nhật phiếu nhập #<?= $receipt_details['receipt']['id'] ?></h2>

        <!-- Thông tin phiếu nhập -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Thông tin phiếu nhập</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Mã phiếu nhập:</strong> <?= $receipt_details['receipt']['id'] ?></p>
                        <p><strong>Ngày nhập:</strong> <?= $receipt_details['receipt']['receipt_date'] ?></p>
                        <p><strong>Người tạo:</strong> <?= $receipt_details['receipt']['created_by_name'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Nhà cung cấp:</strong> <?= $receipt_details['receipt']['supplier_name'] ?></p>
                        <p><strong>Địa chỉ:</strong> <?= $receipt_details['receipt']['ncc_diachi'] ?></p>
                        <p><strong>Số điện thoại:</strong> <?= $receipt_details['receipt']['ncc_sdt'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cập nhật trạng thái phiếu nhập -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Cập nhật trạng thái phiếu nhập</h5>
            </div>
            <div class="card-body">
                <form action="indexadmin.php?act=updatepn" method="post">
                    <input type="hidden" name="receipt_id" value="<?= $receipt_details['receipt']['id'] ?>">
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái phiếu nhập</label>
                        <select class="form-select" id="status" name="status">
                            <option value="0" <?= $receipt_details['receipt']['status'] == 0 ? 'selected' : '' ?>>Nháp</option>
                            <option value="1" <?= $receipt_details['receipt']['status'] == 1 ? 'selected' : '' ?>>Đã nhập kho</option>
                            <option value="2" <?= $receipt_details['receipt']['status'] == 2 ? 'selected' : '' ?>>Đã hủy</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="note" name="note" rows="3"><?= $receipt_details['receipt']['note'] ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update_status">Cập nhật trạng thái</button>
                </form>
            </div>
        </div>

        <!-- Danh sách sản phẩm đã nhập -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Danh sách sản phẩm đã nhập</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th>Mã CT</th>
                                <th>Sản phẩm</th>
                                <th>Màu sắc</th>
                                <th>Kích cỡ</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                                <th>Thao tác</th>
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
                                            <span class="d-inline-block me-2"
                                                style="width: 20px; height: 20px; background-color: <?= $item['color_ma'] ?>; border: 1px solid #ccc;"></span>
                                            <?= $item['color_name'] ?>
                                        </td>
                                        <td><?= $item['size_name'] ?></td>
                                        <td><?= $item['quantity'] ?></td>
                                        <td>$ <?= number_format($item['unit_price'], 0, ',', '.') ?></td>
                                        <td>$ <?= number_format($item['total_price'], 0, ',', '.') ?></td>
                                        <td>
                                            <?php if ($receipt_details['receipt']['status'] == 0): ?>
                                                <a href="indexadmin.php?act=suapnchitiet&id=<?= $item['id'] ?>&receipt_id=<?= $receipt_details['receipt']['id'] ?>" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="indexadmin.php?act=xoapnchitiet&id=<?= $item['id'] ?>&receipt_id=<?= $receipt_details['receipt']['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa chi tiết này?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
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
                                <td colspan="6" class="text-end fw-bold">Tổng tiền:</td>
                                <td class="fw-bold">$ <?= number_format($total_amount, 0, ',', '.') ?></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Thêm sản phẩm mới vào phiếu nhập -->
        <?php if ($receipt_details['receipt']['status'] == 0): ?>
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Thêm sản phẩm vào phiếu nhập</h5>
                </div>
                <div class="card-body">
                    <form action="indexadmin.php?act=addpnchitiet" method="post" class="row g-3">
                        <input type="hidden" name="receipt_id" value="<?= $receipt_details['receipt']['id'] ?>">

                        <!-- Mã sản phẩm -->
                        <div class="col-md-6">
                            <label class="form-label">Sản phẩm</label>
                            <?php $products = queryallpro('', 0); ?>
                            <select class="form-select" name="pro_id" required>
                                <option value="">-- Chọn sản phẩm --</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= $product['pro_id'] ?>"><?= $product['pro_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Màu -->
                        <div class="col-md-3">
                            <label class="form-label">Màu</label>
                            <?php $color = query_allcolor(); ?>
                            <select class="form-select" name="color_id" required>
                                <?php foreach ($color as $clor): ?>
                                    <option value="<?= $clor['color_id'] ?>"><?= $clor['color_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Size -->
                        <div class="col-md-3">
                            <label class="form-label">Size</label>
                            <?php $size = query_allsize(); ?>
                            <select class="form-select" name="size_id" required>
                                <?php foreach ($size as $sz): ?>
                                    <option value="<?= $sz['size_id'] ?>"><?= $sz['size_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Số lượng -->
                        <div class="col-md-4">
                            <label class="form-label">Số lượng</label>
                            <input type="number" class="form-control" name="quantity" min="1" required>
                        </div>

                        <!-- Đơn giá nhập -->
                        <div class="col-md-4">
                            <label class="form-label">Đơn giá nhập</label>
                            <input type="number" class="form-control" name="unit_price" min="0" required>
                        </div>

                        <!-- Tổng tiền (tự tính) -->
                        <div class="col-md-4">
                            <label class="form-label">Thành tiền</label>
                            <input type="number" class="form-control" name="total_price" readonly>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-success" name="add_detail">Thêm sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="indexadmin.php?act=chitietpn&id=<?= $receipt_details['receipt']['id'] ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại chi tiết
            </a>
            <a href="indexadmin.php?act=phieunhap" class="btn btn-secondary">
                <i class="bi bi-list"></i> Quay lại danh sách
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

<script>
    // JavaScript để tính tự động thành tiền khi nhập số lượng và đơn giá
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.querySelector('input[name="quantity"]');
        const unitPriceInput = document.querySelector('input[name="unit_price"]');
        const totalPriceInput = document.querySelector('input[name="total_price"]');

        function calculateTotal() {
            const quantity = parseInt(quantityInput.value) || 0;
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            const total = quantity * unitPrice;
            totalPriceInput.value = total;
        }

        if (quantityInput && unitPriceInput && totalPriceInput) {
            quantityInput.addEventListener('input', calculateTotal);
            unitPriceInput.addEventListener('input', calculateTotal);
        }
    });
</script>
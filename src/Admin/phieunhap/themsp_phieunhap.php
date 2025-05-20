<!-- main -->
<div class="container">
    <?php if (isset($receipt_details) && !empty($receipt_details['receipt'])): ?>
    <!-- Thông tin phiếu nhập -->
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Thêm sản phẩm vào phiếu nhập
        #<?= $receipt_details['receipt']['id'] ?></h2>

    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Thông tin phiếu nhập</h5>
        </div>
        <div class="card-body row">
            <div class="col-md-6">
                <p><strong>Mã phiếu nhập:</strong> <?= $receipt_details['receipt']['id'] ?></p>
                <p><strong>Ngày nhập:</strong>
                    <?= date('d-m-Y', strtotime($receipt_details['receipt']['receipt_date'])) ?></p>
                <p><strong>Người tạo:</strong> <?= $receipt_details['receipt']['created_by_name'] ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Nhà cung cấp:</strong> <?= $receipt_details['receipt']['supplier_name'] ?></p>
                <p><strong>Địa chỉ:</strong> <?= $receipt_details['receipt']['ncc_diachi'] ?></p>
                <p><strong>Số điện thoại:</strong> <?= $receipt_details['receipt']['ncc_sdt'] ?></p>
            </div>
        </div>
    </div>

    <!-- Thêm sản phẩm vào phiếu nhập -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Thêm sản phẩm</h5>
        </div>
        <div class="card-body">
            <form action="indexadmin.php?act=add_product_to_receipt" method="post">
                <input type="hidden" name="receipt_id" value="<?= $receipt_details['receipt']['id'] ?>">

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="pro_id" class="form-label">Sản phẩm</label>
                        <select class="form-select" id="pro_id" name="pro_id" required>
                            <option value="">-- Chọn sản phẩm --</option>
                            <?php foreach ($list_products as $product): ?>
                            <option value="<?= $product['pro_id'] ?>"><?= $product['pro_name'] ?> -
                                $<?= $product['pro_price'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="color_id" class="form-label">Màu sắc</label>
                        <select class="form-select" id="color_id" name="color_id" required>
                            <option value="">-- Chọn màu --</option>
                            <?php foreach ($list_colors as $color): ?>
                            <option value="<?= $color['color_id'] ?>"><?= $color['color_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="size_id" class="form-label">Kích cỡ</label>
                        <select class="form-select" id="size_id" name="size_id" required>
                            <option value="">-- Chọn kích cỡ --</option>
                            <?php foreach ($list_sizes as $size): ?>
                            <option value="<?= $size['size_id'] ?>"><?= $size['size_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="quantity" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="unit_price" class="form-label">Đơn giá</label>
                        <input type="number" class="form-control" id="unit_price" name="unit_price" min="0" step="0.01"
                            required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="total_price" class="form-label">Thành tiền</label>
                        <input type="text" class="form-control" id="total_price" readonly>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" name="add_product">
                        <i class="bi bi-plus-circle"></i> Thêm sản phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách sản phẩm đã thêm -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Sản phẩm đã thêm</h5>
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
                        </tr>
                        <?php
                                endforeach;
                            else:
                                ?>
                        <tr>
                            <td colspan="7" class="text-center">Chưa có sản phẩm nào được thêm vào phiếu nhập này</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-end fw-bold">Tổng tiền:</td>
                            <td class="fw-bold">$ <?= number_format($total_amount, 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Nút hoàn thành -->
    <div class="d-flex justify-content-between mb-4">
        <form action="indexadmin.php?act=complete_receipt" method="post">
            <input type="hidden" name="receipt_id" value="<?= $receipt_details['receipt']['id'] ?>">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle"></i> Hoàn thành phiếu nhập
            </button>
        </form>
        <a href="indexadmin.php?act=phieunhap" class="btn btn-secondary">
            <i class="bi bi-x-circle"></i> Hủy
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
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const totalPriceInput = document.getElementById('total_price');

    function calculateTotal() {
        const quantity = parseInt(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalPriceInput.value = '$ ' + total.toFixed(2);
    }

    if (quantityInput && unitPriceInput && totalPriceInput) {
        quantityInput.addEventListener('input', calculateTotal);
        unitPriceInput.addEventListener('input', calculateTotal);
    }
});
</script>
<!-- main -->
<div class="container">
    <?php if (isset($receipt_details) && !empty($receipt_details['receipt'])): ?>
    <!-- Thông báo giới hạn chức năng -->
    <div class="alert alert-info mb-4">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Lưu ý:</strong> Phiếu nhập sau khi tạo chỉ có thể cập nhật trạng thái và ghi chú. Không thể thêm hoặc
        xóa sản phẩm để đảm bảo tính toàn vẹn dữ liệu kho hàng.
    </div>

    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Cập nhật trạng thái phiếu nhập
        #<?= $receipt_details['receipt']['id'] ?></h2>

    <!-- Thông tin phiếu nhập -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Thông tin phiếu nhập</h5>
        </div>
        <div class="card-body">
            <div class="row">
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
                        <option value="0" <?= $receipt_details['receipt']['status'] == 0 ? 'selected' : '' ?>>Nháp
                        </option>
                        <option value="1" <?= $receipt_details['receipt']['status'] == 1 ? 'selected' : '' ?>>Đã nhập
                            kho</option>
                        <option value="2" <?= $receipt_details['receipt']['status'] == 2 ? 'selected' : '' ?>>Đã hủy
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Ghi chú</label>
                    <textarea class="form-control" id="note" name="note"
                        rows="3"><?= $receipt_details['receipt']['note'] ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="update_status">Cập nhật trạng thái</button>
                <a href="indexadmin.php?act=phieunhap" class="btn btn-secondary">
                    <i class="bi bi-list"></i> Quay lại danh sách
                </a>
            </form>
        </div>
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
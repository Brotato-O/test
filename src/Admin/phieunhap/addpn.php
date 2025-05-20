<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Tạo phiếu nhập mới</h2>
    <div class="container text-bg-light rounded p-4">

        <form action="indexadmin.php?act=addpn" method="post">
            <div class="row mb-4">
                <div class="col-md-6">
                    <!-- Nhà cung cấp -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Chọn nhà cung cấp</label>
                        <select class="form-select" name="ncc_id" id="supplier-select" required>
                            <option value="">-- Chọn nhà cung cấp --</option>
                            <?php
                            $suppliers = get_all_suppliers(); // Assume this function exists in model
                            if (is_array($suppliers) && count($suppliers) > 0) {
                                foreach ($suppliers as $supplier) {
                                    echo "<option value='{$supplier['ncc_id']}' 
                                        data-email='{$supplier['ncc_email']}' 
                                        data-phone='{$supplier['ncc_sdt']}' 
                                        data-address='{$supplier['ncc_diachi']}'>{$supplier['ncc_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="supplier-email" name="ncc_email"
                            placeholder="Email nhà cung cấp" readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="supplier-phone" name="ncc_sdt"
                            placeholder="Số điện thoại nhà cung cấp" readonly>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="supplier-address" name="ncc_diachi"
                            placeholder="Địa chỉ nhà cung cấp" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Ghi chú -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ghi chú</label>
                        <textarea class="form-control" name="note" rows="3"
                            placeholder="Nhập ghi chú nếu có"></textarea>
                    </div>
                </div>
            </div>

            <!-- Nút thao tác -->
            <div class="mt-4">
                <button type="submit" class="btn btn-primary" name="addpn">
                    <i class="bi bi-plus-circle"></i> Tạo phiếu nhập
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Nhập lại
                </button>
                <a href="indexadmin.php?act=phieunhap" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        </form>

        <div class="alert alert-info mt-4">
            <i class="bi bi-info-circle"></i> Sau khi tạo phiếu nhập, bạn sẽ được chuyển đến trang thêm sản phẩm vào
            phiếu.
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const supplierSelect = document.getElementById('supplier-select');
    const supplierEmail = document.getElementById('supplier-email');
    const supplierPhone = document.getElementById('supplier-phone');
    const supplierAddress = document.getElementById('supplier-address');

    supplierSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];

        supplierEmail.value = selectedOption.getAttribute('data-email') || '';
        supplierPhone.value = selectedOption.getAttribute('data-phone') || '';
        supplierAddress.value = selectedOption.getAttribute('data-address') || '';
    });
});
</script>
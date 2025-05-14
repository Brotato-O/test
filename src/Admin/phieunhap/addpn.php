<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Tạo phiếu nhập mới</h2>
    <div class="container text-bg-light rounded p-4">

        <form action="indexadmin.php?act=addpn" method="post">
            <div class="row mb-4">
                <div class="col-md-6">
                    <!-- Nhà cung cấp -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nhập thông tin nhà cung cấp</label>
                        <input type="text" class="form-control" name="ncc_name" required placeholder="Tên nhà cung cấp">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" name="ncc_email" placeholder="Email nhà cung cấp">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="ncc_sdt" placeholder="Số điện thoại nhà cung cấp">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="ncc_diachi" placeholder="Địa chỉ nhà cung cấp">
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Ghi chú -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ghi chú</label>
                        <textarea class="form-control" name="note" rows="3" placeholder="Nhập ghi chú nếu có"></textarea>
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
            <i class="bi bi-info-circle"></i> Sau khi tạo phiếu nhập, bạn có thể thêm các sản phẩm vào phiếu nhập bằng cách vào trang chi tiết phiếu nhập.
        </div>
    </div>
</div>
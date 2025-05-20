<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Thêm nhà cung cấp mới</h2>
    <div class="container text-bg-light rounded">

        <form action="indexadmin.php?act=addNCC" method="post">
            <div class="mb-3 mt-3">
                <label for="ncc_name" class="form-label text-danger">Tên nhà cung cấp:</label>
                <input type="text" class="form-control" id="ncc_name" placeholder="Tên nhà cung cấp" name="ncc_name"
                    required>
            </div>
            <div class="mb-3 mt-3">
                <label for="ncc_email" class="form-label text-danger">Email:</label>
                <input type="email" class="form-control" id="ncc_email" placeholder="Email" name="ncc_email" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="ncc_tel" class="form-label text-danger">Số điện thoại:</label>
                <input type="tel" class="form-control" id="ncc_tel" placeholder="Số điện thoại" name="ncc_tel" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="ncc_address" class="form-label text-danger">Địa chỉ:</label>
                <input type="text" class="form-control" id="ncc_address" placeholder="Địa chỉ" name="ncc_address"
                    required>
            </div>

            <div class="mb-3 mt-3">
                <button type="submit" class="btn btn-secondary btn-sm" name="themncc">Thêm mới</button>
                <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                <a href="indexadmin.php?act=ncc">
                    <button type="button" class="btn btn-secondary btn-sm">Danh sách nhà cung cấp</button>
                </a>
            </div>
        </form>
    </div>
</div>
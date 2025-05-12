<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Thêm phiếu nhập</h2>
    <div class="container text-bg-light rounded">

        <form action="indexadmin.php?act=addpn" method="post">
            <!-- Nhà cung cấp -->
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Nhà cung cấp</label>
                <?php $ncc = loadAllNcc(); ?>
                <select class="form-select" name="ncc_id" required>
                    <?php foreach ($ncc as $ncc1): ?>
                        <option value="<?= $ncc1['ncc_id'] ?>"><?= $ncc1['ncc_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

          
           

            <!-- Mã sản phẩm -->
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Mã sản phẩm:</label>
                <input type="text" class="form-control" name="pro_id" required>
            </div>

            <!-- Màu -->
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Màu:</label>
                <?php $color = query_allcolor(); ?>
                <select class="form-select" name="color_id" required>
                    <?php foreach ($color as $clor): ?>
                        <option value="<?= $clor['color_id'] ?>"><?= $clor['color_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Size -->
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Size:</label>
                <?php $size = query_allsize(); ?>
                <select class="form-select" name="size_id" required>
                    <?php foreach ($size as $sz): ?>
                        <option value="<?= $sz['size_id'] ?>"><?= $sz['size_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Số lượng -->
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Số lượng:</label>
                <input type="number" class="form-control" name="soluong" required>
            </div>

            <!-- Đơn giá nhập -->
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Đơn giá nhập:</label>
                <input type="number" class="form-control" name="dongia" required>
            </div>

            <!-- Tổng tiền (có thể bỏ qua và tính trong PHP) -->
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Tổng tiền:</label>
                <input type="number" class="form-control" name="tongtien" placeholder="Sẽ tính tự động nếu để trống">
            </div>

            <!-- Nút thao tác -->
            <div>
                <button type="submit" class="btn btn-secondary btn-sm" name="addpn">Thêm phiếu nhập</button>
                <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                <a href="indexadmin.php?act=phieunhap">
                    <button type="button" class="btn btn-secondary btn-sm">Danh sách phiếu nhập</button>
                </a>
            </div>
        </form>
    </div>
</div>

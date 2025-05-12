<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Thêm phiếu bảo hành</h2>
    <div class="container text-bg-light rounded">

        <form action="indexadmin.php?act=addbh" method="post">
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Sản phẩm</label>
                <?php $pro = queryallpro('', 0); ?>
                <select class="form-select" name="pro_id">
                    <?php foreach ($pro as $p): ?>
                        <option value="<?= $p['pro_id'] ?>"><?= $p['pro_name'] ?> - ID: <?= $p['pro_id'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">mã khách hàng:</label>
                <input type="number" class="form-control" name="kh_id" required>
            </div>
        
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Nội dung:</label>
                <input type="text" class="form-control" name="noidung" required>
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Thời gian bảo hành:</label>
                <input type="number" class="form-control" name="thoigian" required>
            </div>
            
            <!-- Nút thao tác -->
            <div>
                <button type="submit" class="btn btn-secondary btn-sm" name="addbh">Thêm phiếu bảo hành</button>
                <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                <a href="indexadmin.php?act=bh">
                    <button type="button" class="btn btn-secondary btn-sm">Danh sách phiếu bảo hành</button>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Thêm quyền</h2>
    <div class="container text-bg-light rounded">

        <form action="indexadmin.php?act=addpq" method="post">
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Mã vai trò</label>
                <?php
                    $listvt = getallvt(); // Sử dụng đúng biến $listvt
                    if (empty($listvt)) {
                        echo "<p>Không có vai trò nào.</p>";
                    }
                ?>
                <select class="form-select" name="vaitro_id" required>
                    <?php foreach ($listvt as $ncc1): ?>
                        <option value="<?= $ncc1['vaitro_id'] ?>"><?= $ncc1['vaitro_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Mã quyền</label>
                <?php 
                    $result_pro = getallquyen(); 
                    if (empty($result_pro)) {
                        echo "<p>Không có quyền nào.</p>";
                    }
                ?>
                <select class="form-select" name="permission_id" required>
                    <?php foreach ($result_pro as $ncc1): ?>
                        <option value="<?= $ncc1['permission_id'] ?>"><?= $ncc1['permission_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Nút thao tác -->
            <div>
                <button type="submit" class="btn btn-secondary btn-sm" name="addpq">Thêm quyền</button>
                <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                <a href="indexadmin.php?act=pq">
                    <button type="button" class="btn btn-secondary btn-sm">Danh sách quyền</button>
                </a>
            </div>
        </form>
    </div>
</div>

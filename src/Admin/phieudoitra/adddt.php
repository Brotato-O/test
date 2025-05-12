<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Thêm phiếu nhập</h2>
    <div class="container text-bg-light rounded">

        <form action="indexadmin.php?act=adddt" method="post">
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Mã hóa đơn</label>
                <?php $kyw = "";
                    $start_date = "";
                    $end_date = "";
                    $listdh = loadall_donhang($kyw, $start_date, $end_date); ?>
                <select class="form-select" name="order_id" required>
                    <?php foreach ($listdh as $ncc1): ?>
                        <option value="<?= $ncc1['order_id'] ?>"><?= $ncc1['order_id'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Mã sản phẩm</label>
                <?php 
                     $result_pro = queryallpro('', 0); ?>
                <select class="form-select" name="pro_id" required>
                    <?php foreach (  $result_pro as $ncc1): ?>
                        <option value="<?= $ncc1['pro_id'] ?>"><?= $ncc1['pro_id'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Mã sản phẩm mới</label>
                <?php 
                     $result_pro = queryallpro('', 0); ?>
                <select class="form-select" name="pro_moi_id" >
                <option value="">-- Không chọn  --</option>
                    <?php foreach (  $result_pro as $ncc1): ?>
                        <option value="<?= $ncc1['pro_id'] ?>"><?= $ncc1['pro_id'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
           
            <!-- Màu -->
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Màu:</label>
                <?php $color = query_allcolor(); ?>
                <select class="form-select" name="color_id" >
                <option value="">-- Không chọn  --</option>
                    <?php foreach ($color as $clor): ?>
                        <option value="<?= $clor['color_id'] ?>"><?= $clor['color_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Size -->
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Size:</label>
                <?php $size = query_allsize(); ?>
                <select class="form-select" name="size_id" >
                <option value="">-- Không chọn --</option>
                    <?php foreach ($size as $sz): ?>
                        <option value="<?= $sz['size_id'] ?>"><?= $sz['size_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Mã khách hàng:</label>
                <input type="number" class="form-control" name="kh_id" required>
            </div>

          
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">lý do:</label>
                <input type="text" class="form-control" name="lydo" required>
            </div>

           
            <div class="mb-3 mt-3">
                <label class="form-label text-danger">Trạng thái:</label>
                <input type="text" class="form-control" name="trangthai" required>
            </div>

            <!-- Nút thao tác -->
            <div>
                <button type="submit" class="btn btn-secondary btn-sm" name="adddt">Thêm phiếu đổi/trả</button>
                <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                <a href="indexadmin.php?act=doitra">
                    <button type="button" class="btn btn-secondary btn-sm">Danh sách phiếu đổi/trả</button>
                </a>
            </div>
        </form>
    </div>
</div>

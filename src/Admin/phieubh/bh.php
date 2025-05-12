<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Danh sách phiếu bảo hành</h2>
   
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <Th class="text-bg-secondary"></Th>
                    <th class="text-bg-secondary">Mã phiếu bảo hành</th>
                    <th class="text-bg-secondary">Sản phẩm</th>
                    <th class="text-bg-secondary">Mã khách hàng</th>
                    <Th class="text-bg-secondary">Nhân viên</Th>
                    <Th class="text-bg-secondary">Ngày bảo hành</Th>
                    <Th class="text-bg-secondary">Nội dung</Th>
                    <Th class="text-bg-secondary">Thời gian bảo hành</Th>
                    <Th class="text-bg-secondary">Thao tác</Th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($listbh as $itembh) { 
                              extract($itembh);
?>
<tr>
    <td><input type="checkbox" name="checkbox[]" value="<?= $id ?>"></td>
    <td><?= $id ?></td>
    <td><?= $pro_id ?></td>
    <td><?= $kh_id ?></td>
    <td><?= $nhan_vien_id ?></td>
    <td><?= $ngay_bao_hanh ?></td>
    <td><?= $noi_dung ?></td>
    <td><?= $thoi_gian_bao_hanh ?></td>
    <td>
        <a href="indexadmin.php?act=suadonhang&order_id=<?= $id ?>" class="mb-2">
            <input class="mb-2 text-bg-secondary rounded" type="button" value="Sửa">
        </a>
        <a href="indexadmin.php?act=xoabh&id=<?= $id ?>">
            <input class="mb-2 text-bg-success rounded" onclick="return confirm('Bạn có chắc muốn xoá ?')" type="button" value="Xoá">
        </a>
    </td>
</tr>
<?php  } ?>

            </tbody>
        </table>
    </div>
    <div class="">
        <button type="button" class="btn btn-secondary btn-sm ">Chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Bỏ chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Xoá các mục đã chọn</button>
        <a href="indexadmin.php?act=addbh1">
            <button type="button" class="btn btn-secondary btn-sm">Thêm phiếu bh</button>
        </a>
    </div>
</div>
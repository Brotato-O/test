<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Danh sách phiếu đổi trả</h2>
   
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <Th class="text-bg-secondary"></Th>
                    <th class="text-bg-secondary">Mã phiếu đổi trả</th>
                    <th class="text-bg-secondary">Mã hóa đơn</th>
                    <th class="text-bg-secondary">Mã sản phẩm</th>
                    <th class="text-bg-secondary">Mã sản phẩm mới</th>
                    <th class="text-bg-secondary">Mã màu</th>
                    <th class="text-bg-secondary">Mã size</th>
                    <th class="text-bg-secondary">Mã khách hàng</th>
                    <Th class="text-bg-secondary">Ngày đổi</Th>
                    <Th class="text-bg-secondary">Lý do</Th>
                    <Th class="text-bg-secondary">Trạng thái</Th>
                    <Th class="text-bg-secondary">Thao tác</Th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($listdoitra as $itemdt) { 
                              extract($itemdt);
                 $color = !empty($color_id) ? query_onecolor($color_id) : null;
                $size = !empty($size_id) ? query_onesize($size_id) : null;

?>
<tr>
    <td><input type="checkbox" name="checkbox[]" value="<?= $id ?>"></td>
   
        <td><?= $id ?></td>
        <td><?= $order_id ?></td>
        <td><?= $pro_id ?></td>
        <td><?= $pro_moi_id ?></td>
        <td><?php if ($color): ?>
            <input type="button" style="background-color: <?= $color['color_ma'] ?>;" class="">
        <?php else: ?>
            <!-- Không có color_id -->
            <div></div>
        <?php endif; ?></td>
        <td> <?php if ($size): ?>
            <input type="button" class="" value="<?= $size['size_name'] ?>">
        <?php else: ?>
            <!-- Không có size_id -->
            <div></div>
        <?php endif; ?></td>
        <td><?= $kh_id ?></td>
        <td><?= $ngay_doi ?></td>
        <td><?= $ly_do ?></td>
        <td><?= $trang_thai ?></td>

    <td>
        <a href="indexadmin.php?act=suadonhang&order_id=<?= $id ?>" class="mb-2">
            <input class="mb-2 text-bg-secondary rounded" type="button" value="Sửa">
        </a>
        <a href="indexadmin.php?act=xoadt&id=<?= $id ?>">
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
        <a href="indexadmin.php?act=adddt1">
            <button type="button" class="btn btn-secondary btn-sm">Thêm phiếu đổi/trả</button>
        </a>
    </div>
</div>
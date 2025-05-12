<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Danh sách phiếu Nhập</h2>
   
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <Th class="text-bg-secondary"></Th>
                    <th class="text-bg-secondary">Mã phiếu nhập</th>
                    <th class="text-bg-secondary">Nhà cung cấp</th>
                    <th class="text-bg-secondary">Nhân viên</th>
                    <Th class="text-bg-secondary">Ngày đặt</Th>
                    <Th class="text-bg-secondary">Tổng tiền</Th>
                    <Th class="text-bg-secondary">Thao tác</Th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listreceipts as $phieunhap) {
                    extract($phieunhap);
                ?>
                <tr>
                    <td><input type="checkbox" name="checkbox" id=""></td>
                    <td><?= $id ?></td>
                    <td><?= $supplier_name ?></td>
                    <td><?= $created_by_name ?></td>
                    <td><?= $receipt_date ?></td>
                    <td><?= $total_amount ?></td>
                    <td>
                        <a href="indexadmin.php?act=suadonhang&order_id=<?php echo $id ?>" class="mb-2"><input
                                class="mb-2 text-bg-secondary rounded" type="button" name="" value="Sửa" id=""></a>
                        <a href="indexadmin.php?act=chitietdh&order_id=<?php echo $id ?>"><input
                                class="mb-2 text-bg-danger rounded" type="button" name="" value="Chi tiết" id=""></a>
                        <a href="indexadmin.php?act=xoapn&id=<?php echo $id ?>"><input
                                class="mb-2 text-bg-success rounded" onclick="return confirm('Bạn có chắc muốn xoá ?')"
                                type="button" name="" value="Xoá" id=""></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="">
        <button type="button" class="btn btn-secondary btn-sm ">Chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Bỏ chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Xoá các mục đã chọn</button>
        <a href="indexadmin.php?act=addpn1">
            <button type="button" class="btn btn-secondary btn-sm">Thêm phiếu nhập</button>
        </a>
    </div>
</div>
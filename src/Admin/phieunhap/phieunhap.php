<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Danh sách phiếu Nhập</h2>

    <form action="indexadmin.php?act=phieunhap" class="mb-4" method="post" enctype="multipart/form-data">
        <div class="row align-items-center">
            <div class="col-md-8">
                <input class="form-control" type="text" placeholder="Tìm kiếm theo tên nhà cung cấp" name="searchSupplier"
                    value="<?= isset($_POST['searchSupplier']) ? $_POST['searchSupplier'] : '' ?>">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-secondary w-100" name="timkiem">Tìm kiếm</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <Th class="text-bg-secondary"></Th>
                    <th class="text-bg-secondary">Mã phiếu nhập</th>
                    <th class="text-bg-secondary">Nhà cung cấp</th>
                    <th class="text-bg-secondary">Nhân viên</th>
                    <Th class="text-bg-secondary">Ngày đặt</Th>
                    <Th class="text-bg-secondary">Trạng thái</Th>
                    <Th class="text-bg-secondary">Thao tác</Th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($listreceipts) && count($listreceipts) > 0) {
                    foreach ($listreceipts as $phieunhap) {
                        extract($phieunhap);
                ?>
                        <tr>
                            <td><input type="checkbox" name="checkbox" id=""></td>
                            <td><?= $id ?></td>
                            <td><?= $supplier_name ?></td>
                            <td><?= $created_by_name ?></td>
                            <td><?= date('d-m-Y', strtotime($receipt_date)) ?></td>
                            <td>
                                <?php
                                switch ($status) {
                                    case 0:
                                        echo '<span class="badge bg-warning">Nháp</span>';
                                        break;
                                    case 1:
                                        echo '<span class="badge bg-success">Đã nhập kho</span>';
                                        break;
                                    case 2:
                                        echo '<span class="badge bg-danger">Đã hủy</span>';
                                        break;
                                    default:
                                        echo '<span class="badge bg-secondary">Không xác định</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="indexadmin.php?act=suapn&id=<?php echo $id ?>" class="mb-2"><input
                                        class="mb-2 text-bg-secondary rounded" type="button" name="" value="Sửa" id=""></a>
                                <a href="indexadmin.php?act=chitietpn&id=<?php echo $id ?>"><input
                                        class="mb-2 text-bg-danger rounded" type="button" name="" value="Chi tiết" id=""></a>
                                <a href="indexadmin.php?act=xoapn&id=<?php echo $id ?>"><input
                                        class="mb-2 text-bg-success rounded" onclick="return confirm('Bạn có chắc muốn xoá ?')"
                                        type="button" name="" value="Xoá" id=""></a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Không có phiếu nhập nào</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="">
        <button type="button" class="btn btn-secondary btn-sm ">Chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Bỏ chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Xoá các mục đã chọn</button>
        <a href="indexadmin.php?act=addpn1">
            <button type="button" class="btn btn-primary btn-sm">Thêm phiếu nhập</button>
        </a>
    </div>
</div>
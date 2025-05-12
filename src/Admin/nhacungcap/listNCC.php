<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Danh sách nhà cung cấp</h2>
    <form action="indexadmin.php?act=ncc" class="mb-4" method="post" enctype="multipart/form-data">
        <div class="row align-items-center">
            <div class="col-md-3">
                <input class="form-control" type="text" placeholder="Tìm kiếm" name="searchNCC"
                    value="<?= isset($_POST['searchNCC']) ? $_POST['searchNCC'] : '' ?>" />
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-secondary text-white">Sắp xếp</span>
                    <select name="sapXepNCC" class="form-select" onchange="this.form.submit()">
                        <option value="id"
                            <?= isset($_POST['sapXepNCC']) && $_POST['sapXepNCC'] == 'id' ? 'selected' : '' ?>>Theo ID
                        </option>
                        <option value="name"
                            <?= isset($_POST['sapXepNCC']) && $_POST['sapXepNCC'] == 'name' ? 'selected' : '' ?>>Theo
                            tên</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-secondary text-white">Thứ tự</span>
                    <select name="thuTu" class="form-select" onchange="this.form.submit()">
                        <option value="asc" <?= isset($_POST['thuTu']) && $_POST['thuTu'] == 'asc' ? 'selected' : '' ?>>
                            A-Z</option>
                        <option value="desc"
                            <?= isset($_POST['thuTu']) && $_POST['thuTu'] == 'desc' ? 'selected' : '' ?>>Z-A</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary w-100" name="timkiem">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <Th class="text-bg-secondary"></Th>
                    <th class="text-bg-secondary">ID</th>
                    <th class="text-bg-secondary">Tên NCC</th>
                    <Th class="text-bg-secondary">Email</Th>
                    <Th class="text-bg-secondary">SĐT</Th>
                    <th class="text-bg-secondary">Địa chỉ</th>
                    <Th class="text-bg-secondary">Thao tác</Th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listNCC as $item) {
                    extract($item);
                    $countsp = loadAllNCC($ncc_id);
                ?>
                <tr>
                    <td><input type="checkbox" name="checkbox" id=""></td>
                    <td><?= $ncc_id ?></td>
                    <td>
                        <?= $ncc_name ?>
                    </td>
                    <td><?= $ncc_email ?></td>
                    <td><?= $ncc_sdt ?></td>
                    <td><?= $ncc_diachi ?></td>

                    <td>
                        <a href="indexadmin.php?act=suaNCC&ncc_id=<?php echo $ncc_id ?>" class="mb-2"><input
                                class="mb-2 text-bg-secondary rounded" type="button" name="" value="Sửa" id=""></a>

                        <a href="indexadmin.php?act=xoaNCC&ncc_id=<?php echo $ncc_id ?>"><input
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
    </div>
</div>
<?php
if (is_array($listNCC)) {
    extract($listNCC);
}
?>

<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Cập nhật nhà cung cấp</h2>
    <div class="container text-bg-light rounded">

        <form action="indexadmin.php?act=updateNCC" method="post">
            <div class="mb-3 mt-3">
                <!-- <label for="kh_id " class="form-label text-danger">Id NCC:</label> -->
                <input type="hidden" class="form-control" id="ncc_id " placeholder="ID nhà cung cấp"
                    value="<?= $ncc_id ?>" name="ncc_id" readonly>
            </div>
            <div class="mb-3 mt-3">
                <label for="kh_name" class="form-label text-danger">Tên nhà cung cấp:</label>
                <input type="text" class="form-control" id="ncc_name" placeholder="Tên nhà cung cấp"
                    value="<?= $ncc_name ?>" name="ncc_name">
            </div>
            <div class="mb-3 mt-3">
                <label for="kh_mail" class="form-label text-danger">Email:</label>
                <input type="email" class="form-control" id="ncc_mail" placeholder="Email" value="<?= $ncc_email ?>"
                    name="ncc_email">
            </div>
            <div class="mb-3 mt-3">
                <label for="kh_tel" class="form-label text-danger">Số điện thoại:</label>
                <input type="tel" class="form-control" id="ncc_tel" placeholder="Số điện thoại" value="<?= $ncc_sdt ?>"
                    name="ncc_tel">
            </div>
            <div class="mb-3 mt-3">
                <label for="kh_address" class="form-label text-danger">Địa chỉ:</label>
                <input type="text" class="form-control" id="ncc_address" placeholder="Địa chỉ"
                    value="<?= $ncc_diachi ?>" name="ncc_address">
            </div>


            <div class="mb-3 mt-3">
                <button type="submit" class="btn btn-secondary btn-sm" name="update">Cập nhật</button>
                <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                <a href="indexadmin.php?act=ncc">
                    <button type="button" class="btn btn-secondary btn-sm">Danh sách nhà cung cấp</button>
                </a>
            </div>
        </form>
    </div>
</div>
<!-- main -->
<div class="container">
        <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Thêm màu</h2>
        <div class="container text-bg-light rounded">

            <form action="indexadmin.php?act=addbrand" method="post" enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="tensp" class="form-label text-danger">Tên thương hiệu:</label>
                    <input type="text" class="form-control" id="tensp" placeholder="Tên brand" name="brand_name">
                </div>
                <div class="mb-3 mt-3">
                    <label for="giasp" class="form-label text-danger">Mô tả</label>
                    <input type="text" class="form-control" id="giasp" placeholder="" name="mo_ta">
                </div>

                <div class="">
                    <button type="submit" class="btn btn-secondary btn-sm" name="addbrand">Thêm thương hiệu</button>
                    <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                    <a href="indexadmin.php?act=thuonghieu">
                        <button type="button" class="btn btn-secondary btn-sm">Danh sách thương hiệu</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
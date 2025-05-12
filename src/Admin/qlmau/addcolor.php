<!-- main -->
<div class="container">
        <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Thêm màu</h2>
        <div class="container text-bg-light rounded">

            <form action="indexadmin.php?act=addcolor" method="post" enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="tensp" class="form-label text-danger">Tên màu:</label>
                    <input type="text" class="form-control" id="tensp" placeholder="Tên màu" name="color_name">
                </div>
                <div class="mb-3 mt-3">
                    <label for="giasp" class="form-label text-danger">Mã màu</label>
                    <input type="text" class="form-control" id="giasp" placeholder="Mã màu" name="color_ma">
                </div>

                <div class="">
                    <button type="submit" class="btn btn-secondary btn-sm" name="addcolor">Thêm sản phẩm</button>
                    <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                    <a href="indexadmin.php?act=color">
                        <button type="button" class="btn btn-secondary btn-sm">Danh sách màu</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
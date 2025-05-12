<!-- main -->
<div class="container">
        <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Cập nhật thương hiệu</h2>
        <div class="container text-bg-light rounded">

            <form action="indexadmin.php?act=updatebrand" method="post" enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="tensp" class="form-label text-danger">Tên thương hiệu:</label>
                    <input type="text" class="form-control" id="tensp" placeholder="Tên thương hiệu" name="ten_thuong_hieu" value="<?php echo $brand_one['ten_thuong_hieu']?>">
                    <input type="text" class="form-control" id="tensp" placeholder="id" name="id" value="<?php echo $brand_one['id']?>" hidden>
                </div>
               
                <div class="mb-3 mt-3">
                    <label for="giasp" class="form-label text-danger">Mô tả</label>
                    <input type="text" class="form-control" id="giasp" placeholder="Giá sản phẩm" name="mo_ta" value="<?php echo $brand_one['mo_ta']?>" >
                </div>

                <div class="">
                    <button type="submit" class="btn btn-secondary btn-sm" name="updatebrd">Cập nhật sản phẩm</button>
                    <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                    <a href="indexadmin.php?act=thuonghieu">
                        <button type="button" class="btn btn-secondary btn-sm">Danh sách thương hiệu</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
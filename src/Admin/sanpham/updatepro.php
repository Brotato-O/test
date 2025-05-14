<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Cập nhật sản phẩm</h2>
    <div class="container text-bg-light rounded">

        <form action="indexadmin.php?act=updatepro" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
            <div class="mb-3 mt-3">
                <label for="tensp" class="form-label text-danger">Tên sản phẩm:</label>
                <input type="text" class="form-control" id="tensp" placeholder="Tên sản phẩm" name="pro_name" value="<?php echo $pro_one['pro_name'] ?>">
                <input type="text" class="form-control" id="tensp" placeholder="Tên sản phẩm" name="pro_id" value="<?php echo $pro_one['pro_id'] ?>" hidden>
            </div>
            <div class="mb-3 mt-3">
                <label for="danhmuc" class="form-label text-danger">Danh mục sản phẩm:</label>
                <?php
                $cate = query_allcate();

                ?>
                <select class="form-select" id="danhmuc" name="cate_id">
                    <?php
                    foreach ($cate as $cateop) {
                    ?>
                        <option value="<?php echo $cateop['cate_id'] ?>" <?php
                                                                            if ($cateop['cate_id'] == $pro_one['cate_id']) {
                                                                                echo "selected";
                                                                            }


                                                                            ?>> <?php echo $cateop['cate_name'] ?></option>
                    <?php
                    }
                    ?>

                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="brand" class="form-label text-danger">Brand:</label>
                <?php
                $brands = query_allbrand(); // gọi hàm lấy danh sách brand
                ?>
                <select class="form-select" id="brand" name="pro_brand">
                    <?php
                    foreach ($brands as $br) {
                    ?>
                        <option value="<?php echo $br['ten_thuong_hieu']; ?>" <?php if ($br['ten_thuong_hieu'] == $pro_one['pro_brand']) echo "selected"; ?>>
                            <?php echo $br['ten_thuong_hieu']; ?>
                        </option>


                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3 mt-3">
                <label for="giasp" class="form-label text-danger">Giá sản phẩm:</label>
                <input type="text" class="form-control" id="giasp" placeholder="Giá sản phẩm" name="pro_price" value="<?php echo $pro_one['pro_price'] ?>">
            </div>


            <div class="mb-3 mt-3">
                <label for="mota" class="text-danger">Mô tả:</label>
                <textarea class="form-control" rows="3" id="mota" name="pro_mota" value=""><?php echo $pro_one['pro_desc'] ?></textarea>
            </div>
            <div class="mb-3 mt-3">
                <label for="anh" class="form-label text-danger">Ảnh:</label>
                <img src="./sanpham/img/<?php echo $pro_one['pro_img'] ?>" alt="" class="w-25">
                <input type="file" class="form-control" id="anh" name="pro_img">
            </div>

            <div class="">
                <button type="submit" class="btn btn-secondary btn-sm" name="updatesp">Cập nhật sản phẩm</button>
                <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                <a href="indexadmin.php?act=pro">
                    <button type="button" class="btn btn-secondary btn-sm">Danh sách sản phẩm</button>
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function validateForm() {
        const name = document.getElementById("tensp").value.trim();

        const price = document.getElementById("giasp").value.trim();
        const image = document.getElementById("anh").value;

        if (name === "") {
            alert("Vui lòng nhập tên sản phẩm.");
            return false;
        }

        if (price === "" || isNaN(price) || parseFloat(price) <= 0) {
            alert("Giá sản phẩm phải là số dương.");
            return false;
        }

        // Khi cập nhật, không bắt buộc phải chọn lại ảnh
        // Nếu bạn muốn bắt buộc ảnh trong trường hợp tạo mới, có thể dùng cờ phân biệt hành động

        return true; // Hợp lệ
    }
</script>
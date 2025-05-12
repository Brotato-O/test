<!-- main -->
<div class="container">
        <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Thêm màu</h2>
        <div class="container text-bg-light rounded">

            <form action="indexadmin.php?act=addvt" method="post" enctype="multipart/form-data">
                <div class="mb-3 mt-3">
                    <label for="tensp" class="form-label text-danger">Tên vai trò:</label>
                    <input type="text" class="form-control" id="tensp" placeholder="Tên vai trò" name="vaitro_name">
                </div>
                

                <div class="">
                    <button type="submit" class="btn btn-secondary btn-sm" name="addvt">Thêm vai trò</button>
                    <button type="reset" class="btn btn-secondary btn-sm">Nhập lại</button>
                    <a href="indexadmin.php?act=vaitro">
                        <button type="button" class="btn btn-secondary btn-sm">Danh sách vai trò</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
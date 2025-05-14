<!-- main -->
<div class="container">
    <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded">Danh sách sản phẩm</h2>
    <form action="indexadmin.php?act=search" method="post">
        <div class="row">
            <div class="col-sm-4">
                <input class="w-100 p-1" type="text" placeholder="Tìm kiếm theo tên" name="search_name">
            </div>
            <div class="col-sm-4">
                <select class="form-select" name="search_cate">
                    <option value="0">Tất Cả</option>
                    <?php
                    $allcate = query_allcate();
                    foreach ($allcate as $cate) {
                    ?>
                    <option value="<?php echo $cate['cate_id'] ?>"><?= $cate['cate_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="col-sm-4">
                <button type="submit" name='searchprocate' class="btn btn-secondary w-50">Tìm kiếm</button>
            </div>
        </div>
    </form>
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <Th class="text-bg-secondary"></Th>
                    <th class="text-bg-secondary">Mã sản phẩm</th>
                    <th class="text-bg-secondary">Ảnh sản phẩm</th>
                    <th class="text-bg-secondary">Tên sản phẩm</th>
                    <Th class="text-bg-secondary">Danh mục</Th>
                    <Th class="text-bg-secondary">Giá</Th>
                    <Th class="text-bg-secondary">Brand</Th>
                    <Th class="text-bg-secondary">Tồn kho</Th>
                    <Th class="text-bg-secondary">Thao tác</Th>
                </tr>
            </thead>
            <?php
            // Phân trang
            $items_per_page = 7; // 7 sản phẩm mỗi trang
            $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $current_page = max(1, $current_page); // Đảm bảo trang hiện tại ít nhất là 1
            $offset = ($current_page - 1) * $items_per_page;

            // Lấy dữ liệu sản phẩm theo phân trang
            if (isset($_POST['searchprocate'])) {
                $search_name = $_POST['search_name'];
                $search_cate = $_POST['search_cate'];
                $result_pro = queryallpro($search_name, $search_cate, $offset, $items_per_page);
                $total_products = count_products($search_name, $search_cate);
                if (empty($result_pro)) {
                    echo "Danh Mục Này Chưa Có Sản Phẩm Xin Mời Bạn Thực Hiện Tùy Chọn Khác";
                }
            } else {
                $result_pro = queryallpro('', 0, $offset, $items_per_page);
                $total_products = count_products('', 0);
            }

            $total_pages = ceil($total_products / $items_per_page);

            // Hiển thị sản phẩm
            foreach ($result_pro as $product) {
                extract($product);
                $result_cateone = query_onecate($cate_id);
                // Lấy tổng tồn kho của sản phẩm
                $inventory = get_total_inventory($pro_id);
            ?>
            <tbody>
                <tr>
                    <td><input type="checkbox" name="checkbox" id=""></td>
                    <td><?php echo $pro_id ?></td>
                    <td><img src="./sanpham/img/<?php echo $pro_img ?>" class="w-50 mg-thumbnail h-50" alt=""></td>
                    <td><?php echo $pro_name ?></td>
                    <td><?php echo $result_cateone['cate_name'] ?></td>
                    <td><?php echo $pro_price ?></td>
                    <td><?php echo $pro_brand ?></td>
                    <td><?php echo $inventory ?></td>


                    <td>
                        <a href="indexadmin.php?act=suapro&pro_idsua=<?php echo $pro_id ?>" class="mb-2"><input
                                class="mb-2 text-bg-secondary rounded" type="button" name="" value="Sửa" id=""></a>
                        <a href="indexadmin.php?act=delpro&pro_idxoa=<?php echo $pro_id ?>"><input type="button" name=""
                                class="mb-2 text-bg-danger rounded" value="Xoá cứng"
                                onclick="return confirm('Bạn có chắc muốn xoá ?')" id=""></a>
                        <a href="indexadmin.php?act=soft_delpro&pro_idxoa=<?php echo $pro_id ?>"><input type="button"
                                name="" class="mb-2 text-bg-success rounded" value="Xoá mềm"
                                onclick="return confirm('Bạn có chắc muốn xoá ?')" id=""></a>
                        <a href="indexadmin.php?act=chitietadmin&pro_id=<?php echo $pro_id ?>"><input type="button"
                                class="mb-2 text-bg-primary rounded" name="" value="Chi Tiết" id=""></a>
                    </td>
                </tr>

            </tbody>
            <?php
            }
            ?>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($total_products > $items_per_page): ?>
    <div class="d-flex justify-content-center mt-4 mb-4">
        <nav aria-label="Điều hướng trang">
            <ul class="pagination">
                <?php if ($current_page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="indexadmin.php?act=pro&page=<?php echo $current_page - 1; ?>"
                        aria-label="Trước">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                    <a class="page-link" href="indexadmin.php?act=pro&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="indexadmin.php?act=pro&page=<?php echo $current_page + 1; ?>"
                        aria-label="Tiếp">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <?php endif; ?>

    <div class="">
        <button type="button" class="btn btn-secondary btn-sm ">Chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Bỏ chọn tất cả</button>
        <button type="button" class="btn btn-secondary btn-sm">Xoá các mục đã chọn</button>
        <a href="indexadmin.php?act=thungrac_product">
            <button type="button" class="btn btn-secondary btn-sm">Thùng rác</button>
        </a>
        <a href="indexadmin.php?act=thempro">
            <button type="button" class="btn btn-secondary btn-sm">Thêm sản phẩm</button>
        </a>
    </div>
</div>
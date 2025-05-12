<div class="row justify-content-center g-3">
    <form method="GET" id="limitForm" class="mb-3 text-center">
        <input type="hidden" name="act" value="productstrending"> <!-- giữ act -->
        <select name="limit" onchange="document.getElementById('limitForm').submit()">
            <?php
            $selectedLimit = isset($_GET['limit']) ? $_GET['limit'] : 6;
            $options = [6, 9, 12];
            foreach ($options as $option) {
                $selected = ($option == $selectedLimit) ? 'selected' : '';
                echo "<option value='$option' $selected>$option sản phẩm/trang</option>";
            }
            ?>
        </select>
    </form>



    <div class="col-12 col-md-12">
        <h2 class="text-center text-capitalize fw-bold mb-5">Products Trending <i class="fa fa-heart text-danger"
                aria-hidden="true"></i></h2>
        <div class="row gx-3 gy-5 justify-content-between">
            <?php

            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $page = max(1, $page);
                if ($page < 1) $page = 1;
            $offset = ($page - 1) * $limit;

            $trendingProducts = trending_products($limit, $offset);

             // Đếm tổng số sản phẩm để tính số trang
            $total_products = countTrendingProducts();
            $total_pages = ceil($total_products / $limit);

            foreach ($trendingProducts as  $trendingProduct) {
                extract($trendingProduct);
            ?>
            <div class="col-6 col-lg-3 col-md-4 user-select-none animate__animated animate__zoomIn">
                <div class="product-image">
                    <a href="index.php?act=productinformation&pro_id=<?php echo $pro_id ?>" class="product-link">
                        <img style="width:300px;height:400px" class="card-img-top rounded-4 "
                            src="./Admin/sanpham/img/<?php echo $pro_img ?>" alt="Card image cap">
                    </a>
                </div>
                <div class="card-body">
                    <a class="card-title two-line-clamp my-3 fs-6 text-dark text-decoration-none"
                    href="index.php?act=productinformation&pro_id=<?= $pro_id ?>">
                    <?php echo $pro_name; ?>
                    </a>

                    <div class="d-flex align-items-center justify-content-between px-2">
                        <p class="card-text fw-bold fs-2 mb-0">$<?php echo $pro_price ?></p>
                        <p class="text-secondary ps-2 mt-3">by <?php echo $pro_brand ?></p>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
    <?php if ($total_pages > 1): ?>
        <div class="col-12 d-flex justify-content-center mt-4">
            <div class="pagination">
                <?php
                // Gộp $_GET với act=productstrending để dùng cho phân trang
                $baseUrl = 'index.php?' . http_build_query(array_merge($_GET, ['act' => 'productstrending']));
                ?>

                <?php if ($page > 1): ?>
                    <a href="<?= $baseUrl ?>&page=<?= $page - 1 ?>">Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <span style="margin: 0 5px; background-color: #007bff; color: white; padding: 5px 10px; border-radius: 5px;"><?= $i ?></span>
                    <?php else: ?>
                        <a href="<?= $baseUrl ?>&page=<?= $i ?>" style="margin: 0 5px; padding: 5px 10px;"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="<?= $baseUrl ?>&page=<?= $page + 1 ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>


        


        </div>
    </div>
</div>
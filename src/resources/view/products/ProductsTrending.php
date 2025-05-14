<div class="row justify-content-center g-3">
    <div class="col-12 col-md-12">
        <h2 class="text-center text-capitalize fw-bold mb-5">Products Trending <i class="fa fa-heart text-danger"
                aria-hidden="true"></i></h2>
        <div class="row gx-3 gy-5 justify-content-between">
            <?php
            // Pagination configuration
            $products_per_page = 12; // Number of products per page
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
            if ($page < 1) $page = 1;
            $offset = ($page - 1) * $products_per_page;

            // Get products with pagination
            $trendingProducts = trending_products($offset, $products_per_page);
            $total_products = count_trending_products();

            foreach ($trendingProducts as $trendingProduct) {
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
                        <a class="card-title two-line-clamp my-3 fs-6 text-dark text-decoration-none "
                            href="index.php?act=productinformation&pro_id=<?= $pro_id ?>"
                            class="product-link"><?php echo $pro_name; ?></a>
                        <div class="d-flex align-items-center justify-content-between px-2">
                            <p class="card-text fw-bold fs-2 mb-0">$<?php echo $pro_price ?></p>
                            <p class="text-secondary ps-2 mt-3">by <?php echo $pro_brand ?></p>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <?php
        // Display pagination
        $total_pages = ceil($total_products / $products_per_page);
        if ($total_pages > 1) {
        ?>
            <div class="pagination-container mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?act=productstrending&page=<?php echo $page - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="index.php?act=productstrending&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="index.php?act=productstrending&page=<?php echo $page + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        <?php } ?>
    </div>
</div>
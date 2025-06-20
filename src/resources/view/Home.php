<div class="row justify-content-center g-3">
    <div class="col-3 d-none d-md-block ">
        <div class="list-group">
            <div class="list-group-item text-capitalize bg-dark text-white">
                Danh mục
            </div>
            <a href="javascript:void(0);" class="list-group-item text-capitalize category-link active bg-info"
                data-category-id="0">
                Tất cả sản phẩm
            </a>
            <?php
            $categories = query_allcate();
            if (count($categories)) {
                foreach ($categories as $category) {
            ?>
            <a href="javascript:void(0);" class="list-group-item text-capitalize category-link text-dark"
                data-category-id="<?php echo $category['cate_id']; ?>">
                <?php echo $category['cate_name']; ?>
            </a>
            <?php
                }
            }
            ?>
        </div>

        <div class="form-group mt-4 mb-4">
            <label for="select-filter">Lọc theo</label>
            <select class="form-control select-filter" id="select-filter">
                <option value="0">-- Lọc theo --</option>
                <option value="asc">Chữ cái từ A-Z</option>
                <option value="desc">Chữ cái từ Z-A</option>
                <option value="price_asc">Giá tăng dần</option>
                <option value="price_desc">Giá giảm dần</option>
            </select>
        </div>

        <div class="form-group mt-4 mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="start_price">Giá từ:</label>
                    <input type="text" id="start_price" name="start_price" value="<?php if (isset($_GET['start_price'])) {
                                                                                        echo $_GET['start_price'];
                                                                                    }  ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="end_price">Cho đến:</label>
                    <input type="text" id="end_price" name="end_price" value="<?php if (isset($_GET['end_price'])) {
                                                                                    echo $_GET['end_price'];
                                                                                }  ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="">Click me</label>
                    <button type="button" id="filter-price-btn" class="btn btn-primary px-4">Lọc</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-9">
        <!-- <div class="row gx-3 gy-5" id="products-container">
            <?php
            // Pagination configuration
            $products_per_page = 9; // Number of products per page
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
            if ($page < 1) $page = 1;
            $offset = ($page - 1) * $products_per_page;

            // Ưu tiên tìm kiếm nếu có searchProduct
            if (isset($_GET['searchSubmit']) && isset($_GET['searchProduct'])) {
                $searchProduct = $_GET["searchProduct"];
                $searchCategory = isset($_GET['category']) ? (int)$_GET['category'] : 0;
                $searchProducts = loadAll_products($searchProduct, $searchCategory);
                if ($searchProducts && count($searchProducts) > 0) {
                    foreach ($searchProducts as $searchPro) : ?>
            <div class="col-12 col-lg-4 col-md-6 user-select-none animate__animated animate__zoomIn">
                <div class="product-image">
                    <a href="index.php?act=productinformation&pro_id=<?php echo $searchPro['pro_id'] ?>">
                        <img class="card-img-top rounded-4 "
                            src="./Admin/sanpham/img/<?php echo $searchPro['pro_img'] ?>" alt="Card image cap">
                    </a>
                </div>
                <div class="card-body">
                    <a class="card-title two-line-clamp my-3 fs-6 text-dark text-decoration-none "
                        href="index.php?act=productinformation&pro_id=<?php echo $searchPro['pro_id'] ?>"><?php echo $searchPro['pro_name'] ?></a>
                    <div class="d-flex align-items-center justify-content-between px-2">
                        <p class="card-text fw-bold fs-2 mb-0">$<?php echo $searchPro['pro_price'] ?></p>
                        <p class="text-secondary ps-2 mt-3">by <?php echo $searchPro['pro_brand'] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach;
                } else {
                    echo '<div class="col-12"><p class="text-danger">Không tìm thấy sản phẩm phù hợp!</p></div>';
                }
            } elseif (isset($_GET['category'])) {
                $cate_id = $_GET['category'];
                $products = queryallpro("", $cate_id, $offset, $products_per_page);
                $total_products = count_products("", $cate_id);

                foreach ($products as $product) {
                    extract($product)
            ?>
            <div class="col-12 col-lg-4 col-md-6 user-select-none animate__animated animate__zoomIn">
                <div class="product-image">
                    <a href="index.php?act=productinformation&pro_id=<?php echo $pro_id ?>">
                        <img class="card-img-top rounded-4 " src="./Admin/sanpham/img/<?php echo $pro_img ?>"
                            alt="Card image cap">
                    </a>

                </div>
                <div class="card-body">
                    <a class="card-title two-line-clamp my-3 fs-6 text-dark text-decoration-none "
                        href="index.php?act=productinformation&pro_id=<?php echo $pro_id ?>"><?php echo $pro_name ?></a>
                    <div class="d-flex align-items-center justify-content-between px-2">
                        <p class="card-text fw-bold fs-2 mb-0">$<?php echo $pro_price ?></p>
                        <p class="text-secondary ps-2 mt-3">by <?php echo $pro_brand ?></p>
                    </div>
                </div>
            </div>

            <?php
                }

                // Display pagination for category
                $total_pages = ceil($total_products / $products_per_page);
                if ($total_pages > 1) {
            ?>
            <div class="pagination-container mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="index.php?act=home&category=<?php echo $cate_id ?>&page=<?php echo $page - 1; ?>"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link"
                                href="index.php?act=home&category=<?php echo $cate_id ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="index.php?act=home&category=<?php echo $cate_id ?>&page=<?php echo $page + 1; ?>"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <?php }
            } elseif (isset($_GET['filter'])) { ?>
            <div class="card-body">
                <div class="row">
                    <?php
                    if (isset($_GET['start_price']) && isset($_GET['end_price'])) {
                        $startprice = $_GET['start_price'];
                        $endprice = $_GET['end_price'];

                        $sql = "SELECT * FROM products WHERE pro_price BETWEEN $startprice AND $endprice ORDER BY pro_price ASC";
                    } else {
                        $sql = "SELECT * FROM products ORDER BY pro_price ASC";
                    }

                    $query_run = pdo_queryall($sql);

                    if (count($query_run) > 0) {
                        foreach ($query_run as $items) {
                            // 
                    ?>
                    <div class="col-12 col-lg-4 col-md-6 user-select-none animate__animated animate__zoomIn">
                        <div class="product-image">
                            <a href="index.php?act=productinformation&pro_id=<?php echo $items['pro_id'] ?>">
                                <img class="card-img-top rounded-4 "
                                    src="./Admin/sanpham/img/<?php echo $items['pro_img'] ?>" alt="Card image cap">
                            </a>

                        </div>
                        <div class="card-body">
                            <a class="card-title two-line-clamp my-3 fs-6 text-dark text-decoration-none "
                                href="index.php?act=productinformation&pro_id=<?php echo $items['pro_id'] ?>"><?php echo $items['pro_name'] ?></a>
                            <div class="d-flex align-items-center justify-content-between px-2">
                                <p class="card-text fw-bold fs-2 mb-0">$<?php echo $items['pro_price'] ?></p>
                                <p class="text-secondary ps-2 mt-3">by <?php echo $items['pro_brand'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    } else {
                        echo "No Record Found";
                    }
                    ?>
                </div>
            </div>
            <?php
            } else {
                // Default product listing with pagination
                $products = queryallpro("", 0, $offset, $products_per_page);
                $total_products = count_products("", 0);

                foreach ($products as $product) {
                    extract($product);
            ?>
            <div class="col-12 col-lg-4 col-md-6 user-select-none animate__animated animate__zoomIn">
                <div class="product-image">
                    <a href="index.php?act=productinformation&pro_id=<?php echo $pro_id ?>">
                        <img style="width:300px;height:400px" class="card-img-top rounded-4 "
                            src="./Admin/sanpham/img/<?php echo $pro_img ?>" alt="Card image cap">
                    </a>

                </div>
                <div class="card-body">
                    <a class="card-title two-line-clamp my-3 fs-6 text-dark text-decoration-none "
                        href="index.php?act=productinformation&pro_id=<?= $pro_id ?>"><?php echo $product['pro_name']; ?></a>
                    <div class="d-flex align-items-center justify-content-between px-2">
                        <p class="card-text fw-bold fs-2 mb-0">$<?php echo $pro_price ?></p>
                        <p class="text-secondary ps-2 mt-3">by <?php echo $pro_brand ?></p>
                    </div>
                </div>
            </div>
            <?php
                }

                // Display pagination for default view
                $total_pages = ceil($total_products / $products_per_page);
                if ($total_pages > 1) {
            ?>
            <div class="pagination-container mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?act=home&page=<?php echo $page - 1; ?>"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="index.php?act=home&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="index.php?act=home&page=<?php echo $page + 1; ?>"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <?php
                }
            }
            ?>

        </div> -->
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-md-12"">

                <div class=" row gx-3 gy-5" id="products-container">
                <!-- Sản phẩm sẽ được hiển thị ở đây -->
            </div>

            <label for="products-per-page" class="form-label">Số sản phẩm mỗi trang:</label>
            <select id="products-per-page" class="form-select" style="width: auto; display: inline-block;">
                <option value="6">6</option>
                <option value="9" selected>9</option>
                <option value="12">12</option>
                <option value="15">15</option>
            </select>
        </div>
        <div class="col-md-12 text-end">
            <div id="pagination-container"></div>
        </div>
    </div>
</div>
</div>

<!-- Add JavaScript for AJAX filtering -->
<script>
// Global state to keep track of current filters
let currentFilters = {
    sort: '0',
    startPrice: '',
    endPrice: ''
};

document.addEventListener('DOMContentLoaded', function() {
    const categoryLinks = document.querySelectorAll('.category-link');
    const productsContainer = document.getElementById('products-container');
    const paginationContainer = document.getElementById('pagination-container');
    const productsPerPageSelect = document.getElementById('products-per-page');
    const searchForm = document.getElementById('search-form');
    const searchInput = document.getElementById('searchProduct');
    const searchCategoryInput = document.getElementById('search-category');

    let currentPage = 1;
    let productsPerPage = parseInt(productsPerPageSelect.value);
    let currentCategory = 0; // Mặc định là "Tất cả sản phẩm"
    let currentSearchQuery = ''; // Biến lưu từ khóa tìm kiếm hiện tại

    // Hàm tải sản phẩm
    function loadProducts(page = 1, category = 0, searchQuery = '') {
        const xhr = new XMLHttpRequest();
        let url = '';

        if (searchQuery) {
            // Nếu có từ khóa tìm kiếm, dùng combinedFilter để tìm kiếm và phân trang
            url =
                `index.php?act=combinedFilter&category=${category}&searchProduct=${encodeURIComponent(searchQuery)}&page=${page}&productsPerPage=${productsPerPage}`;
        } else {
            // Nếu không có tìm kiếm, dùng filterByCategory
            url =
                `index.php?act=filterByCategory&category=${category}&page=${page}&productsPerPage=${productsPerPage}`;
        }

        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        let productsHTML = '';

                        response.products.forEach(product => {
                            productsHTML += `
                                <div class="col-12 col-lg-4 col-md-6 user-select-none animate__animated animate__zoomIn">
                                    <div class="product-image">
                                        <a href="index.php?act=productinformation&pro_id=${product.pro_id}">
                                            <img class="card-img-top rounded-4" src="./Admin/sanpham/img/${product.pro_img}" alt="${product.pro_name}">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <a class="card-title two-line-clamp my-3 fs-6 text-dark text-decoration-none" href="index.php?act=productinformation&pro_id=${product.pro_id}">
                                            ${product.pro_name}
                                        </a>
                                        <div class="d-flex align-items-center justify-content-between px-2">
                                            <p class="card-text fw-bold fs-2 mb-0">$${product.pro_price}</p>
                                            <p class="text-secondary ps-2 mt-3">by ${product.pro_brand}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        productsContainer.innerHTML = productsHTML ||
                            '<div class="col-12"><p>Không có sản phẩm nào phù hợp.</p></div>';

                        // Hiển thị phân trang nếu có nhiều hơn 1 trang
                        if (response.totalPages > 1) {
                            renderPagination(response.totalPages, page, searchQuery);
                        } else {
                            paginationContainer.innerHTML = '';
                        }
                    } else {
                        productsContainer.innerHTML =
                            '<div class="col-12 text-center p-5"><p class="text-danger">Không tìm thấy sản phẩm nào!</p></div>';
                        paginationContainer.innerHTML = '';
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    alert('Đã xảy ra lỗi khi xử lý dữ liệu.');
                }
            } else {
                console.error('AJAX Error:', xhr.status);
                alert('Đã xảy ra lỗi khi tải dữ liệu.');
            }
        };

        xhr.onerror = function() {
            console.error('AJAX Network Error');
            alert('Đã xảy ra lỗi mạng.');
        };

        xhr.send();
    }

    // Hàm hiển thị phân trang - cập nhật để hỗ trợ tìm kiếm
    function renderPagination(totalPages, currentPage, searchQuery = '') {
        if (totalPages <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }

        let paginationHTML = '<ul class="pagination justify-content-center">';

        if (currentPage > 1) {
            paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" data-page="${currentPage - 1}">&laquo;</a>
                </li>
            `;
        }

        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0);" data-page="${i}">${i}</a>
                </li>
            `;
        }

        if (currentPage < totalPages) {
            paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" data-page="${currentPage + 1}">&raquo;</a>
                </li>
            `;
        }

        paginationHTML += '</ul>';
        paginationContainer.innerHTML = paginationHTML;

        // Thêm sự kiện click cho các nút phân trang, truyền cả từ khóa tìm kiếm
        const pageLinks = paginationContainer.querySelectorAll('.page-link');
        pageLinks.forEach(link => {
            link.addEventListener('click', function() {
                const page = parseInt(this.getAttribute('data-page'));
                if (page) {
                    currentPage = page;
                    loadProducts(page, currentCategory, currentSearchQuery);
                }
            });
        });
    }

    // Xử lý tìm kiếm
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn form submit thông thường
            const searchText = searchInput.value.trim();
            if (searchText !== '') {
                // Lưu từ khóa tìm kiếm hiện tại
                currentSearchQuery = searchText;
                // Lấy category hiện tại
                currentCategory = parseInt(searchCategoryInput.value || 0);
                // Reset về trang đầu tiên khi tìm kiếm mới
                currentPage = 1;
                // Thực hiện tìm kiếm bằng AJAX
                loadProducts(currentPage, currentCategory, currentSearchQuery);
            }
        });
    }

    // Sự kiện thay đổi danh mục
    categoryLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Lấy ID danh mục từ thuộc tính data-category-id
            const categoryId = parseInt(this.getAttribute('data-category-id'));

            // Xóa class active khỏi tất cả các liên kết danh mục
            categoryLinks.forEach(link => link.classList.remove('active', 'bg-info'));
            // Thêm class active cho danh mục được chọn
            this.classList.add('active', 'bg-info');

            // Cập nhật danh mục hiện tại và tải sản phẩm
            currentCategory = categoryId;
            currentPage = 1; // Reset về trang đầu tiên
            currentSearchQuery = ''; // Xóa từ khóa tìm kiếm khi đổi danh mục

            // Xóa nội dung ô tìm kiếm
            if (searchInput) searchInput.value = '';

            // Tải sản phẩm của danh mục mới
            loadProducts(currentPage, currentCategory);

            // Cập nhật input ẩn category trong form tìm kiếm
            if (searchCategoryInput) {
                searchCategoryInput.value = currentCategory;
            }
        });
    });

    // Sự kiện thay đổi số sản phẩm mỗi trang
    productsPerPageSelect.addEventListener('change', function() {
        productsPerPage = parseInt(this.value);
        currentPage = 1; // Reset về trang đầu tiên
        loadProducts(currentPage, currentCategory);
    });

    // Tải sản phẩm lần đầu
    loadProducts(currentPage, currentCategory);
});

// Filter by dropdown
document.getElementById('select-filter').addEventListener('change', function() {
    const filterValue = this.value;
    currentFilters.sort = filterValue;
    applyFilters();
});

// Validate and filter by price range
document.getElementById('filter-price-btn').addEventListener('click', function() {
    const startPrice = document.getElementById('start_price').value.trim();
    const endPrice = document.getElementById('end_price').value.trim();

    // Validate if at least one field has a value
    if (startPrice === '' && endPrice === '') {
        alert('Vui lòng nhập ít nhất một giá trị giá!');
        return;
    }

    // Validate numeric values
    if ((startPrice !== '' && isNaN(startPrice)) || (endPrice !== '' && isNaN(endPrice))) {
        alert('Giá phải là số!');
        return;
    }

    // Convert to numbers for comparison (only if both are provided)
    const startNum = startPrice === '' ? 0 : parseFloat(startPrice);
    const endNum = endPrice === '' ? Number.MAX_SAFE_INTEGER : parseFloat(endPrice);

    // Check if start price is greater than end price
    if (startPrice !== '' && endPrice !== '' && startNum > endNum) {
        alert('Giá bắt đầu không thể lớn hơn giá kết thúc!');
        return;
    }

    // Update current filters
    currentFilters.startPrice = startPrice;
    currentFilters.endPrice = endPrice;

    // Apply all filters
    applyFilters();
});

// Function to render product HTML
function renderProductHTML(product) {
    return `
    <div class="col-12 col-lg-4 col-md-6 user-select-none animate__animated animate__zoomIn">
        <div class="product-image">
            <a href="index.php?act=productinformation&pro_id=${product.pro_id}">
                <img style="width:300px;height:400px" class="card-img-top rounded-4" 
                    src="./Admin/sanpham/img/${product.pro_img}" alt="Card image cap">
            </a>
        </div>
        <div class="card-body">
            <a class="card-title two-line-clamp my-3 fs-6 text-dark text-decoration-none"
                href="index.php?act=productinformation&pro_id=${product.pro_id}">${product.pro_name}</a>
            <div class="d-flex align-items-center justify-content-between px-2">
                <p class="card-text fw-bold fs-2 mb-0">$${product.pro_price}</p>
                <p class="text-secondary ps-2 mt-3">by ${product.pro_brand}</p>
            </div>
        </div>
    </div>
    `;
}

// Function to handle AJAX error
function handleAjaxError(xhr, status, error) {
    console.error("AJAX Error:", status, error);
    alert("Đã xảy ra lỗi khi tải dữ liệu, vui lòng thử lại.");
}

// Function to apply all current filters
function applyFilters() {
    // Get current category if any
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get('category') || 0;

    // Build URL with all filters
    let url = `index.php?act=combinedFilter&category=${category}`;

    if (currentFilters.sort && currentFilters.sort !== '0') {
        url += `&sort=${currentFilters.sort}`;
    }

    if (currentFilters.startPrice) {
        url += `&start_price=${currentFilters.startPrice}`;
    }

    if (currentFilters.endPrice) {
        url += `&end_price=${currentFilters.endPrice}`;
    }

    // Create AJAX request
    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function() {
        if (this.status === 200) {
            try {
                const response = JSON.parse(this.responseText);
                if (response.success) {
                    const productsContainer = document.getElementById('products-container');
                    let productsHTML = '';

                    response.products.forEach(product => {
                        productsHTML += renderProductHTML(product);
                    });

                    productsContainer.innerHTML = productsHTML ||
                        '<div class="col-12"><p>Không tìm thấy sản phẩm nào phù hợp với điều kiện lọc!</p></div>';
                } else {
                    document.getElementById('products-container').innerHTML =
                        '<div class="col-12 text-center p-5"><p class="text-danger">' +
                        (response.message || 'Không tìm thấy sản phẩm nào phù hợp!') +
                        '</p></div>';
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                alert('Đã xảy ra lỗi khi xử lý dữ liệu, vui lòng thử lại.');
            }
        } else {
            handleAjaxError(this, this.status, 'Server error');
        }
    };

    xhr.onerror = function() {
        handleAjaxError(this, 'network', 'Network error');
    };

    xhr.send();
}

// Filter by dropdown
document.getElementById('select-filter').addEventListener('change', function() {
    const filterValue = this.value;
    currentFilters.sort = filterValue;
    applyFilters();
});

// Validate and filter by price range
document.getElementById('filter-price-btn').addEventListener('click', function() {
    const startPrice = document.getElementById('start_price').value.trim();
    const endPrice = document.getElementById('end_price').value.trim();

    // Validate if at least one field has a value
    if (startPrice === '' && endPrice === '') {
        alert('Vui lòng nhập ít nhất một giá trị giá!');
        return;
    }

    // Validate numeric values
    if ((startPrice !== '' && isNaN(startPrice)) || (endPrice !== '' && isNaN(endPrice))) {
        alert('Giá phải là số!');
        return;
    }

    // Convert to numbers for comparison (only if both are provided)
    const startNum = startPrice === '' ? 0 : parseFloat(startPrice);
    const endNum = endPrice === '' ? Number.MAX_SAFE_INTEGER : parseFloat(endPrice);

    // Check if start price is greater than end price
    if (startPrice !== '' && endPrice !== '' && startNum > endNum) {
        alert('Giá bắt đầu không thể lớn hơn giá kết thúc!');
        return;
    }

    // Update current filters
    currentFilters.startPrice = startPrice;
    currentFilters.endPrice = endPrice;

    // Apply all filters
    applyFilters();
});

// Reset filters button
/*
document.addEventListener('DOMContentLoaded', function() {
    // Add reset button after the price filter
    const filterContainer = document.getElementById('filter-price-btn').parentNode;
    const resetBtn = document.createElement('button');
    resetBtn.type = 'button';
    resetBtn.className = 'btn btn-outline-danger w-100 mt-3 py-2';
    resetBtn.textContent = 'Xóa bộ lọc';
    resetBtn.addEventListener('click', function() {
        // Reset all filters
        document.getElementById('select-filter').value = '0';
        document.getElementById('start_price').value = '';
        document.getElementById('end_price').value = '';

        // Reset current filters object
        currentFilters = {
            sort: '0',
            startPrice: '',
            endPrice: ''
        };

        // Reload the page to show all products
        window.location.href = window.location.pathname +
            (window.location.search.includes('category') ?
                '?act=home&category=' + new URLSearchParams(window.location.search).get('category') :
                '?act=home');
    });

    filterContainer.appendChild(resetBtn);
});
*/
</script>
<div class="container-fluid header bg-light position-fixed top-0 z-3 ">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php?act=home">Auréline</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?act=home">Home</a>
                    </li>
                    <?php if (isset($_SESSION['acount']) && $_SESSION['acount']) {
                        $kh_id = $_SESSION['acount']['kh_id'];
                        $roles = loadone_taikhoan($kh_id);

                    ?>
                    <li class="nav-item">
                        <a class="nav-link active me-1" href="index.php?act=productstrending">Những sản phẩm đang bán
                            chạy nhất. <i class="fa fa-heart text-danger" aria-hidden="true"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-info active me-2" href="index.php?act=myAccount">Tài khoản của tôi</a>
                    </li>
                    <?php if ($roles['vaitro_id'] == 1 || $roles['vaitro_id'] == 3 || $roles['vaitro_id'] == 4) { ?>
                    <!-- <li class="nav-item">
                        <a class="btn btn-info active" href="./Admin/indexadmin.php?act=home">Quản Lý</a>
                    </li> -->
                    <?php } ?>

                    <?php
                    } else { ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?act=login">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?act=register">Đăng kí</a>
                    </li>
                    <li class="nav-item disabled">
                        <a class="btn btn-secondary disabled" href="index.php?act=myAccount">Tài khoản của tôi</a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
                <div class="d-flex">
                    <form class="d-flex me-4" id="searchForm" onsubmit="return false;">
                        <div class="form-group me-2">
                            <input type="text" class="form-control" id="searchProduct" name="searchProduct" placeholder="Tìm kiếm sản phẩm"
                                required>
                        </div>
                        <button type="submit" class="btn btn-outline-dark" id="searchSubmit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <?php
                    if (isset($_SESSION['acount']) && $_SESSION['acount']) {
                    ?>
                    <a href="index.php?act=mycart&kh_id=<?php echo $_SESSION['acount']['kh_id'] ?>"
                        class="position-relative">
                        <button type="button" class="btn btn-outline-dark">
                            <i class="bi bi-bag"></i>
                        </button>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php
                                if (isset($_SESSION['acount']) && $_SESSION['acount']) {
                                    $kh_id = $_SESSION['acount']['kh_id'];
                                    // Lấy ID giỏ hàng của khách hàng
                                    $cart = querycart_kh($kh_id);
                                    if ($cart && isset($cart['cart_id'])) {
                                        $cart_id = $cart['cart_id'];
                                        // Truy vấn tổng số lượng sản phẩm từ bảng cart_chitiet
                                        $sql = "SELECT SUM(soluong) as total_quantity FROM cart_chitiet WHERE cart_id = $cart_id";
                                        $result = pdo_query_one($sql);
                                        $total_quantity = isset($result['total_quantity']) ? $result['total_quantity'] : 0;
                                        echo $total_quantity;
                                    } else {
                                        echo 0;
                                    }
                                } else {
                                    echo 0;
                                }
                                ?>
                        </span>
                    </a>
                    <a href="index.php?act=logout">
                        <button type="button" name="logout" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Logout" class="btn btn-outline-danger ms-4">
                            <i class="bi bi-box-arrow-left me-2"></i>
                            Đăng xuất
                        </button>
                    </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
</div>

<script>
document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const searchTerm = document.getElementById('searchProduct').value.trim();
    
    if (searchTerm === '') {
        alert('Vui lòng nhập từ khóa tìm kiếm!');
        return;
    }

    // Gửi request AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `index.php?act=searchAjax&term=${encodeURIComponent(searchTerm)}`, true);

    xhr.onload = function() {
        if (this.status === 200) {
            try {
                const response = JSON.parse(this.responseText);
                if (response.success) {
                    const productsContainer = document.getElementById('products-container');
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
                                    <a class="card-title two-line-clamp my-3 fs-6 text-dark text-decoration-none" 
                                       href="index.php?act=productinformation&pro_id=${product.pro_id}">
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
                        '<div class="col-12 text-center p-5"><p class="text-danger">Không tìm thấy sản phẩm nào!</p></div>';
                } else {
                    document.getElementById('products-container').innerHTML = 
                        '<div class="col-12 text-center p-5"><p class="text-danger">' + 
                        (response.message || 'Không tìm thấy sản phẩm nào!') + '</p></div>';
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                alert('Đã xảy ra lỗi khi xử lý dữ liệu, vui lòng thử lại.');
            }
        } else {
            console.error('AJAX Error:', this.status);
            alert('Đã xảy ra lỗi khi tải dữ liệu, vui lòng thử lại.');
        }
    };

    xhr.onerror = function() {
        console.error('AJAX Network Error');
        alert('Đã xảy ra lỗi mạng, vui lòng thử lại.');
    };

    xhr.send();
});
</script>
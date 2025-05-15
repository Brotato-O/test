<?php
ob_start();
session_start();
include './app/model/connectdb.php';
include './app/model/product.php';
include './app/model/cate.php';
include './app/model/khachhang.php';
include './app/model/cart.php';
include './app/model/binhluan.php';
include './app/model/color.php';
include './app/model/size.php';
include './app/model/donhang.php';

//Xử lí danh mục ajax
if (isset($_GET['act']) && $_GET['act'] === 'filterByCategory') {
    header('Content-Type: application/json');

    $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : 0;

    // Lấy danh sách sản phẩm theo danh mục
    if ($categoryId === 0) {
        // Lấy tất cả sản phẩm nếu categoryId = 0
        $products = queryallpro("", 0, 0, 100); // Giới hạn 100 sản phẩm
    } else {
        $products = queryallpro("", $categoryId, 0, 100); // Giới hạn 100 sản phẩm
    }

    if ($products) {
        echo json_encode([
            'success' => true,
            'products' => $products
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm nào.'
        ]);
    }

    exit;
}

// Handle AJAX requests for combined filtering (sort + price range)
if (isset($_GET['act']) && $_GET['act'] == 'combinedFilter') {
    header('Content-Type: application/json');

    // Get all filter parameters
    $sort = $_GET['sort'] ?? '';
    $startPrice = isset($_GET['start_price']) && $_GET['start_price'] !== '' ? (float)$_GET['start_price'] : null;
    $endPrice = isset($_GET['end_price']) && $_GET['end_price'] !== '' ? (float)$_GET['end_price'] : null;
    $category = isset($_GET['category']) ? (int)$_GET['category'] : 0;

    try {
        $sql = "SELECT * FROM products WHERE trangthai = 0";

        // Add category filter
        if ($category > 0) {
            $sql .= " AND cate_id = $category";
        }

        // Add price range filter if either or both prices are provided
        if ($startPrice !== null && $endPrice !== null) {
            $sql .= " AND pro_price BETWEEN $startPrice AND $endPrice";
        } elseif ($startPrice !== null) {
            $sql .= " AND pro_price >= $startPrice";
        } elseif ($endPrice !== null) {
            $sql .= " AND pro_price <= $endPrice";
        }

        // Add sorting
        if ($sort == 'asc') {
            $sql .= " ORDER BY pro_name ASC";
        } elseif ($sort == 'desc') {
            $sql .= " ORDER BY pro_name DESC";
        } elseif ($sort == 'price_asc') {
            $sql .= " ORDER BY pro_price ASC";
        } elseif ($sort == 'price_desc') {
            $sql .= " ORDER BY pro_price DESC";
        } else {
            $sql .= " ORDER BY pro_id DESC";
        }

        $products = pdo_queryall($sql);

        if ($products && count($products) > 0) {
            echo json_encode([
                'success' => true,
                'products' => $products
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm nào phù hợp với các tiêu chí lọc.'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi khi truy vấn dữ liệu: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Handle AJAX requests for filtering products
if (isset($_GET['act']) && $_GET['act'] == 'filterProducts') {
    header('Content-Type: application/json');
    $sort = $_GET['sort'] ?? '';
    $category = isset($_GET['category']) ? (int)$_GET['category'] : 0;

    try {
        $sql = "SELECT * FROM products WHERE trangthai = 0";

        if ($category > 0) {
            $sql .= " AND cate_id = $category";
        }

        // Add sorting
        if ($sort == 'asc') {
            $sql .= " ORDER BY pro_name ASC";
        } elseif ($sort == 'desc') {
            $sql .= " ORDER BY pro_name DESC";
        } elseif ($sort == 'price_asc') {
            $sql .= " ORDER BY pro_price ASC";
        } elseif ($sort == 'price_desc') {
            $sql .= " ORDER BY pro_price DESC";
        } else {
            $sql .= " ORDER BY pro_id DESC";
        }

        $products = pdo_queryall($sql);

        if ($products && count($products) > 0) {
            echo json_encode([
                'success' => true,
                'products' => $products
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm nào.'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi khi truy vấn dữ liệu: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Handle AJAX requests for filtering products by price range
if (isset($_GET['act']) && $_GET['act'] == 'filterByPrice') {
    header('Content-Type: application/json');
    $startPrice = isset($_GET['start_price']) && $_GET['start_price'] !== '' ? (float)$_GET['start_price'] : 0;
    $endPrice = isset($_GET['end_price']) && $_GET['end_price'] !== '' ? (float)$_GET['end_price'] : PHP_INT_MAX;
    $category = isset($_GET['category']) ? (int)$_GET['category'] : 0;

    try {
        $sql = "SELECT * FROM products WHERE trangthai = 0 AND pro_price BETWEEN $startPrice AND $endPrice";

        if ($category > 0) {
            $sql .= " AND cate_id = $category";
        }

        $sql .= " ORDER BY pro_price ASC";

        $products = pdo_queryall($sql);

        if ($products && count($products) > 0) {
            echo json_encode([
                'success' => true,
                'products' => $products
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm nào trong khoảng giá này.'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi khi truy vấn dữ liệu: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Handle AJAX search requests
if (isset($_GET['act']) && $_GET['act'] == 'searchAjax') {
    header('Content-Type: application/json');
    
    $searchTerm = isset($_GET['term']) ? trim($_GET['term']) : '';
    
    if (empty($searchTerm)) {
        echo json_encode([
            'success' => false,
            'message' => 'Vui lòng nhập từ khóa tìm kiếm!'
        ]);
        exit;
    }

    try {
        // Sử dụng hàm loadAll_products có sẵn để tìm kiếm
        $products = loadAll_products($searchTerm, 0);
        
        if ($products && count($products) > 0) {
            echo json_encode([
                'success' => true,
                'products' => $products
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm nào phù hợp với từ khóa "' . htmlspecialchars($searchTerm) . '"'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi khi tìm kiếm sản phẩm: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Handle AJAX login requests
if (isset($_GET['act']) && $_GET['act'] == 'loginAjax') {
    header('Content-Type: application/json');
    
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    if (empty($email)) {
        echo json_encode([
            'success' => false,
            'message' => 'Vui lòng nhập email!'
        ]);
        exit;
    }
    
    if (empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Vui lòng nhập mật khẩu!'
        ]);
        exit;
    }

    try {
        $checkuser = check_user($email, $password);
        
        if (is_array($checkuser)) {
            if ($checkuser['vaitro_id'] == 2 && $checkuser['trangthai'] == 0) {
                $_SESSION['acount'] = $checkuser;
                echo json_encode([
                    'success' => true,
                    'message' => 'Đăng nhập thành công!',
                    'redirect' => 'index.php?act=home'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Tài khoản không có quyền truy cập!'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không chính xác!'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi khi đăng nhập: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Handle AJAX register requests
if (isset($_GET['act']) && $_GET['act'] == 'registerAjax') {
    header('Content-Type: application/json');
    
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $rePassword = isset($_POST['re-password']) ? trim($_POST['re-password']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    
    $errors = [];
    
    // Validate username
    if (empty($username)) {
        $errors['username'] = 'Vui lòng nhập tên đăng nhập!';
    } elseif (!preg_match('/^[a-zA-Z ]+$/', $username)) {
        $errors['username'] = 'Tên đăng nhập chỉ được chứa chữ cái và khoảng trắng!';
    }
    
    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Vui lòng nhập email!';
    } elseif (!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $errors['email'] = 'Email không hợp lệ!';
    } else {
        $checkmail = check_email($email);
        if (is_array($checkmail)) {
            $errors['email'] = 'Email đã được sử dụng!';
        }
    }
    
    // Validate phone
    if (empty($phone)) {
        $errors['phone'] = 'Vui lòng nhập số điện thoại!';
    } elseif (!preg_match('/^(0|\+84)(3[2-9]|5[2689]|7[06789]|8[1-689]|9[0-9])[0-9]{7}$/', $phone)) {
        $errors['phone'] = 'Số điện thoại không hợp lệ!';
    }
    
    // Validate address
    if (empty($address)) {
        $errors['address'] = 'Vui lòng nhập địa chỉ!';
    }
    
    // Validate password
    if (empty($password)) {
        $errors['password'] = 'Vui lòng nhập mật khẩu!';
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*]).{6,}$/', $password)) {
        $errors['password'] = 'Mật khẩu phải chứa chữ hoa, chữ thường, số và ký tự đặc biệt, tối thiểu 6 ký tự!';
    }
    
    // Validate re-password
    if (empty($rePassword)) {
        $errors['re-password'] = 'Vui lòng nhập lại mật khẩu!';
    } elseif ($rePassword !== $password) {
        $errors['re-password'] = 'Mật khẩu nhập lại không khớp!';
    }
    
    if (empty($errors)) {
        try {
            addkh($password, $username, $email, $phone, $address);
            
            // Lấy thông tin khách hàng vừa đăng ký
            $sql = "SELECT * FROM khachhang WHERE kh_id = (SELECT MAX(kh_id) FROM khachhang)";
            $khachhang = pdo_query_one($sql);
            
            // Tạo giỏ hàng cho khách hàng mới
            addcart_kh($khachhang['kh_id'], 0);
            
            echo json_encode([
                'success' => true,
                'message' => 'Đăng ký thành công! Vui lòng đăng nhập.',
                'redirect' => 'index.php?act=login'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi đăng ký: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="resources/css/global.css">
    <!-- <link rel="stylesheet" href="../../resources/css/global.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="app">
        <?php include('./resources/view/Header.php') ?>
        <div class="content">
            <div class="container">
                <?php
                if (isset($_GET['act'])) {
                    $pageLayout = $_GET['act'];
                    switch ($pageLayout) {
                        case 'home':
                            include('./resources/view/Home.php');
                            break;
                        case 'productinformation':
                            include './resources/view/products/ProductInformation.php';
                            break;
                        case 'productstrending':
                            include './resources/view/products/ProductsTrending.php';
                            break;
                        case 'login':
                            include './resources/view/account/login.php';
                            break;
                        case 'register':
                            include './resources/view/account/register.php';
                            break;
                        case 'logout':
                            include './resources/view/account/logout.php';
                            header("Location:index.php");
                            break;
                        case 'myAccount':
                            include './resources/view/account/myAccount.php';
                            break;
                        case 'updateAccount':
                            include './resources/view/account/update.php';
                            break;

                        case 'forgetPassword':
                            include './resources/view/account/forgetPass.php';
                            break;
                        case 'mycart':
                            include './resources/view/cart/viewcart.php';
                            break;
                        case 'addcart':
                            if (isset($_POST['addtocart'])) {
                                include './resources/view/cart/addcart.php';
                            }
                            if (isset($_POST['buy'])) {
                                include './resources/view/cart/checkoutone.php';
                            }
                            break;
                        case 'del_procart':
                            include './resources/view/cart/delcart.php';
                            break;
                        case 'updatecart':
                            include './resources/view/cart/viewupdatecart.php';
                            break;
                        case 'update_cart':
                            include './resources/view/cart/UpdateCart.php';
                            break;

                        case 'checkout':
                            include './resources/view/cart/Checkout.php';
                            break;
                        case 'order':
                            include './resources/view/cart/order.php';
                            break;
                        case 'orderone':
                            include './resources/view/cart/orderone.php';
                            break;
                        case 'simple_payment':
                            include './resources/view/cart/simple_payment.php';
                            break;
                        case 'cancel_payment':
                            include './resources/view/cart/cancel_payment.php';
                            break;
                        case 'cancel_order':
                            include './resources/view/cart/cancel.php';
                            break;
                        case 'myAccountchitiet':
                            include './resources/view/account/myacountchitiet.php';
                            break;
                        case 'addlike':
                            if (isset($_POST['like'])) {
                                $proid = $_POST['pro_id'];
                                $khid = $_POST['kh_id'];
                                addProductToFavourite($khid, $proid);
                                header("Location:index.php?act=productinformation&pro_id=" . $proid);
                            }
                            break;
                        case 'deleteFavourite':
                            include './resources/view/account/DeleteFavourite.php';
                            break;
                    }
                } else {
                    include('./resources/view/Home.php');
                }
                ?>
            </div>
        </div>
        <?php include('./resources/view/Footer.php') ?>
    </div>

    <!-- Load jQuery before Bootstrap -->
      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> <!-- Keep this -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="./resources/js/ValidateFormUpdate.js"></script>
    <script src="./resources/js/ValidateFormForget.js"></script>
    <script src="./resources/js/notifi.js"></script>
</body>

</html>
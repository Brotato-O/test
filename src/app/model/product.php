<?php



function queryallpro($key, $idcate, $offset = null, $limit = null)
{
    $sql = "select * from products where trangthai = 0";
    if ($key != '') {
        $sql .= " and pro_name like '%$key%'";
    }
    if ($idcate > 0) {
        $sql .= " and cate_id = $idcate";
    }

    $sql .= " order by pro_id desc";

    // Add pagination if offset and limit are provided
    if ($offset !== null && $limit !== null) {
        $sql .= " limit $offset, $limit";
    }

    $result = pdo_queryall($sql);
    return $result;
}

// Hàm lấy danh sách sản phẩm với các tùy chọn sắp xếp
function queryallpro_with_sorting($key, $idcate, $sort_by = 'id', $sort_order = 'asc', $offset = null, $limit = null)
{
    try {
        // Xây dựng câu truy vấn SQL
        $sql = "SELECT p.*, c.cate_name FROM products p 
                LEFT JOIN category c ON p.cate_id = c.cate_id 
                WHERE p.trangthai = 0";

        if ($key != '') {
            $sql .= " AND p.pro_name LIKE '%$key%'";
        }

        if ($idcate > 0) {
            $sql .= " AND p.cate_id = $idcate";
        }

        // Sắp xếp theo các trường khác nhau
        switch ($sort_by) {
            case 'name':
                $sql .= " ORDER BY p.pro_name " . ($sort_order == 'desc' ? 'DESC' : 'ASC');
                break;
            case 'price':
                $sql .= " ORDER BY p.pro_price " . ($sort_order == 'desc' ? 'DESC' : 'ASC');
                break;
            case 'category':
                $sql .= " ORDER BY c.cate_name " . ($sort_order == 'desc' ? 'DESC' : 'ASC');
                break;
            case 'brand':
                $sql .= " ORDER BY p.pro_brand " . ($sort_order == 'desc' ? 'DESC' : 'ASC');
                break;
            default: // mặc định sắp xếp theo ID
                $sql .= " ORDER BY p.pro_id " . ($sort_order == 'desc' ? 'DESC' : 'ASC');
        }

        // Add pagination if offset and limit are provided
        if ($offset !== null && $limit !== null) {
            $sql .= " LIMIT $offset, $limit";
        }

        // Thực hiện truy vấn
        $result = pdo_queryall($sql);
        return $result;
    } catch (Exception $e) {
        error_log("Error in queryallpro_with_sorting: " . $e->getMessage());
        return [];
    }
}

function addpro($ten, $img, $price, $ct, $cate, $inventory, $brand)
{
    try {
        // Get connection first so we can use it for both operations
        $conn = get_connect();

        // Insert the product
        $sql = "INSERT INTO products(pro_name, pro_img, pro_price, pro_desc, pro_brand, cate_id, ncc_id, trangthai, pro_viewer) 
                VALUES(?, ?, ?, ?, ?, ?, 1, 0, 0)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$ten, $img, $price, $ct, $brand, $cate]);

        // Get the ID of the newly inserted product
        $pro_id = $conn->lastInsertId();

        return $pro_id;
    } catch (PDOException $e) {
        // Log the error for debugging
        error_log("Error in addpro: " . $e->getMessage());
        return 0;
    }
}
function queryonepro($id)
{
    $sql = "select * from products where pro_id = $id";
    $result = pdo_query_one($sql);
    return $result;
}
function updatepro($ten, $gia, $brand, $img, $ct, $cate, $id)
{
    $sql = "update products set pro_name='$ten',pro_price=$gia,pro_img='$img',pro_desc='$ct',pro_brand='$brand',cate_id=$cate where pro_id = $id";
    pdo_execute($sql);
}
function deletepro($id)
{
    $sql = "delete from products where pro_id = $id";
    pdo_execute($sql);
}
function showpro_home()
{
    $sql = "select * from products order by pro_id desc limit 9";
    $result = pdo_queryall($sql);
    return $result;
}
function query_procate($cate_id, $pro_id)
{
    $sql = "select * from products where cate_id = $cate_id and pro_id != $pro_id";
    $result = pdo_queryall($sql);
    return $result;
}
function deleteprocate($id)
{
    $sql = "delete from products where cate_id = $id";
    pdo_execute($sql);
}
function chitietadmin($id)
{
    $sql = "select * from pro_chitiet where pro_id = $id";
    $result = pdo_queryall($sql);
    return $result;
}
function addpro_chitiet($pro_id, $size, $color, $soluong)
{
    $sql = "insert into pro_chitiet values (null,$pro_id, $color, $size, $soluong)";
    pdo_execute($sql);
}
function del_prochitiet($id)
{
    $sql = "delete from pro_chitiet where ctiet_pro_id = $id";
    pdo_execute($sql);
}

function query_prochitiet($id)
{
    $sql = "select * from pro_chitiet where pro_id = $id";
    $result = pdo_queryall($sql);
    return $result;
}
function queryone_prochitiet($id)
{
    $sql = "select * from pro_chitiet where ctiet_pro_id = $id";
    $result = pdo_query_one($sql);
    return $result;
}
function updateprochitiet($id, $soluong)
{
    $sql = "update pro_chitiet set soluong = $soluong where ctiet_pro_id = $id";
    pdo_execute($sql);
}
function query_pro_soluong($id, $color, $size)
{
    $sql = "select * from pro_chitiet where pro_id = $id and size_id = $size and color_id = $color";
    $result = pdo_query_one($sql);
    return $result;
}
// câu truy vấn xoá mềm
function soft_deletepro($id)
{
    $sql = "UPDATE `products` set trangthai = 1 WHERE `products`.`pro_id` = $id";
    pdo_execute($sql);
}
function queryallpros()
{
    $sql = "select * from `products` where `products`.`trangthai` = 1";
    $sql .= " order by pro_id desc";
    $result = pdo_queryall($sql);
    return $result;
}
function khoiphuc_product($id)
{
    $sql = "UPDATE `products` set trangthai = 0 WHERE `products`.`pro_id` = $id";
    pdo_execute($sql);
}

// Hàm tính tổng tồn kho của một sản phẩm
function get_total_inventory($pro_id)
{
    $sql = "SELECT SUM(soluong) as total_stock FROM pro_chitiet WHERE pro_id = $pro_id";
    $result = pdo_query_one($sql);

    if ($result && isset($result['total_stock'])) {
        return $result['total_stock'];
    }

    return 0; // Trả về 0 nếu không có dữ liệu
}

function countProId()
{
    $sql = "SELECT COUNT(*) as countpro FROM products";
    $result = pdo_query_one($sql);
    return $result;
}
function loadall_sanpham_top5()
{
    $sql = "SELECT p.pro_id, p.pro_name FROM products p WHERE 1 ORDER BY p.pro_id DESC LIMIT 0,5";
    $listsanpham = pdo_queryall($sql);

    // Add inventory data to each product
    foreach ($listsanpham as &$product) {
        $product['pro_stock'] = get_total_inventory($product['pro_id']);
    }

    // Sort by inventory (total stock) manually
    usort($listsanpham, function ($a, $b) {
        return $b['pro_stock'] - $a['pro_stock']; // Sort descending
    });

    return $listsanpham;
}
function loadAll_products($searchProduct = "", $id = 0)
{
    $sql = "SELECT * FROM products WHERE 1";
    if ($searchProduct != "") {
        $sql .= " AND pro_name LIKE '%" . $searchProduct . "%'";
    }
    if ($id > 0) {
        $sql .= " AND cate_id = '" . $id . "'";
    }
    $sql .= " ORDER BY pro_id DESC";
    $listsp = pdo_queryall($sql);

    return $listsp;
}

function updateProductViews($pro_id)
{
    try {
        $sql = "UPDATE products SET pro_viewer = pro_viewer + 1 WHERE pro_id = '$pro_id'";
        pdo_execute($sql);
    } catch (PDOException $e) {
        echo "Error updating product views: " . $e->getMessage();
    }
}

function count_products($key = '', $idcate = 0)
{
    $sql = "SELECT COUNT(*) as total FROM products WHERE trangthai = 0";
    if ($key != '') {
        $sql .= " AND pro_name LIKE '%$key%'";
    }
    if ($idcate > 0) {
        $sql .= " AND cate_id = $idcate";
    }
    $result = pdo_query_one($sql);
    return $result['total'];
}

function trending_products($offset = null, $limit = null)
{
    $sql = "SELECT * FROM products ORDER BY pro_viewer DESC";

    // Add pagination if offset and limit are provided
    if ($offset !== null && $limit !== null) {
        $sql .= " LIMIT $offset, $limit";
    } else {
        $sql .= " LIMIT 20"; // Default limit
    }

    $favouriteProducts = pdo_queryall($sql);
    return $favouriteProducts;
}

function count_trending_products()
{
    $sql = "SELECT COUNT(*) as total FROM products WHERE 1";
    $result = pdo_query_one($sql);
    return $result['total'];
}

// function addProductToFavourite($kh_id, $pro_id)
// {
//     // Check if
//     if (!isset($_SESSION['submitted_favourite'][$pro_id])) {
//         $sql = "INSERT INTO products_favourite(kh_id, pro_id) VALUES ('$kh_id', '$pro_id')";
//         pdo_execute($sql);

//         // Set the session
//         $_SESSION['submitted_favourite'][$pro_id] = true;

//         // Disable the button
//         echo '<button style="width: 41%;" class="btn bg-info bg-opacity-20 border border-info border-start-0 mt-4 btn-md text-dark fw-bold text-center disabled" type="button" disabled>Added to Favorites <i class="fa fa-heart text-danger" aria-hidden="true"></i></button>';
//     } else {
//         // Display the disabled button
//         echo '<button style="width: 41%;" class="btn bg-info bg-opacity-20 border border-info border-start-0 mt-4 btn-md text-dark fw-bold text-center" type="submit" name="favourite">
//            Add to Favorites <i class="fa fa-heart text-danger" aria-hidden="true"></i>
//         </button>';
//     }
// }
function queryAll_productFavourite($khachHangID)
{
    $sql = "SELECT
            products.pro_id,
            products.pro_name,
            products.pro_img,
            products.pro_price,
            products.pro_desc,
            products.pro_brand,
            products.pro_stock,
            products.pro_viewer,
            products.cate_id
        FROM
            products
        INNER JOIN
            products_favourite
        ON
            products.pro_id = products_favourite.pro_id
        WHERE
            products_favourite.kh_id = $khachHangID";

    $favouriteProducts = pdo_queryall($sql);
    $favouriteProducts = array_unique($favouriteProducts, SORT_REGULAR);
    return $favouriteProducts;
}


function addProductToFavourite($kh_id, $pro_id)
{
    $sql = "INSERT INTO products_favourite(kh_id, pro_id) VALUES ('$kh_id', '$pro_id')";
    pdo_execute($sql);
}

function proFrAdded($kh_id, $pro_id)
{
    $sql = "SELECT * FROM products_favourite WHERE kh_id = $kh_id AND pro_id = $pro_id";
    $proFrAdded = pdo_query_one($sql);
    return $proFrAdded;
}
// function query_one_probienthe($id){
//     $sql = "select * from pro_chitiet "
// }






// xỬ lí chi itest sp

function  getAllChitietSp($id)
{
    $sql  = "SELECT * FROM `pro_chitiet` WHERE pro_id = $id";
    $result = pdo_queryall($sql);
    return $result;
}

function kiemtra_sp_dangtrongdonhang($pro_id_canxoa)
{
    $sql = "
        SELECT order_chitiet.order_id 
        FROM order_chitiet
        INNER JOIN `order` ON order_chitiet.order_id = `order`.order_id
        WHERE 
            order_chitiet.pro_id = ?
            AND (
                `order`.order_trangthai = 'Chờ xác nhận'
                OR `order`.order_trangthai = 'Đang giao hàng'
            )
        LIMIT 1
    ";
    $result = pdo_query_one($sql, $pro_id_canxoa);

    return $result !== false && $result !== null;
}

// Hàm kiểm tra sản phẩm có trong phiếu nhập hay không
function kiemtra_sp_trongphieunhap($pro_id)
{
    $sql = "SELECT COUNT(*) as count FROM import_receipt_details WHERE pro_id = ?";
    $result = pdo_query_one($sql, $pro_id);

    return ($result && $result['count'] > 0);
}
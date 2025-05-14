<?php
function loadall_thongke()
{
    $sql = "select category.cate_id as iddm , category.cate_name as tendm, count(products.pro_id ) as soluong, min(products.pro_price) as minprice, max(products.pro_price) as maxprice, avg(products.pro_price) as avgprice";
    $sql .= " from products left join category on category.cate_id = products.cate_id";
    $sql .= " group by category.cate_id";
    $sql .= " order by category.cate_id desc";
    $result = pdo_queryall($sql);
    return $result;
}
function load_thongkebl()
{
    $sql = "select products.pro_id ,products.pro_name, count(coment.cmt_id) as sobinhluan from  products 
    LEFT JOIN coment ON coment.pro_id  = products.pro_id group by products.pro_id,products.pro_name order by sobinhluan desc  ";
    $listtkbl = pdo_queryall($sql);
    return $listtkbl;
}

function thongke_donhang()
{
    $sql = "SELECT order_trangthai, 
                   COUNT(*) as soluong, 
                   SUM(order_totalprice) as tongtien 
            FROM `order` 
            GROUP BY order_trangthai";
    $result = pdo_queryall($sql);
    return $result;
}

// Hàm thống kê sản phẩm bán chạy nhất
function thongke_sanpham_banchay($limit = 10, $bao_gom_da_huy = false)
{
    $where_huy = $bao_gom_da_huy ? "" : "WHERE `order`.order_trangthai != 'Đã hủy'";

    $sql = "SELECT 
                products.pro_id,
                products.pro_name,
                products.pro_img,
                products.pro_price,
                COUNT(order_chitiet.pro_id) as so_luong_ban,
                SUM(order_chitiet.total_price) as doanh_thu
            FROM 
                order_chitiet
            JOIN 
                products ON products.pro_id = order_chitiet.pro_id
            JOIN 
                `order` ON `order`.order_id = order_chitiet.order_id
            $where_huy
            GROUP BY 
                products.pro_id, products.pro_name, products.pro_img, products.pro_price
            ORDER BY 
                so_luong_ban DESC
            LIMIT $limit";

    return pdo_queryall($sql);
}

// Hàm thống kê doanh thu theo tháng/quý/năm
function thongke_doanhthu($kieu = 'thang', $bao_gom_da_huy = false)
{
    $where_huy = $bao_gom_da_huy ? "" : "AND order_trangthai != 'Đã hủy'";

    switch ($kieu) {
        case 'thang':
            // Thống kê theo tháng trong năm hiện tại
            $sql = "SELECT 
                        MONTH(STR_TO_DATE(`order_date`, '%d-%m-%y')) as thoi_gian,
                        SUM(order_totalprice) as doanh_thu,
                        COUNT(order_id) as so_don_hang
                    FROM 
                        `order`
                    WHERE 
                        YEAR(STR_TO_DATE(`order_date`, '%d-%m-%y')) = YEAR(CURDATE())
                        $where_huy
                    GROUP BY 
                        MONTH(STR_TO_DATE(`order_date`, '%d-%m-%y'))
                    ORDER BY 
                        MONTH(STR_TO_DATE(`order_date`, '%d-%m-%y'))";
            break;

        case 'quy':
            // Thống kê theo quý trong năm hiện tại
            $sql = "SELECT 
                        QUARTER(STR_TO_DATE(`order_date`, '%d-%m-%y')) as thoi_gian,
                        SUM(order_totalprice) as doanh_thu,
                        COUNT(order_id) as so_don_hang
                    FROM 
                        `order`
                    WHERE 
                        YEAR(STR_TO_DATE(`order_date`, '%d-%m-%y')) = YEAR(CURDATE())
                        $where_huy
                    GROUP BY 
                        QUARTER(STR_TO_DATE(`order_date`, '%d-%m-%y'))
                    ORDER BY 
                        QUARTER(STR_TO_DATE(`order_date`, '%d-%m-%y'))";
            break;

        case 'nam':
            // Thống kê theo năm
            $sql = "SELECT 
                        YEAR(STR_TO_DATE(`order_date`, '%d-%m-%y')) as thoi_gian,
                        SUM(order_totalprice) as doanh_thu,
                        COUNT(order_id) as so_don_hang
                    FROM 
                        `order`
                    WHERE 
                        1=1
                        $where_huy
                    GROUP BY 
                        YEAR(STR_TO_DATE(`order_date`, '%d-%m-%y'))
                    ORDER BY 
                        YEAR(STR_TO_DATE(`order_date`, '%d-%m-%y'))";
            break;
    }

    return pdo_queryall($sql);
}

// Hàm thống kê số lượng đơn hàng theo tháng/quý/năm (bao gồm cả đơn đã hủy)
function thongke_donhang_theothoigian($kieu = 'thang')
{
    switch ($kieu) {
        case 'thang':
            // Thống kê theo tháng trong năm hiện tại
            $sql = "SELECT 
                        MONTH(STR_TO_DATE(`order_date`, '%d-%m-%y')) as thoi_gian,
                        COUNT(order_id) as so_don_hang,
                        order_trangthai,
                        SUM(order_totalprice) as tong_gia_tri
                    FROM 
                        `order`
                    WHERE 
                        YEAR(STR_TO_DATE(`order_date`, '%d-%m-%y')) = YEAR(CURDATE())
                    GROUP BY 
                        MONTH(STR_TO_DATE(`order_date`, '%d-%m-%y')), order_trangthai
                    ORDER BY 
                        MONTH(STR_TO_DATE(`order_date`, '%d-%m-%y')), order_trangthai";
            break;

        case 'quy':
            // Thống kê theo quý trong năm hiện tại
            $sql = "SELECT 
                        QUARTER(STR_TO_DATE(`order_date`, '%d-%m-%y')) as thoi_gian,
                        COUNT(order_id) as so_don_hang,
                        order_trangthai,
                        SUM(order_totalprice) as tong_gia_tri
                    FROM 
                        `order`
                    WHERE 
                        YEAR(STR_TO_DATE(`order_date`, '%d-%m-%y')) = YEAR(CURDATE())
                    GROUP BY 
                        QUARTER(STR_TO_DATE(`order_date`, '%d-%m-%y')), order_trangthai
                    ORDER BY 
                        QUARTER(STR_TO_DATE(`order_date`, '%d-%m-%y')), order_trangthai";
            break;

        case 'nam':
            // Thống kê theo năm
            $sql = "SELECT 
                        YEAR(STR_TO_DATE(`order_date`, '%d-%m-%y')) as thoi_gian,
                        COUNT(order_id) as so_don_hang,
                        order_trangthai,
                        SUM(order_totalprice) as tong_gia_tri
                    FROM 
                        `order`
                    GROUP BY 
                        YEAR(STR_TO_DATE(`order_date`, '%d-%m-%y')), order_trangthai
                    ORDER BY 
                        YEAR(STR_TO_DATE(`order_date`, '%d-%m-%y')), order_trangthai";
            break;
    }

    return pdo_queryall($sql);
}
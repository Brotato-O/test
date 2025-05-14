<!-- main -->
<div class="container">
  <h2 class="border border-4 mb-4 text-black-50 p-3 text-center rounded">Thống kê sản phẩm theo danh mục</h2>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <Th class="text-bg-secondary">Mã danh mục</Th>
          <th class="text-bg-secondary">Tên danh mục</th>
          <th class="text-bg-secondary">Số lượng</th>
          <th class="text-bg-secondary">Giá cao nhất</th>
          <Th class="text-bg-secondary">Giá thấp nhất</Th>
          <Th class="text-bg-secondary">Giá trung bình</Th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listthongke as $thongke) {
          extract($thongke);
        ?>
          <tr>
            <td><?= $iddm ?></td>
            <td><?= $tendm ?></td>
            <td><?= $soluong ?></td>
            <td><?= $maxprice ?></td>
            <td><?= $minprice ?></td>
            <td><?= $avgprice ?></td>
          </tr>
        <?php  } ?>
      </tbody>
    </table>
  </div>
  <div class="">
    <a href="indexadmin.php?act=bieudo">
      <button type="button" class="btn btn-outline-secondary">Biểu đồ</button>
    </a>
  </div>

  <h2 class=" mt-5 border border-4 mb-4 text-black-50 p-3 text-center rounded">Thống kê bình luận theo sản phẩm</h2>
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <Th class="text-bg-secondary">Mã sản phẩm</Th>
          <th class="text-bg-secondary">Tên sản phẩm</th>
          <th class="text-bg-secondary">Số lượng bình luận</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listtkbl as $bl) {
          extract($bl);
        ?>
          <tr>
            <td><?= $pro_id  ?></td>
            <td><?= $pro_name ?></td>
            <td><?= $sobinhluan  ?></td>
          </tr>
        <?php  } ?>
      </tbody>
    </table>
  </div>
  <div class="">
    <a href="indexadmin.php?act=bieudobl">
      <button type="button" class="btn btn-outline-secondary">Biểu đồ</button>
    </a>
  </div>
</div>

<?php
// Hàm lấy danh sách top khách hàng mua nhiều nhất trong khoảng thời gian
function get_top_khachhang($date_from, $date_to, $top_limit = 5, $sort_order = 'desc')
{
  global $pdo;

  $query = "SELECT u.user_id, u.user_name, u.user_email, 
              COUNT(o.order_id) as so_don_hang, 
              SUM(o.order_tong) as tong_mua 
              FROM user u 
              JOIN order_data o ON u.user_id = o.user_id 
              WHERE o.order_date BETWEEN :date_from AND :date_to 
              GROUP BY u.user_id, u.user_name, u.user_email 
              ORDER BY tong_mua " . ($sort_order == 'asc' ? 'ASC' : 'DESC') . " 
              LIMIT :top_limit";

  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':date_from', $date_from);
  $stmt->bindParam(':date_to', $date_to);
  $stmt->bindParam(':top_limit', $top_limit, PDO::PARAM_INT);
  $stmt->execute();

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Hàm lấy chi tiết đơn hàng của khách hàng trong khoảng thời gian
function get_donhang_by_user($user_id, $date_from, $date_to)
{
  global $pdo;

  $query = "SELECT order_id, order_date, order_trangthai, order_tong 
              FROM order_data 
              WHERE user_id = :user_id 
              AND order_date BETWEEN :date_from AND :date_to 
              ORDER BY order_date DESC";

  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':user_id', $user_id);
  $stmt->bindParam(':date_from', $date_from);
  $stmt->bindParam(':date_to', $date_to);
  $stmt->execute();

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

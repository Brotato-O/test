<!-- Thanh menu thống kê -->
<div class="row mb-4">
    <div class="col-md-12">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link <?= $page == 'sanpham' ? 'active bg-primary' : '' ?>"
                    href="indexadmin.php?act=thongke_sanpham">Thống kê sản phẩm bán chạy</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page == 'khachhang' ? 'active bg-primary' : '' ?>"
                    href="indexadmin.php?act=thongke_khachhang">Thống kê khách hàng</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page == 'doanhthu' ? 'active bg-primary' : '' ?>"
                    href="indexadmin.php?act=thongke_doanhthu">Thống kê doanh thu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $page == 'donhang' ? 'active bg-primary' : '' ?>"
                    href="indexadmin.php?act=thongke_donhang">Thống kê đơn hàng</a>
            </li>
        </ul>
    </div>
</div>
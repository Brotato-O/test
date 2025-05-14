    <!-- main -->
    <div class="container">
        <h2 class="border border-4 mb-4 text-bg-secondary p-3 text-center rounded"><?= $chart_title ?></h2>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load("current", {
                packages: ["corechart"]
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Thời gian + Trạng thái', 'Số đơn hàng'],
                    <?php
                    // Tạo mảng để nhóm dữ liệu theo thời gian
                    $data_by_time = [];
                    foreach ($don_hang as $dh) {
                        extract($dh);
                        $label = $label_prefix . $thoi_gian . ' - ' . $order_trangthai;
                        echo "['$label', $so_don_hang],";
                    }
                    ?>
                ]);

                var options = {
                    title: '<?= $chart_title ?>',
                    legend: {
                        position: 'bottom'
                    },
                    colors: ['#4285F4', '#EA4335', '#FBBC05', '#34A853', '#8A4182', '#FF6D01', '#46BDC6'],
                    pieSliceText: 'value',
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                chart.draw(data, options);
            }
        </script>
        <div id="piechart_3d" style="width: 100%; height: 500px;"></div>

        <div class="mt-3">
            <a href="indexadmin.php?act=thongke_donhang" class="btn btn-primary">Quay lại thống kê đơn hàng</a>
        </div>
    </div>
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
                    ['Thời gian', 'Doanh thu ($)'],
                    <?php foreach ($doanh_thu as $dt) {
                        extract($dt);
                    ?>['<?= $label_prefix . $thoi_gian ?>', <?= $doanh_thu ?>],
                    <?php } ?>
                ]);

                var options = {
                    title: '<?= $chart_title ?>',
                    hAxis: {
                        title: 'Thời gian',
                        titleTextStyle: {
                            color: '#333'
                        }
                    },
                    vAxis: {
                        minValue: 0
                    },
                    colors: ['#4285F4', '#EA4335', '#FBBC05', '#34A853', '#8A4182']
                };

                var chart = new google.visualization.AreaChart(document.getElementById('piechart_3d'));
                chart.draw(data, options);
            }
        </script>
        <div id="piechart_3d" style="width: 100%; height: 500px;"></div>

        <div class="mt-3">
            <a href="indexadmin.php?act=thongke_doanhthu" class="btn btn-primary">Quay lại thống kê doanh thu</a>
        </div>
    </div>
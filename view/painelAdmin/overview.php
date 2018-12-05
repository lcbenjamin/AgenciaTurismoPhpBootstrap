<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;

?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!-- Navegador da Pagina-->
<header>
	<div class="row">
		<div class="col-sm-7">
		    <h4 class="mt-2 ml-1">Overview</h4>
		</div>
	</div>
</header>


          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
              <div class="count">2500</div>
              <span class="count_bottom"><i class="green">4% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
              <div class="count">123.50</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
              <div class="count green">2,500</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
              <div class="count">4,567</div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
              <div class="count">2,315</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
              <div class="count">7,325</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
          </div>


<div class="row bg-light">
    <div id="piechart" style="width: 450px; height: 250px;"></div>
    <div id="chart_div" style="width: 450px; height: 250px;"></div>
</div>


<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Status', 'Quantidade'],
            ['Solicitado', 11],
            ['Confirmado', 5],
            ['Cancelado',  2],
            ['Concluido',  2],
            ['Pendente',   7]
        ]);

        var options = {
            title: 'Situação Pacotes'
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
    }
</script>


<script type='text/javascript'>
    
    google.charts.load('current', {'packages': ['geochart']});
    google.charts.setOnLoadCallback(drawMarkersMap);

    function drawMarkersMap() {
    var data = google.visualization.arrayToDataTable([
        ['Estado',  'Pacote Vendido'],
        ['Rio de Janeiro',      30],
        ['Rio Grande do Sul',   50],
        ['São Paulo',           25],
        ['Mato Grosso',         11]
    ]);

    var options = {
        region: 'BR',
        title: 'Situação Pacotes',
        resolution: 'provinces',
        displayMode: 'regions',
        colorAxis: {colors: ['yellow', 'red']}
    };

    var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
    chart.draw(data, options);
};

</script>


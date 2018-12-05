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

<div class="row bg-light">
    <div id="piechart" style="width: 450px; height: 250px;"></div>
</div>

<div id="chart_div" style="width: 900px; height: 500px;"></div>




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
        resolution: 'provinces',
        displayMode: 'regions',
        colorAxis: {colors: ['yellow', 'red']}
    };

    var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
    chart.draw(data, options);
};

</script>


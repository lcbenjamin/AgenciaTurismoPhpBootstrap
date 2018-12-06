<?php 
    require_once '../../config.php';
    require_once DBAPI;

    require_once('../../controller/beans/overviewBean.php');
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="row my-3 pb-2 bg-light">
    <div class="col-md-2 col-sm-4 col-xs-6 ">
        <span class="count_top"><i class="fa fa-user"></i> Total Clientes</span>
        <div class="count"><?php echo retornaTotalClientes(); ?></div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 ">
        <span class="count_top"><i class="fa fa-usd"></i> Pacotes Vendidos</span>
        <div class="count"><?php echo retonaPacoteVendidos(); ?></div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 ">
        <span class="count_top"><i class="fa fa-plus-square"></i> Total Vendas</span>
        <div class="count"><?php echo "R$ " .retornaTotalVendas(); ?></div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 ">
        <span class="count_top"><i class="fa fa-suitcase"></i> Pacotes Disponíveis</span>
        <div class="count"><?php echo retornaPacoteCadastrados(); ?></div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 ">
        <span class="count_top"><i class="fa fa-user"></i> Passeios Disponíveis</span>
        <div class="count"><?php echo retonaPasseiosDisponiveis(); ?></div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
        <span class="count_top"><i class="fa fa-user"></i> Pedidos Solicitados</span>
        <div class="count"><?php echo retornaPedidosSolicitados(); ?></div>
    </div>
</div>



<div class="x_panel">
    <span class="text-dark text-center"><h4>Status dos pacotes</h4></span>
    <hr />
    <div id="piechart" style="width: 400px; height: 225px;"></div>     
</div>

<div class="x_panel">
    <span class="text-dark text-center"><h4>Cobertura disponível</h4></span>
    <hr />
    <div id="chart_div" style="width: 400px; height: 225px;"></div>
</div>


<!-- Grafico do status dos pedidos -->
<?php echo geraGraficoPizza();?>

<!-- Grafico do status dos pedidos -->
<?php echo geraGraficoGeo();?>



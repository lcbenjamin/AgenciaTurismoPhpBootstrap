<?php 
    require_once '../../config.php';
    require_once DBAPI;

function retornaTotalClientes(){

    $totalClientes = find('USR', 'codPerfil', '1', true );

    return count($totalClientes);
}

function retonaPacoteVendidos(){
   
    $totalPacotes = find('PED', 'status', 'Confirmado', true );

    return count($totalPacotes);
}

function retornaTotalVendas(){
   
    $pedidos = find('PED', 'status', 'Confirmado', true );
    $totalVendido = null;

    foreach($pedidos as $pedido){
        $totalVendido += $pedido['valorTotal'] ;
    }

    return number_format($totalVendido, 2, ',', '.');
}

function retornaPacoteCadastrados(){

    $pacotes = find('PCT', 'status', 'Ativo', true );
    return count($pacotes);
}

function retonaPasseiosDisponiveis(){
   
    $passeios = find('PAS', 'status', 'Ativo', true );

    return count($passeios);
}

function retornaPedidosSolicitados(){
   
    $pedidos = find('PED', 'status', 'Solicitado', true );

    if($pedidos == null){
        return 0;
    }
    
    return count($pedidos);
}

function retornaPedidosConfirmados(){
   
    $pedidos = find('PED', 'status', 'Confirmado', true );

    if($pedidos == null){
        return 0;
    }
    
    return count($pedidos);
}

function retornaPedidosCancelados(){
   
    $pedidos = find('PED', 'status', 'Cancelado', true );

    if($pedidos == null){
        return 0;
    }
    
    return count($pedidos);
}

function retornaPedidosConcluidos(){
   
    $pedidos = find('PED', 'status', 'Concluido', true );
    
    if($pedidos == null){
        return 0;
    }
    
    return count($pedidos);
}

function retornaPedidosPendentes(){
    
    $pedidos = find('PED', 'status', 'Pendente', true );
    
    if($pedidos == null){
        return 0;
    }

    return count($pedidos);
}

function geraGraficoPizza(){

    $solicitado = retornaPedidosSolicitados();
    $confirmado = retornaPedidosConfirmados();
    $cancelado = retornaPedidosCancelados();
    $concluido = retornaPedidosConcluidos();
    $pendente = retornaPedidosPendentes();

    echo "
    
    <script>
        
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Status', 'Quantidade'],
                ['Solicitado', " .    $solicitado ."],
                ['Confirmado', " .    $confirmado ."],
                ['Cancelado',  " .    $cancelado  ."],
                ['Concluido',  " .    $concluido  ."],
                ['Pendente',   " .    $pendente   ."]
            ]);

            var options = {
                is3D:true,

        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
        }
    </script>
";
}

function geraGraficoGeo(){
    
    /** Busca na base todos os pacotes  cadastrados por estado de destino */
    $resultados = consultaPacotesCadPorEstado();

    /** Cria cabeçalho do componente */
    $data = array(
                array('Estado', 'Pacote Vendido')
    );

    /** Preenche array com os dados do banco */
    foreach($resultados as $resultado){
        array_push($data, array($resultado['Estado'], (int) $resultado['Pacote Vendido']));    
    }

    /** Imprime na tela JavaScript do componente */
    echo "   
    
    <script>
    
    google.charts.load('current', {'packages': ['geochart']});
    google.charts.setOnLoadCallback(drawMarkersMap);

    function drawMarkersMap() {
    var data = google.visualization.arrayToDataTable(". json_encode($data, JSON_UNESCAPED_UNICODE).");

    var options = {
        region: 'BR',
        title: 'Situação Pacotes',
        resolution: 'provinces',
        displayMode: 'auto',
        colorAxis: {colors: ['#96b2e0', '#0d2651']}
    };

    var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
    chart.draw(data, options);
};

</script>
    
    
    ";
}
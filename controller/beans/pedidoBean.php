<?php
require_once('../../config.php');
require_once(DBAPI);
$pedidos = null;


/*********************************
 *  Carrega pedidos cadastrados *
 *********************************/
function carrega_pedidos() {
	global $pedidos;
	$pedidos = find_all('PED');
}


/********************************
 *  Adiciona itens ao carrinho  *
 ********************************/

/** Cria o carrinho se não existir */
if (!isset($_SESSION['carrinho'])) {
   $_SESSION['carrinho'] = array();
}

$carrinho = $_SESSION['carrinho'];


/** Verifica se as variáveis vieram via POST, se for adiciona um novo item ao carrinho */
if (isset($_POST['pedidoPersonalizado'])) {

    /** Se carrinho estiver vazio, adiciona item */
    if(empty($carrinho)){
        $carrinho[$_POST['pedidoPersonalizado']['codPacote']] = trataSolicitacaoPedidoPersonalizado();
        $_SESSION['message'] = 'Pacote incluído com sucesso no carrinho.';
        $_SESSION['type'] = 'success';  
    } 
    /** Se carrinho não estiver vazio, verifica se item já esta incluido */
    else {

        /** Verifica se o item é novo */
        $itemNovo = true;
        foreach($carrinho as $item => $valor){
            if($valor['codPacote'] == $_POST['pedidoPersonalizado']['codPacote']){
                $_SESSION['message'] = 'Pacote já incluído no carrinho'; 
                $_SESSION['type'] = 'danger';
                $itemNovo = false;
            }
        }

        /** se for novo adiciona no carrinho */
        if($itemNovo){
            $carrinho[$_POST['pedidoPersonalizado']['codPacote']] = trataSolicitacaoPedidoPersonalizado();
            $_SESSION['message'] = 'Pacote incluído com sucesso no carrinho.';
            $_SESSION['type'] = 'success';  
        }

    }
}

//Salva na sessão
$_SESSION['carrinho'] = $carrinho;


/********************************
 *  Deleta item do carrinho  *
 ********************************/

if(isset($_GET['idExcluir'])){
    
    $codPacote = $_GET['idExcluir'];
    unset($_SESSION['carrinho'][$codPacote]);
}

/***************************
 *  Fecha compra carrinho  *
 **************************/

 if(isset($_GET['confirma']) && isset($_SESSION['carrinho'])){


    $confirmado = 0;
    
    /** Salva os pedidos no banco de dados */
    foreach($_SESSION['carrinho'] as $itemPedido){
        $itemPedido['dataHoraCadastro'] = date('Y/m/d H:i'); 
        $confirmado = saveReturnID('PED',$itemPedido);
    }
     

    /** Caso tenha sucesso  */
    if($confirmado != 0){
        $_SESSION['message'] = 'Pedido finalizado com sucesso.';
        $_SESSION['type'] = 'success';  
        
    } else{
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao'; 
        $_SESSION['type'] = 'danger';
    }

    /** limpa carrinho */
    unset($_SESSION['carrinho']);
 }

/****************************************
 *  Trata a adição de item no carrinho  *
 ****************************************/

function trataSolicitacaoPedidoPersonalizado(){

    /** Inicia as variaveis com valor nulo */
    $pacotePadrao = null;
    $usuarioSolicitante = null;
    $pacotePersonalizado = null;
    $pacotesCarrinho  = null;
    
    /** Carrega o pacote selecionado */
    if(isset($_POST['pedidoPersonalizado'])){
        $codPacote = $_POST['pedidoPersonalizado']['codPacote'];
        $pacotePadrao = carregaDadosPacoteFull($codPacote);
    }
    
    /** Carrega usuário solicitante */
    if(isset($_SESSION['logado'])){
        $usuarioSolicitante = $_SESSION['logado'];        
    }
    
    /** Carrega usuário solicitante */
    if(isset($_POST['pedidoPersonalizado'])){
        $pacotePersonalizado = $_POST['pedidoPersonalizado'];        
    }
    
    
    if(isset($_POST['pedidoPersonalizado'])){

        /** Define usuário */
        $codigoUsuario = $usuarioSolicitante['codigoUsuario'];
        
        /** Define codigo Pacote */
        $codPacote = $pacotePersonalizado['codPacote'];
       
        /** Define data Ida do viagem */
        $dataInicio = validaDataInicio($pacotePersonalizado,$pacotePadrao);
        
        /** Define data Ida do viagem */
        $dataFim = validaDataFim($pacotePersonalizado,$pacotePadrao);

        /** Define Traslado */        
        $traslado = validaTraslado($pacotePersonalizado);

        /** Define Traslado */        
        $valorTraslado = validaValorTraslado($pacotePersonalizado,$pacotePadrao);

        /** Define Parcelamento */        
        $parcelamento = validaParcelamento($pacotePersonalizado,$pacotePadrao);

        /** Define Valor Total */        
        $valorTotal = validaValor($pacotePersonalizado,$pacotePadrao);

        /** Define Hospedagem */        
        $hospedagem = validaHospedagem($pacotePersonalizado);

        /** Define valor hospedagem */        
        $valorHospedagem = validaValorHospedagem($pacotePersonalizado,$pacotePadrao);

        /** Define Aereo */        
        $aereo = validaAereo($pacotePersonalizado);

        /** Define valor Aereo */        
        $valorAereo = validaValorAereo($pacotePersonalizado,$pacotePadrao);


        /**Monta Pedido */
        $pedidoPersonalizado = array(
            "codPacote" => $codPacote,
            "codigoUsuario" => $codigoUsuario,
            "dataInicio" => $dataInicio,
            "dataFim" => $dataFim,
            "traslado" => $traslado,
            "valorTraslado" => $valorTraslado,
            "quantidadeParcelas" => $parcelamento,
            "hospedagem" => $hospedagem,
            "valorHospedagem" => $valorHospedagem,
            "aereo" => $aereo,
            "valorAereo" => $valorAereo,
            "valorTotal" => $valorTotal,
            "status" => "Solicitado",
        );

        /** Define variavel global para uso em tela */
        return $pacotesCarrinho = $pedidoPersonalizado;
    }
}

/****************
 *  VALIDAÇÕES  *
 ****************/
function validaDataInicio($pacotePersonalizado,$pacotePadrao){

    $dataInicio = null;

    /** Verifica qual data usar */
    if(!empty($pacotePersonalizado['dataInicio'])){
        $data = str_replace("/", "-", $pacotePersonalizado['dataInicio']);
        $dataInicio = date('Y-m-d', strtotime($data));;
    } else{
        $dataInicio = $pacotePadrao['pacote']['dataInicio'];
    }

    return $dataInicio;
}

function validaDataFim($pacotePersonalizado,$pacotePadrao){

    $dataFim = null;

    /** Verifica qual data usar */
    if(!empty($pacotePersonalizado['dataFim'])){
        $data = str_replace("/", "-", $pacotePersonalizado['dataFim']);
        $dataFim = date('Y-m-d', strtotime($data));;
    } else{
        $dataFim = $pacotePadrao['pacote']['dataFim'];
    }

    return $dataFim; 
}

function validaTraslado($pacotePersonalizado){

    $traslado = null;

    if(!empty($pacotePersonalizado['traslado'])){
        $traslado = "true";
    } else{
        $traslado = "false";
    }

    return $traslado; 
}

function validaValorTraslado($pacotePersonalizado,$pacotePadrao){

    $valorTraslado = null;

    if(validaTraslado($pacotePersonalizado)){
        $valorTraslado = $pacotePadrao['pacote']['valorTraslado'];
    } else{
        $valorTraslado = floatval(0) ;
    }

    return $valorTraslado; 
}

function validaParcelamento($pacotePersonalizado,$pacotePadrao){

    $parcelamento = null;

    if($pacotePadrao['pacote']['parcela'] == true){
        $parcelamento = $pacotePersonalizado['quantidadeParcelas'];
    } else{
        $parcelamento = "0";
    }

    return $parcelamento; 
}

function validaValor($pacotePersonalizado,$pacotePadrao){

    $valorTotal = null;

    /** Calcula diarias */
    $diarias = caculaDiarias(validaDataInicio($pacotePersonalizado,$pacotePadrao),validaDataFim($pacotePersonalizado,$pacotePadrao));

    /** Valor minimo do pacote sem os serviços opcionais */
    $valorBase =        floatval($pacotePadrao['pacote']['valorBase']) ;

    /** Valor da diaria de hospedagem multiplicado pelas diarias do pacote */
    if(validaHospedagem($pacotePersonalizado) == "true"){
        $valorHospedagem =  floatval($pacotePadrao['pacote']['valorHospedagem']) * $diarias  ;    
    } else {
        $valorHospedagem =  floatval(0) ;
    }

    /** Valor do Traslado */
    if(validaTraslado($pacotePersonalizado) == "true"){
        $valorTraslado =    floatval($pacotePadrao['pacote']['valorTraslado']);
    } else {
        $valorTraslado =  floatval(0) ;
    }

    /** Valor aereo */
    if( validaAereo($pacotePersonalizado) == "true"){
        $valorAereo =    floatval($pacotePadrao['pacote']['valorAereo']);
    } else {
        $valorAereo =  floatval(0) ;
    }

    $valorTotal =   $valorBase + $valorHospedagem + $valorTraslado + $valorAereo;

    return $valorTotal;    
}

function validaHospedagem($pacotePersonalizado){

    $hospedagem = null;

    if(!empty($pacotePersonalizado['hospedagem'])){
        $hospedagem = "true";
    } else{
        $hospedagem = "false";
    }

    return $hospedagem; 
}

function validaValorHospedagem($pacotePersonalizado,$pacotePadrao){

    $valorHospedagem = null;

    if(validaHospedagem($pacotePersonalizado)){
        $valorHospedagem = $pacotePadrao['pacote']['valorHospedagem'];
    } else{
        $valorHospedagem = floatval(0) ;
    }

    return $valorHospedagem; 
}

function validaAereo($pacotePersonalizado){

    $aereo = null;

    if(!empty($pacotePersonalizado['aereo'])){
        $aereo = "true";
    } else{
        $aereo = "false";
    }

    return $aereo; 
}

function validaValorAereo($pacotePersonalizado,$pacotePadrao){

    $valorAereo = null;

    if(validaAereo($pacotePersonalizado)){
        $valorAereo = $pacotePadrao['pacote']['valorAereo'];
    } else{
        $valorAereo = floatval(0) ;
    }

    return $valorAereo; 
}

/** Confirma um pedido */
function confirmaPedido(){

    if(isset($_GET['confirmaPedido'])){
        $id = $_GET['confirmaPedido'];

        /** Carrega pedido para alteração */
        $pedido = retornaPedidoPorID($id);

        /** Altera status para confirmado */
        $pedido['status'] = "Confirmado";

        update('PED','codPedido', $id , $pedido);

        $_SESSION['message'] = 'Pedido confirmado com sucesso.';
        $_SESSION['type'] = 'success';
    }

}

/** Confirma um pedido */
function cancelaPedido(){

    if(isset($_GET['cancelaPedido'])){
        $id = $_GET['cancelaPedido'];

        /** Carrega pedido para alteração */
        $pedido = retornaPedidoPorID($id);

        /** Altera status para confirmado */
        $pedido['status'] = "Cancelado";

        update('PED','codPedido', $id , $pedido);

        $_SESSION['message'] = 'Pedido Cancelado com sucesso.';
        $_SESSION['type'] = 'success';
    }

}



/****************
 *  UTILITARIOS *
 ****************/

 function retornaNomeSobrenomeUsuario($codigoCliente){
    $usuario   = find('USR', 'codigoUsuario', $codigoCliente, false);
    
    return $usuario['primeiroNome'] . " " . $usuario['ultimoNome'];
 }

 function retornaTituloPacote($codigoPacote){
    $pacote   = find('PCT', 'codPacote', $codigoPacote, false);
    
    return $pacote['titulo'];
 }

 function retornaPedidoPorID($codigoPedido){
    $pedido   = find('PED', 'codPedido', $codigoPedido, false);
    
    return $pedido;
 }

 function retornaPacotePorID($codigoPacote){
    $pacote   = find('PCT', 'codPacote', $codigoPacote, false);
    
    return $pacote;
 }
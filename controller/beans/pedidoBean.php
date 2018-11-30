<?php
require_once('../../config.php');
require_once(DBAPI);


//Cria o carrinho se não existir
if (!isset($_SESSION['carrinho'])) {
   $_SESSION['carrinho'] = array();
}

$carrinho = $_SESSION['carrinho'];

//Verifica se as variáveis vieram via POST, se for adiciona um novo item ao carrinho
if (isset($_POST['pedidoPersonalizado'])) {

    /** Se carrinho estiver vazio, adiciona item */
    if(empty($carrinho)){
        $carrinho[] = trataSolicitacaoPedidoPersonalizado();
        echo "O pacote esta vazio";
    } 
    /** Se carrinho não estiver vazio, verifica se item já esta incluido */
    else {

        /** Verifica se o item é novo */
        $itemNovo = true;
        foreach($carrinho as $item){
            if($item['codPacote'] == $_POST['pedidoPersonalizado']['codPacote']){
                $itemNovo = false;
            }
        }

        /** se for novo adiciona no carrinho */
        if($itemNovo){
            $carrinho[] = trataSolicitacaoPedidoPersonalizado();
            echo "Adiciona novo pacote";

        }

    }
}

//Salva na sessão
$_SESSION['carrinho'] = $carrinho;

echo " Carrinho: ";
var_dump($_SESSION['carrinho']);
echo " Pedido Personalizado: ";
var_dump($_POST['pedidoPersonalizado']);

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
        $valor = validaValor($pacotePersonalizado,$pacotePadrao);

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
            "codigoUsuario" => $codigoUsuario,
            "codPacote" => $codPacote,
            "dataInicio" => $dataInicio,
            "dataFim" => $dataFim,
            "traslado" => $traslado,
            "valorTraslado" => $valorTraslado,
            "quantidadeParcelas" => $parcelamento,
            "hospedagem" => $hospedagem,
            "valorHospedagem" => $valorHospedagem,
            "aereo" => $aereo,
            "valorAereo" => $valorAereo,
            "status" => "solicitado",
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
        $dataInicio = $pacotePersonalizado['dataInicio'];
    } else{
        $dataInicio = $pacotePadrao['pacote']['dataInicio'];
    }

    return $dataInicio;
}

function validaDataFim($pacotePersonalizado,$pacotePadrao){

    $dataFim = null;

    /** Verifica qual data usar */
    if(!empty($pacotePersonalizado['dataFim'])){
        $dataFim = $pacotePersonalizado['dataFim'];
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

    if($pacotePadrao['parcela'] == true){
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
    if(!empty($pacotePersonalizado['hospedagem'])){
        $valorHospedagem =  floatval($pacotePadrao['pacote']['valorHospedagem']) * $diarias  ;    
    } else {
        $valorHospedagem =  floatval(0) ;
    }
    
    /** Valor valor do traslado Hotel / Aeroporto */
    if(!empty($pacotePersonalizado['hospedagem'])){
        $valorTraslado =    floatval($pacotePadrao['pacote']['valorTraslado']);
    } else {
        $valorHospedagem =  floatval(0) ;
    }

    /** Valor valor do traslado Hotel / Aeroporto */
    if(!empty($pacotePersonalizado['aereo'])){
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
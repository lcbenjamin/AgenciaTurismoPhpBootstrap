<?php
require_once('../../config.php');
require_once(DBAPI);

$pacotePadrao = null;
$usuarioSolicitante = null;
$pacotePersonalizado = null;
$pacotesCarrinho  = null;

/** Carrega o pacote selecionado */
if(isset($_GET['id'])){
    $idPacote = $_GET['id'];
    global $pacotePadrao;
    $pacotePadrao = carregaDadosPacoteFull($idPacote);
}

/** Carrega usuário solicitante */
if(isset($_SESSION['logado'])){
    global $usuarioSolicitante;
    $usuarioSolicitante = $_SESSION['logado'];        
}

/** Carrega usuário solicitante */
if(isset($_POST['pedidoPersonalizado'])){
    global $pacotePersonalizado;
    $pacotePersonalizado = $_POST['pedidoPersonalizado'];        
}


echo nl2br("\n"."   INICIO PACOTE PADRAO:   ");
var_dump($pacotePadrao);
echo nl2br("\n"."   INICIO USUARIO SOLICITANTE:   ");
var_dump($usuarioSolicitante);
echo nl2br("\n"."    INICIO PACOTE PERSONALIZADO :   ");
var_dump($pacotePersonalizado);

function validaSolicitacaoPedidoPersonalizado(){

    echo "USUARIO: " .$usuarioSolicitante['codigoUsuario'];
    
    if(isset($_POST['pedidoPersonalizado'])){

        /** Define usuário */
        $codigoUsuario = $usuarioSolicitante['codigoUsuario'];
        
        /** Define codigo Pacote */
        $codPacote = $pacotePadrao['pacote']['codPacote'];
       
        /** Define data Ida do viagem */
        $dataInicio = validaDataInicio();
        
        /** Define data Ida do viagem */
        $dataFim = validaDataFim();

        /** Define Traslado */        
        $traslado = validaTraslado();

        /** Define Traslado */        
        $valorTraslado = validaValorTraslado();

        /** Define Parcelamento */        
        $parcelamento = validaParcelamento();

        /** Define Valor Total */        
        $valor = validaValor();

        /** Define Hospedagem */        
        $hospedagem = validaHospedagem();

        /** Define valor hospedagem */        
        $valorHospedagem = validaValorHospedagem();

        /** Define Aereo */        
        $aereo = validaAereo();

        /** Define valor Aereo */        
        $valorAereo = validaValorAereo();

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
        $pacotesCarrinho = $pedidoPersonalizado;
    }
}

/****************
 *  VALIDAÇÕES  *
 ****************/
function validaDataInicio(){

    $dataInicio = null;

    /** Verifica qual data usar */
    if(isset($pacotePersonalizado['dataInicio'])){
        $dataInicio = $pacotePersonalizado['dataInicio'];
    } else{
        $dataInicio = $pacotePadrao['pacote']['dataInicio'];
    }

    return $dataInicio;
}

function validaDataFim(){

    $dataFim = null;

    /** Verifica qual data usar */
    if(isset($pacotePersonalizado['dataFim'])){
        $dataFim = $pacotePersonalizado['dataFim'];
    } else{
        $dataFim = $pacotePadrao['pacote']['dataFim'];
    }

    return $dataFim; 
}

function validaTraslado(){

    $traslado = null;

    if(isset($pacotePersonalizado['traslado'])){
        $traslado = "true";
    } else{
        $traslado = "false";
    }

    return $traslado; 
}

function validaValorTraslado(){

    $valorTraslado = null;

    if(validaTraslado()){
        $valorTraslado = $pacotePadrao['pacote']['valorTraslado'];
    } else{
        $valorTraslado = floatval(0) ;
    }

    return $valorTraslado; 
}

function validaParcelamento(){

    $parcelamento = null;

    if(isset($pacotePadrao['parcela'])){
        $parcelamento = $pacotePersonalizado['quantidadeParcelas'];
    } else{
        $parcelamento = "0";
    }

    return $parcelamento; 
}

function validaValor(){

    $valorTotal = null;

    /** Calcula diarias */
    $diarias = caculaDiarias(validaDataInicio(),validaDataFim());

    /** Valor minimo do pacote sem os serviços opcionais */
    $valorBase =        floatval($pacotePadrao['pacote']['valorBase']) ;

    /** Valor da diaria de hospedagem multiplicado pelas diarias do pacote */
    if(isset($pacotePersonalizado['hospedagem'])){
        $valorHospedagem =  floatval($pacotePadrao['pacote']['valorHospedagem']) * $diarias  ;    
    } else {
        $valorHospedagem =  floatval(0) ;
    }
    
    /** Valor valor do traslado Hotel / Aeroporto */
    if(isset($pacotePersonalizado['hospedagem'])){
        $valorTraslado =    floatval($pacotePadrao['pacote']['valorTraslado']);
    } else {
        $valorHospedagem =  floatval(0) ;
    }

    /** Valor valor do traslado Hotel / Aeroporto */
    if(isset($pacotePersonalizado['aereo'])){
        $valorAereo =    floatval($pacotePadrao['pacote']['valorAereo']);
    } else {
        $valorAereo =  floatval(0) ;
    }

    $valorTotal =   $valorBase + $valorHospedagem + $valorTraslado + $valorAereo;

    return $valorTotal;    
}

function validaHospedagem(){

    $hospedagem = null;

    if(isset($pacotePersonalizado['hospedagem'])){
        $hospedagem = "true";
    } else{
        $hospedagem = "false";
    }

    return $hospedagem; 
}

function validaValorHospedagem(){

    $valorHospedagem = null;

    if(validaHospedagem()){
        $valorHospedagem = $pacotePadrao['pacote']['valorHospedagem'];
    } else{
        $valorHospedagem = floatval(0) ;
    }

    return $valorHospedagem; 
}

function validaAereo(){

    $aereo = null;

    if(isset($pacotePersonalizado['aereo'])){
        $aereo = "true";
    } else{
        $aereo = "false";
    }

    return $aereo; 
}

function validaValorAereo(){

    $valorAereo = null;

    if(validaAereo()){
        $valorAereo = $pacotePadrao['pacote']['valorAereo'];
    } else{
        $valorAereo = floatval(0) ;
    }

    return $valorAereo; 
}
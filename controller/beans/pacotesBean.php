<?php
require_once('../../config.php');
require_once(DBAPI);
$pacotes = null;
$pacote = null;

/**
 *  Carrega pacotes cadastrados
 */
function carrega_pacotes() {
	global $pacotes;
	$pacotes = find_all('PCT');
}

/**
 *  Adiciona um registro na tabela de Pacotes
 */
function salva_pacote($pacote) {	
		
    if(save('PCT', $pacote)){
        return true;
    } else {
        return false;
    }
}


/**
 *  Exclusão de um Pacote
 */
function deleta_pacote() {
	if(isset($_GET['idExcluir'])){
		$id = $_GET['idExcluir'];
        
        /** Remove pacote */
        remove('PCT','codPacote', $id);

        /** Remove relacionamento dos passeios associados */
        remove('RPP','PCT_codPacote', $id);

        /** Verifica as imagens associadas ao pacote e remove*/
        $imagensAssociadas = find('RPI', 'PCT_codPacote', $id, true); 

        /** Remove relacionamento das imagens associadas */
        remove('RPI','PCT_codPacote', $id);

        /** Remove as imagens do pacote */
        foreach($imagensAssociadas as $imagem){

            /** Remove arquivo físico da imagem */
            $caminhoAbsoluto = find('IMG','codImagem',$imagem['IMG_codImagem']);
            unlink($caminhoAbsoluto['caminho']);

            /** Remove no banco de dados */
            remove('IMG','codImagem', $imagem['IMG_codImagem']);

        }
        
	}
}


/**
 *	Valida a inclusão de um novo Pacote
 */
function validaInclusaoPacote(){

	if(isset($_POST['pacote'])){
		
        $pacote = $_POST['pacote'];
		$pacoteValido = true;

        /** Converte Valores do formulario */
        $pacote['valorBase'] =          converteStringParaFloat($pacote['valorBase']);
        $pacote['valorHospedagem'] =    converteStringParaFloat($pacote['valorHospedagem']);
        $pacote['valorTraslado'] =      converteStringParaFloat($pacote['valorTraslado']);
        $pacote['valorAereo'] =         converteStringParaFloat($pacote['valorAereo']);
        $pacote['dataInicio'] =         converteStringParaData($pacote['dataInicio']);
        $pacote['dataFim'] =            converteStringParaData($pacote['dataFim']);
        $pacote['parcela'] =            isset($pacote['parcela']) ? "true" : "false"; 
        $pacote['hospedagem'] =         isset($pacote['hospedagem']) ? "true" : "false";
        $pacote['traslado'] =           isset($pacote['traslado']) ? "true" : "false";
        $pacote['aereo'] =              isset($pacote['aereo']) ? "true" : "false";
        $pacote['quantidadeParcelas'] = isset($pacote['quantidadeParcelas']) ? (int) $pacote['quantidadeParcelas'] : (int) "0"; 
        $pacote['descricao'] =          nl2br($_POST['pacote']['descricao']);

        /*******************************
         *   Valida Basicos do Pacote  *
         *******************************/

		/** Valida Primeiro nome */
		if(validaTituloPacote($pacote['titulo'])){
            /** Valida Data Ida */            
            if(validaDataIda($pacote['dataInicio'])){
                /** Valida Data Volta */            
                if(validaDataVolta($pacote['dataFim'])){
                    /** Valida valor Base */            
                    if(validaValorBase($pacote['valorBase'])){
                        /** Valida UF Origem */            
                        if(validaUFOrigem($pacote['codEstadoOrigem'])){
                            /** Valida Cidade Origem */            
                            if(validaCidadeOrigem($pacote['codCidadeOrigem'])){
                                /** Valida UF Destino */ 
                                if(validaUFDestino($pacote['codEstadoDestino'])){
                                    /** Valida Cidade Destino */ 
                                    if(validaCidadeDestino($pacote['codCidadeDestino'])){
                                        /** Valida Quantidade Parcelas */ 
                                        if(validaQuantidaParcelas($pacote['quantidadeParcelas'])){

                                        }else {$pacoteValido = false;}
                                    }else {$pacoteValido = false;} 
                                }else {$pacoteValido = false;}                            
                            }else {$pacoteValido = false;}                            
                        }else {$pacoteValido = false;}
                    }else {$pacoteValido = false;}
                }else {$pacoteValido = false;}
            }else {$pacoteValido = false;}
        } else {$pacoteValido = false;}

		
		/** Caso todos os criterios de validação sejam aceitos ele salva o usuário na base */
		if($pacoteValido){
            
            /** Salva Pacote */
            $pacote['dataHoraCadastro'] = $date = date('Y-m-d H:i');
            $result = saveReturnID('PCT',$pacote);
            
            /** Salva Imagens e Salva Passeios*/
            if($result > 0){

                $idPacoteSalvo = $result;
                salvaImagensDoPacote($idPacoteSalvo);
                salvaPasseiosDoPacote($idPacoteSalvo);

            }            
		}
	}
}



/**
 *	Salva a foto do Perfil usuário
 */
function salvaImagensDoPacote($idPacote){

    /** Inicia variavel de incremento */
    $i = 0;

    /** Percorre a lista de imagens enviadas */
    foreach ($_FILES["imagemPacote"]["error"] as $key => $error) {

        if($_FILES["imagemPacote"]['size'][$i] > 0){

            /** capturas */
            $arquivo_tmp = $_FILES["imagemPacote"]['tmp_name'][$i];
            $nome 		 = $_FILES["imagemPacote"]['name'][$i];
            $tamanho 	 = $_FILES["imagemPacote"]['size'][$i];
            $tipo    	 = $_FILES["imagemPacote"]['type'][$i];

            /** Define propriedades */
            $extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
            $novoNome = uniqid (time()) . '.' . $extensao;
            $caminhoAbsoluto = SITE_RAIZ . 'view/imagens/img_pacotes/' . $novoNome;
            $descricao = "Foto de pacote de viagem";

            // tenta mover o arquivo para o servidor e salva imagem no banco
            if ( @move_uploaded_file ( $arquivo_tmp, $caminhoAbsoluto ) ) {

                /** Define objeto array que será salvo no banco */
                $imagem = array(
                    "caminho" => $caminhoAbsoluto,
                    "descricao" => $descricao,
                    "nome" => $novoNome,
                    "tamanho" => $tamanho,
                    "tipo" => $tipo,
                    "categoria" => 'Pacotes',
                    "dataHoraCadastro" => date('d-m-Y H:i')
                );

                /** Salva Imagem no banco */
                $id_salvo = saveReturnID('IMG', $imagem);

                /** Caso tenha sucesso, adiciona relacionamento PACOTE x Imagem na Base */
                if($id_salvo > 0){
                
                    $RPI = array(
                        "PCT_codPacote" => $idPacote,
                        "IMG_codImagem" => $id_salvo
                    );

                    save('RPI',$RPI);
                } 
                /** Caso falhe, exclui a imagem salva no servidor */
                else{
                    unlink($caminhoAbsoluto);
                    return false;
                }
            } 
            else {		
                $_SESSION['message'] = 'Erro ao salvar o arquivo.';
                $_SESSION['type'] = 'danger';
                return null;
            }    
        }

     ++$i;
   }
}

function salvaPasseiosDoPacote($idPacote){

    
    /** Inicia variavel de incremento */
    $i = 0;


    /** Percorre a lista de passeios enviados */
    foreach ($_POST["passeiosSelecionados"] as $key => $passeio) {

        $codPasseio =  $_POST["passeiosSelecionados"][$i];

        $passeio = array(
            "PAS_codPasseio" => $codPasseio,
            "PCT_codPacote" => $idPacote
        );
        
        /** Salva relacionamento Passeio e Pacote */
        save('RPP',$passeio);

        $i++;
    }

}


/****************************
 *      UTILITARIOS         *
 ****************************/

function converteStringParaFloat($valor){

    if(!empty($valor)){
        /** Remove simbolo moeda */
        $valorTratado = str_replace("R$ ","",$valor);

        /** Convertendo valor */
        $valorTratado = (float) str_replace(',', '.', str_replace('.', '', $valorTratado));
        return $valorTratado;        
    }
}

function converteStringParaData($valor){

    if(!empty($valor)){
        $arrayData = explode('/', $valor);
        $dia = $arrayData[0];
        $mes = $arrayData[1];
        $ano = $arrayData[2];

        $valorTratado = $ano ."-" . $mes . "-" . $dia;
        return $valorTratado;
    }
}
function converteCheckBox($valor){
    if(strcmp($valor,"true") != 0 ){

        return "false";
    }
}

function caculaDiarias($dataIncio,$dataFim){
   
    $data1 = $dataIncio;
    $data2 = $dataFim;
    // converte as datas para o formato timestamp
    $d1 = strtotime($data1); 
    $d2 = strtotime($data2);
    // verifica a diferença em segundos entre as duas datas e divide pelo número de segundos que um dia possui
    $dataFinal = ($d2 - $d1) /86400;
    // caso a data 2 seja menor que a data 1
    if($dataFinal < 0)
    $dataFinal = $dataFinal * -1;
    return $dataFinal;

}

function calculaValorTotalPacote($pacoteInformado){

    /** Inicia as variaveis de retorno */
    $diarias = null;
    $valorBase = null;
    $valorHospedagem = null;
    $valorTraslado = null;
    $valorAereo = null;

    /** Quantidade de dias de duração do pacote */
    $diarias = caculaDiarias($pacoteInformado['dataInicio'],$pacoteInformado['dataFim']);

    /** Valor minimo do pacote sem os serviços opcionais */
    $valorBase =        floatval($pacoteInformado['valorBase']) ;

    /** Valor da diaria de hospedagem multiplicado pelas diarias do pacote */
    if($pacoteInformado['hospedagem'] == "true"){
        $valorHospedagem =  floatval($pacoteInformado['valorHospedagem']) * $diarias  ;
    } else{
        $valorHospedagem = floatval(0);
    }
    
    /** Valor do traslado  */
    if($pacoteInformado['traslado'] == "true"){
        $valorTraslado =    floatval($pacoteInformado['valorTraslado']);
    } else{
        $valorTraslado = floatval(0);
    }
    
    /** Valor aereo */
    if($pacoteInformado['aereo'] == "true"){
        $valorAereo =       floatval($pacoteInformado['valorAereo']);
    } else{
        $valorAereo = floatval(0);
    }
    
    /** Soma todos os itens */
    $valorTotal =   $valorBase + $valorHospedagem + $valorTraslado + $valorAereo;
    return $valorTotal;    
}

function carregaPasseiosDoPacote($idPacote){
    $idsPasseio = find('RPP', 'PCT_codPacote', $idPacote, true );

    $i = 0;
    $passeiosAssociados = array();
    foreach ($idsPasseio as $key => $value) {
        
        array_push($passeiosAssociados, find('PAS', 'codPasseio', $value['PAS_codPasseio'], false ));
        
        $i++;
    }
    
    return $passeiosAssociados;
}

/** Retorna todos os dados associados ao pacote */
function carregaDadosPacoteFull($idPacote){

    $passeios = carregaPasseiosDoPacote($idPacote);

    $pacote = find('PCT', 'codPacote', $idPacote, false );

    $imagens = consultaIMGporIdPCT($idPacote);

    $dadosPacote = array(
        "imagens" => $imagens,
        "passeios" => $passeios,
        "pacote" => $pacote
    );
    
    return $dadosPacote;
}


/****************************
 * VALIDAÇÕES DE FORMULÁRIO *
 ****************************/

function validaTituloPacote($tituloPacote){
    /**Valida se o campo é vazio */
	if (empty($tituloPacote)) {
		$_SESSION['message'] = 'O campo "Titulo do Pacote" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se o campo contem apenas números */
	if(is_numeric($tituloPacote)){
		$_SESSION['message'] = 'O campo "Titulo do Pacote" não pode ser numerico';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se o campo tem no minimo 3 e no maximo 40 caracteres */
	if(mb_strlen($tituloPacote) < 3 || mb_strlen($tituloPacote)> 40) {
		$_SESSION['message'] = 'O campo "Titulo do pacote" não pode ter menos de 3 ou mais de 40 caracteres';
		$_SESSION['type'] = 'danger';
		return false;
	}

	return true;
}

function validaDataIda($dataIda){

    if($dataIda == NULL ){
        $_SESSION['message'] = 'O campo "Data Ida" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
    }

    if($dataIda < date('Y-m-d')){
        $_SESSION['message'] = 'O campo "Data Ida" não pode estar no passado';
		$_SESSION['type'] = 'danger';
		return false;
    }
	return true;
}

function validaDataVolta($dataVolta){

    if($dataVolta == NULL ){
        $_SESSION['message'] = 'O campo "Data Volta" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
    }

    if($dataVolta < date('Y-m-d')){
        $_SESSION['message'] = 'O campo "Data volta" não pode estar no passado';
		$_SESSION['type'] = 'danger';
		return false;
    }
	return true;
}

function validaValorBase($valorBase){

    /** Verifica se o campo esta vazio */
	if(empty($valorBase)){
		$_SESSION['message'] = 'O campo "Valor base" precisa ser preenchido';
		$_SESSION['type'] = 'danger';
		return false;
	}

    /** Verifica se o é numerico */
	if(!is_float($valorBase)){
		$_SESSION['message'] = 'O campo "Valor base" está inválido';
		$_SESSION['type'] = 'danger';
		return false;
    }
    
    /** Verifica se o campo tem no maximo 12 caracteres */
	if(mb_strlen($valorBase)> 12) {
		$_SESSION['message'] = 'O campo "Valor base" não pode ter mais de 12 caracteres';
		$_SESSION['type'] = 'danger';
		return false;
	}
    
    return true;
}

function validaUFOrigem($UF){

	if(strcmp($UF,"NA") == 0 ){
		$_SESSION['message'] = 'O campo "UF Origem" é obrigatório .';
		$_SESSION['type'] = 'danger';
		return false;
	}
	return true;
}

function validaUFDestino($UF){

	if(strcmp($UF,"NA") == 0 ){
		$_SESSION['message'] = 'O campo "UF Destino" é obrigatório .';
		$_SESSION['type'] = 'danger';
		return false;
	}
	return true;
}

function validaCidadeOrigem($cidade){
	
	if(strcmp($cidade,"NA") == 0 ){
		$_SESSION['message'] = 'O campo "Município origem" é obrigatório .';
		$_SESSION['type'] = 'danger';
		return false;
	}
	return true;
}

function validaCidadeDestino($cidade){

	if(strcmp($cidade,"NA") == 0 ){
		$_SESSION['message'] = 'O campo "Município Destino" é obrigatório .';
		$_SESSION['type'] = 'danger';
		return false;
	}

    return true;
}


function validaQuantidaParcelas($qtdParcelas){

	if($qtdParcelas > 12){
		$_SESSION['message'] = 'Erro no campo "Quantidade de Parcelas". O parcelament máximo é em 12 vezes';
		$_SESSION['type'] = 'danger';
		return false;
	}

    return true;
}
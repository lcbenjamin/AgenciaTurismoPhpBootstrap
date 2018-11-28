<?php
require_once('../../config.php');
require_once(DBAPI);
$passeios = null;
$passeio = null;

/**
 *  Carrega passeios cadastrados
 */
function carrega_passeios() {
	global $passeios;
	$passeios = find_all('PAS');
}

/**
 *  Adiciona um registro na tabela de PAS
 */
function salva_passeio($passeio) {	
		
	if(save('PAS', $passeio)){
		return true;
	} else {
		return false;
	}
}

/**
 *  Exclusão de um Passeio
 */
function deleta_passeio() {
	if(isset($_GET['idExcluir'])){
		$id = $_GET['idExcluir'];
		remove('PAS','codPasseio', $id);
	}
}

/**
 *	Atualizacao/Edicao de Passeio
 */
function editar_passeio() {
	if (isset($_GET['altera'])) {	
		
		
		/** Verifica se o passeio esta no POST */
		if (isset($_POST['passeio'])) {
			$passeio = $_POST['passeio'];
			$id = $_GET['id'];
		
		update('PAS','codPasseio',$id, $passeio);

		} else {
			global $passeio;
			$passeio = find('PAS', $id);
		} 
	}
}


/**
 *	Valida a inclusão de um novo passeio
 */
function validaInclusaoPasseio(){

	if(isset($_POST['passeio'])){
		
		$passeio = $_POST['passeio'];
		$passeioValido = true;
		$passeio['dataHoraCadastro'] = $date = date('d/m/Y H:i');
		salva_passeio($passeio);
	}
}	
<?php
require_once('../../config.php');
require_once(DBAPI);
$usuarios = null;
$usuario = null;

/**
 *  Carrega usuários cadastrados
 */
function carrega_usuarios() {
	global $usuarios;
	$usuarios = find_all('USR');
}

/**
 *  Adiciona um registro na tabela de usuário
 */
function salva_usuario($usuario) {	
		
		if(save('USR', $usuario)){
			return true;
		} else {
			return false;
		}
}

/**
 *	Atualizacao/Edicao de Usuário
 */
function editar_usuario() {
	if (isset($_GET['altera'])) {	
		
		
		/** Verifica se o usuário esta no POST */
		if (isset($_POST['usuario'])) {
			$usuario = $_POST['usuario'];
			$id = $_GET['id'];

		/** Verifica se a foto foi setada */
		if (isset($_FILES['fotoPerfil'])){
			$descricao = "Foto do usuário " . $usuario['primeiroNome'] . " ". $usuario['ultimoNome'];
			$id_imagem = salvaFotoPerfil($descricao);
			$usuario['codImagem'] = $id_imagem;	
		}
		
		update('USR','codigoUsuario',$id, $usuario);

		} else {
			global $usuario;
			$usuario = find('USR', $id);
		} 
	}
}

/**
 *  Exclusão de um Cliente
 */
function deleta_usuario() {
	if(isset($_GET['idExcluir'])){
		$id = $_GET['idExcluir'];
		remove('USR','codigoUsuario', $id);
	}
}

/**
 *	Valida a inclusão de um novo Usuário
 */
function validaInclusaoUsuario(){

	if(isset($_POST['usuario'])){
		
		$usuario = $_POST['usuario'];
		$usuarioValido = true;

		/** Valida Primeiro nome */
		if(validaPrimeiroNome($usuario['primeiroNome'])){
			/** Valida Sobrenome nome */
			if(validaSobrenome($usuario['ultimoNome'])){
				/** Valida CPF*/
				if(validaCPF($usuario['cpf'])){
					/** Valida Data Nascimento*/
					if(validaDataNascimento($usuario['dataNascimento'])){
						/** Valida Endereço*/
						if(validaEndereco($usuario['endereco'])){
							/** Valida CEP*/
							if(validaCEP($usuario['cep'])){
								/** Valida email*/
								if(validaEmail($usuario['email'])){
									/** Valida senha*/
									if(validaSenha($usuario['senha'])){
										/** Aplica MD5 a senha antes de salvar */
										$usuario['senha'] = md5($usuario['senha']);
										/** Valida a foto do Perfil */
										if(validaFotoPerfil()){

										} else {$usuarioValido = false;}
									} else {$usuarioValido = false;}
								} else {$usuarioValido = false;}									
							}	else {$usuarioValido = false;}
						}	else {$usuarioValido = false;}
					}	else {$usuarioValido = false;}
				}	else {$usuarioValido = false;}
			}	else {$usuarioValido = false;}
		} else {$usuarioValido = false;}

		
		/** Caso todos os criterios de validação sejam aceitos ele salva o usuário */
		if($usuarioValido){

			$descricao = "Foto do usuário " . $usuario['primeiroNome'] . " ". $usuario['ultimoNome'];
			$id_imagem = salvaFotoPerfil($descricao);
		
			/** Caso a foto não tenha sido salva gera um erro */
			if($id_imagem != null){
				/** Atribui foto salva ao ID do usuário */
				$usuario['codImagem'] = $id_imagem;

				/** Adiciona a data e hora do cadastro e salva Usuário */
				$usuario['dataHoraCadastro'] = $date = date('d/m/Y H:i');
				$result = salva_usuario($usuario);

				/** Caso tenha erro ao cadastrar usuário */
				// if(!$result){
				// 	remove('IMG','codImagem',$id_imagem);
				// } 

			}
		}

	}
}


/**
 *	Salva a foto do Perfil usuário
 */
function salvaFotoPerfil($descricao){

	/** capturas */
	$arquivo_tmp = $_FILES['fotoPerfil']['tmp_name'];
    $nome 		 = $_FILES['fotoPerfil']['name'];
	$tamanho 	 = $_FILES['fotoPerfil']['size'];
	$tipo    	 = $_FILES['fotoPerfil']['type'];

	/** Define propriedades */
	$extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
	
    $novoNome = uniqid (time()) . '.' . $extensao;
	$caminhoAbsoluto = SITE_RAIZ . 'view/imagens/img_usuarios/' . $novoNome;

	// tenta mover o arquivo para o servidor e salva imagem no banco
	if ( @move_uploaded_file ( $arquivo_tmp, $caminhoAbsoluto ) ) {

		/** Define objeto array que será salvo no banco */
		$imagem = array(
			"caminho" => $caminhoAbsoluto,
			"descricao" => $descricao,
			"nome" => $novoNome,
			"tamanho" => $tamanho,
			"tipo" => $tipo,
			"categoria" => 'fotoUsuario',
			"dataHoraCadastro" => date('d-m-Y H:i')
		);

		/** Salva Imagem no banco */
		$id_salvo = saveReturnID('IMG', $imagem);

		/** Caso tenha sucesso, retorna o ID da imagem no banco */
		if($id_salvo > 0){
			return $id_salvo;
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

function carrega_caminho_imagem($id){
	return $urlImagem = find('IMG', 'codImagem', $id, false) ;
	
}

/**
 * VALIDAÇÕES DE FORMULARIO
 */

function validaPrimeiroNome($primeiroNome){

	/**Valida se primeiro nome é vazio */
	if (empty($primeiroNome)) {
		$_SESSION['message'] = 'O campo "Primeiro nome" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se o nome contem apenas números */
	if(is_numeric($primeiroNome)){
		$_SESSION['message'] = 'O campo "Primeiro nome" não pode ser numerico';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se o nome tem no minimo 3 e no maximo 30 caracteres */
	if(mb_strlen($primeiroNome) < 3 || mb_strlen($primeiroNome)> 30) {
		$_SESSION['message'] = 'O campo "Primeiro nome" não pode ter menos de 3 ou mais de 30 caracteres';
		$_SESSION['type'] = 'danger';
		return false;
	}

	return true;
}

function validaSobrenome($sobrenome){

	/**Valida se o sobrenome é vazio */
	if (empty($sobrenome)) {
		$_SESSION['message'] = 'O campo "Sobrenome" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se o sobrenome contem apenas números */
	if(is_numeric($sobrenome)){
		$_SESSION['message'] = 'O campo "Sobrenome" não pode ser numerico';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se o sobrenome tem no minimo 3 e no maximo 30 caracteres */
	if(mb_strlen($sobrenome) < 3 || mb_strlen($sobrenome)> 30) {
		$_SESSION['message'] = 'O campo "Sobrenome" não pode ter menos de 3 ou mais de 30 caracteres';
		$_SESSION['type'] = 'danger';
		return false;
	}

	return true;
}
	
function validaCPF($cpf) {

	// Verifica se um número foi informado
	if(empty($cpf)) {
		$_SESSION['message'] = 'O campo "CPF" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
	}

	// Elimina possivel mascara
	$cpf = preg_replace("/[^0-9]/", "", $cpf);
	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
	
	// Verifica se o numero de digitos informados é igual a 11 
	if (strlen($cpf) != 11) {

		$_SESSION['message'] = 'O campo "CPF" está inválido';
		$_SESSION['type'] = 'danger';
		return false;
	}
	// Verifica se nenhuma das sequências invalidas abaixo 
	// foi digitada. Caso afirmativo, retorna falso
	else if ($cpf == '00000000000' || 
		$cpf == '11111111111' || 
		$cpf == '22222222222' || 
		$cpf == '33333333333' || 
		$cpf == '44444444444' || 
		$cpf == '55555555555' || 
		$cpf == '66666666666' || 
		$cpf == '77777777777' || 
		$cpf == '88888888888' || 
		$cpf == '99999999999') {

		$_SESSION['message'] = 'O campo "CPF" está inválido';
		$_SESSION['type'] = 'danger';

		return false;
		// Calcula os digitos verificadores para verificar se o
		// CPF é válido
		} else {   
		
		for ($t = 9; $t < 11; $t++) {
			
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf{$c} != $d) {

				$_SESSION['message'] = 'O campo "CPF" está inválido';
				$_SESSION['type'] = 'danger';
				return false;
			}
		}
	}

	return true;
}

function validaDataNascimento($dataNascimento){

	//Verifica se o usuário nasceu no futuro
	if(strcmp($dataNascimento,date('d/m/Y')) >= 0 ){
		$_SESSION['message'] = 'O campo "Data de nascimento" esta inválido. Você nasceu no Futuro?';
		$_SESSION['type'] = 'danger';
		return false;
	}

	//Verifica se o usuário nasceu hoje
	if(strcmp($dataNascimento,date('d/m/Y')) == 0 ){
		$_SESSION['message'] = 'O campo "Data de nascimento" esta inválido. Vai me dizer que você nasceu hoje?';
		$_SESSION['type'] = 'danger';
		return false;
	}

	//Verifica se o usuário nasceu hoje
	if($dataNascimento == null ){
		$_SESSION['message'] = 'O campo "Data de nascimento" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
	}
	return true;
}

function validaEndereco($endereco){

	/**Valida se endereço é vazio */
	if (empty($endereco)) {
		$_SESSION['message'] = 'O campo "Endereço" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se o endereço contem apenas números */
	if(is_numeric($endereco)){
		$_SESSION['message'] = 'O campo "Endereço" não pode ser apenas numérico';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se o endereço tem no minimo 3 e no maximo 100 caracteres */
	if(mb_strlen($endereco) < 3 || mb_strlen($endereco)> 100) {
		$_SESSION['message'] = 'O campo "Endereço" não pode ter menos de 3 ou mais de 100 caracteres';
		$_SESSION['type'] = 'danger';
		return false;
	}

	return true;
}

function validaCEP($cep){

	/**Valida se o CEP é vazio */
	if (empty($cep)) {
		$_SESSION['message'] = 'O campo "CEP" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se o CEP tem 10 caracteres */
	if(mb_strlen($cep) != 10) {
		$_SESSION['message'] = 'O campo "CEP" tem que ter 8 caracteres';
		$_SESSION['type'] = 'danger';
		return false;
	}

	return true;
}

function validaEmail($email){

	/**Valida se o email é vazio */
	if (empty($email)) {
		$_SESSION['message'] = 'O campo "email" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION['message'] = 'O campo "email" é inválido';
		$_SESSION['type'] = 'danger';
		return false;
	}

	return true;
}

function validaSenha($senha){

	/**Valida se a Senha é vazia */
	if (empty($senha)) {
		$_SESSION['message'] = 'O campo "senha" não pode ser vazio';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se a senha tem no minimo 4 e no maximo 16 caracteres */
	if(mb_strlen($senha) < 4 || mb_strlen($senha)> 16) {
		$_SESSION['message'] = 'O campo "Senha" não pode ter menos de 4 ou mais de 16 caracteres';
		$_SESSION['type'] = 'danger';
		return false;
	}

	return true;
}

function validaFotoPerfil(){

	/** Verifica se o upload da foto está vazio */
	if (!isset( $_FILES['fotoPerfil']['name'] ) ) {
		$_SESSION['message'] = 'O campo "Foto Perfil" não pode ser Vázio';
		$_SESSION['type'] = 'danger';
		return false;
	}
	
	/** Verifica se o upload da foto retornou erro */
	if($_FILES[ 'fotoPerfil' ][ 'error' ] != 0){
		$_SESSION['message'] = 'O campo "Foto Perfil" retornou um erro';
		$_SESSION['type'] = 'danger';
		return false;
	}

	/** Verifica se a extenção do arquivo é aceita */
	$extensao = strtolower(pathinfo($_FILES['fotoPerfil']['name'] , PATHINFO_EXTENSION ));
    if (!strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
		$_SESSION['message'] = 'O campo "Foto Perfil" Aceita apenas imagens dos tipos *.jpg;*.jpeg;*.gif;*.png ';
		$_SESSION['type'] = 'danger';
		return false;
	}

	return true;
}
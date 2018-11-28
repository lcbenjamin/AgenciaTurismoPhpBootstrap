<?php
require_once('../../config.php');
require_once(DBAPI);

/** Inclui Bean de usuário */
require_once('usuarioBean.php');

/**
 *	Valida a inclusão de um novo Usuário
 */

function validaLogin(){

	if(isset($_POST['login'])){
		$login = $_POST['login'];

        /**  Cria Hash da senha informada e seta alguns valores*/
        $senhaInformada = md5($login['senha']);
        $emailInformado = $login['email'];
        $usuarioValido = false;
        $usuarioConsultado = find('USR', 'email',$emailInformado , false ) ;

        /** Segue se a consulta retornar algum usuario na base */
        if($usuarioConsultado != null){

            /** Compara usuario e Senha informados com a base */
            if( (strcmp($usuarioConsultado['email'],$emailInformado)  == 0)
             && (strcmp($usuarioConsultado['senha'] , $senhaInformada)  == 0) ) {
                
                /** Salva usuario em uma SESSION é encaminha para o index.php */
                $id = $usuarioConsultado['codigoUsuario'];
                $_SESSION['logado'] = $usuarioConsultado; 
                header('Location: index.php');

            } else {
                /** Informa caso a senha email não sejam compativeis */
                $_SESSION['message'] = 'O email e senha estão incorretos'; 
                $_SESSION['type'] = 'danger';
            }

        } else {
            /** Informa caso usuário não exista na base */
            $_SESSION['message'] = 'Usuário não cadastrado'; 
            $_SESSION['type'] = 'danger';
        }


    
		
    }
}
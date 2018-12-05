<?php 

require_once('../../config.php');

function verificaLogadoCliente(){
	if(!isset($_SESSION['logado'])){

		/** Define pagina que chamou e encaminha para o login */
		$_SESSION['chamador'] = $_SERVER['PHP_SELF'];

		/** Encaminha para o login */
		echo("<script language='javascript'>parent.window.location.href='".BASEURL."view/front/login.php' </script>");

	}
}

function verificaLogadoAdministrador(){
	

	if( !isset($_SESSION['logado']) ){
	
		/** Define pagina que chamou e encaminha para o login */
		$_SESSION['chamador'] = $_SERVER['PHP_SELF'];

		/** Encaminha para o login */
		echo("<script language='javascript'>parent.window.location.href='".BASEURL."view/front/login.php' </script>");

	} elseif ($_SESSION['logado']['codPerfil'] != "2" ){

		/** Encaminha para o login */
		echo("<script language='javascript'>parent.window.location.href='".BASEURL."view/painelUsuario/painelUsr.php' </script>");
	}

}
?>
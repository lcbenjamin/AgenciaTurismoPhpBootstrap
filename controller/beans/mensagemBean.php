<?php 

/**
 *  Carrega Mensagens
 */
function carrega_mensagens() {
	global $mensagens;
	$mensagens = find_all('MSG');
}

/**
 *  Carrega mensagem
 */
function carrega_mensagem($id) {
	
	return $mensagem = find('MSG','codMensagem', $id, false );
}
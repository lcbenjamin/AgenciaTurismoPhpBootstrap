<?php 

/**
 *  Carrega Mensagens
 */
function carrega_mensagens() {
	global $mensagens;
	$mensagens = find_all('MSG');
}
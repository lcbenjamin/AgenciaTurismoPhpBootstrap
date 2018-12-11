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

function enviaMensagem(){

    if(isset($_POST['mensagem'])){
        $mensagem = $_POST['mensagem'];
        $mensagem['mensagem'] = nl2br($_POST['mensagem']['mensagem']);
        save('MSG', $_POST['mensagem']);
        echo "<script>alert('Mensagem enviada com sucesso!');</script>";
    }
}
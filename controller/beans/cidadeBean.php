<?php
require_once('../../config.php');
require_once(DBAPI);
$cidades = null;
$estado = null;

/**
 *  Listagem de cidades
 */
function carrega_cidade() {
    global $cidades;
    $estado = $_POST['estado'];
	$cidades = find_all('CID','codEstado',$estado);
}

function carrega_cidade_id($id_cidade){   
    return $cidade = find( 'CID', 'codCidade', $id_cidade);
    
}


//recebe via GET o valor do id do estado
if (isset($_GET['search'])) {
    $cod_estado = $_GET['search'];
    $cidades_por_estado = find('CID','codEstado',$cod_estado,true);    

    //faz um loop para montar linha por linha da combo de cidade
    foreach ($cidades_por_estado as $cidade) :
        // devolvendo a linha HTML para o javascript e montar no append
        echo "<option value='" . $cidade['codCidade'] . "' >" . $cidade['nome'] . "</option>";
    endforeach;
}



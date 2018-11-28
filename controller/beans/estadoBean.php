<?php
require_once('../../config.php');
require_once(DBAPI);
$estados = null;

/**
 *  Listagem de Estados
 */
function carrega_estados() {
	global $estados;
    $estados = find_all('EST');
}

function carrega_estado_id($id_estado){
    return $estado = find( 'EST', 'codEstado', $id_estado);
}
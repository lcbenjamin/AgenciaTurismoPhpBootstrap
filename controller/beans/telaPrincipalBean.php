<?php
require_once('../../config.php');
require_once(DBAPI);
require_once('../../controller/beans/pacotesBean.php');


function carregaDadosPacote(){
    
    $pacotes = find_all('PCT');
    $imagens = find('IMG', 'categoria', 'Pacotes',true);

    $pacote['imagensRelacionadas'] = array();
    $arrayTeste = array();

    foreach($pacotes as $pacote){
        //array_push($pacote['imagensRelacionadas'], find('RPI', 'PCT_codPacote', $pacote['codPacote'],true) );

        $arrayTeste =  find('RPI', 'PCT_codPacote', $pacote['codPacote'],true);

        var_export(array_merge($pacote['imagensRelacionadas'], $arrayTeste), true);
    }

    var_dump($pacotes);

}

function trataMensagemRodape(){

    if(isset($_POST['email'])){
        $mensagem = $_POST['email'];
        save('MSG',$mensagem);
    }
}
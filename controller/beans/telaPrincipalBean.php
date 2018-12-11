<?php
require_once('../../config.php');
require_once(DBAPI);
require_once('../../controller/beans/pacotesBean.php');

/**
 *  Função que é chamada na pagina principal para carregar os pacotes
 */
function carregaDadosPacote(){
    
    $pacotes = find_all('PCT');
    $imagens = find('IMG', 'categoria', 'Pacotes',true);

    $pacote['imagensRelacionadas'] = array();
    $arrayTeste = array();

    foreach($pacotes as $pacote){

        $arrayTeste =  find('RPI', 'PCT_codPacote', $pacote['codPacote'],true);

        var_export(array_merge($pacote['imagensRelacionadas'], $arrayTeste), true);
    }

    var_dump($pacotes);

}

function trataMensagemRodape(){

    if(isset($_POST['email'])){
        $mensagem['identificacao'] = $_POST['email']['identificacao'];
        $mensagem['mensagem'] = nl2br($_POST['email']['mensagem']);
        $mensagem['dataHoraCadastro'] =  date('Y/m/d H:i');
        $mensagem['status'] = "Não Lida";
        
        if(isset( $_SESSION['logado'])){
            $mensagem['codigoUsuario'] = $_SESSION['logado']['codigoUsuario'];
        } else {
            $mensagem['codigoUsuario'] = "0";
        }
        save('MSG',$mensagem);

        echo "<script>alert('Mensagem enviada com sucesso!');</script>";
    }
}
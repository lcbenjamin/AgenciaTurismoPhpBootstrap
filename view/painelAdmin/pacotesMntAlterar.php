
<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    
    /** Inclusão do controller */
    require_once('../../controller/beans/pacotesBean.php');

    /** Inclusão dos controllers Auxiliares */
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');
    require_once('../../controller/beans/passeioBean.php');



    /** Funções de carga */
    if(isset($_GET['id'])){
        $pacote = carregaDadosPacoteFull($_GET['id']);
    }   
    
    carrega_estados();
    carrega_passeios();
    
    /** Valida pacote antes de persistir na base */
    
?>
        
<hr />
<div class="bg-gradient-light py-1 pl-1 align-middle" >
  <h4>Desculpe, funcionalidade disponivel em breve</h4>
</div>
<hr />

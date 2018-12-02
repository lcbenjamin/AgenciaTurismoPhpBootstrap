<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;

    require_once('../../controller/beans/pacotesBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');
    require_once('../../controller/beans/telaPrincipalBean.php');
    carrega_pacotes();

?>
    

<!-- Pacotes nacionais-->
<div class="row" id="tituloPrincipal">
    <div class="col-12 text-left my-3">
    <h2 class="display-6 text-dark">
            <i class="fa fa-suitcase mr-2"></i>    
            <u>Pacotes nacionais</u>
    </h2>
    </div>
</div>

<div class="row mb-5">
    <?php foreach ($pacotes as $pacote) : ?>
        <!-- Consulta as imagens associadas ao pacote -->
        <?php $imagensPacote = consultaIMGporIdPCT($pacote['codPacote']); ?>
    
        <div class="col-sm-3">
            <div class="card my-3">
                <img src="../imagens/img_pacotes/<?php echo $imagensPacote[1]['nome']; ?>" class="card-img-top">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $pacote['titulo']; ?></h4>
                    <h6 class="card-title mb-2 text-muted"><?php echo caculaDiarias($pacote['dataInicio'],$pacote['dataFim']) . " Dias" ; ?></h6>
                    <p class="card-text">
                        <?php
                            echo "Por apenas R$ " . 
                            number_format(calculaValorTotalPacote($pacote), 2, ',', '.') . "<br>" ;
                            if($pacote['parcela']){
                                echo " em " . $pacote['quantidadeParcelas'] . " parcelas";
                            } else {
                                echo "A vista";
                            }
                        ?>
                    </p>                    
                    <div class="card-body text-right">
                        <a href="./index.php?p=detalhePacote&id=<?php echo $pacote['codPacote'];?>" class="btn btn-secondary">Eu quero!</a>
                    </div>
                </div>
            </div>
        </div>
        
    <?php endforeach ; ?>
</div>
<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/pacotesBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');
    require_once('../../controller/beans/mensagemBean.php');

    require_once('../../controller/verificaLogado.php');
    verificaLogadoCliente();
    enviaMensagem();
    
    /** Carrega o pacote selecionado */
    if(isset($_GET['id'])){
        $idPacote = $_GET['id'];
        $pacoteSelecionado = carregaDadosPacoteFull($idPacote);
    }

?>
<div id="ancora"></div>
<form action="./index.php?p=carrinho" method="post">
<div class="row">
    <!-- Coluna esquerda -->
    <div class="col-md-8">

        <!-- Carrousel -->
        <div id="carouselDetalhePacote" class="carousel slide" data-ride="carousel">

            <!-- Controles central de troca de item-->
            <ol class="carousel-indicators">
                <li data-target="#carouselDetalhePacote" data-slide-to="0" class="active"></li>
                <li data-target="#carouselDetalhePacote" data-slide-to="1" class="active"></li>
                <li data-target="#carouselDetalhePacote" data-slide-to="2" class="active"></li>
                <li data-target="#carouselDetalhePacote" data-slide-to="3" class="active"></li>
            </ol>

            <!-- Imagens do carousel e legenda -->
            <div class="carousel-inner ">
                <?php $i = 0; 
                      foreach($pacoteSelecionado['imagens'] as $imagem => $value) : 
                        if($i == 0) {
                            echo '
                            <div class="carousel-item active">
                                <img src="../imagens/img_pacotes/'.$value['nome'].'" class="img-fluid d-block mx-auto">
                            </div>';
                        } else {
                            echo '
                            <div class="carousel-item">
                                <img src="../imagens/img_pacotes/' . $value['nome'] .'" class="img-fluid d-block mx-auto">
                            </div>';
                        }
                        $i++;
                      endforeach; ?>
            </div>

            <!--Controle de retroceder o carrosel -->
            <a class="carousel-control-prev" href="#carouselDetalhePacote" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="sr-only">Anterior</span>
            </a>

            <!--Controle de avançar o carrosel -->
            <a class="carousel-control-next" href="#carouselDetalhePacote" role="button" data-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="sr-only">Avançar</span>
            </a>

        </div> <!-- Fim Carrousel -->

    <!-- Corpo de detalhes sobre o pacote -->
    <div class=" bg-light px-3 py-4">
        <h5><b>Sobre o pacote</b></h5>
        
        <!-- Descrição -->
        <p><?php echo $pacoteSelecionado['pacote']['descricao'];?></p>
        
        <!-- Destino -->
        <p>
            Com destino a cidade de <b>
            <?php   echo carrega_cidade_id($pacoteSelecionado['pacote']['codCidadeDestino'])['nome'] . " / " .
                    carrega_estado_id($pacoteSelecionado['pacote']['codEstadoDestino'])['uf']; ?>
            </b>
        </p>

        <!-- Destino -->
        <p>
            Saindo opcionalmente da cidade de <b>
            <?php   echo carrega_cidade_id($pacoteSelecionado['pacote']['codCidadeOrigem'])['nome'] . " / " .
                    carrega_estado_id($pacoteSelecionado['pacote']['codEstadoOrigem'])['uf']; ?>
            </b>
        </p>


        <!-- Passeios -->
        <p> 
            <b>Passeios incluidos </b><br>
            <ul>
                <?php foreach($pacoteSelecionado['passeios'] as $passeio):?>
                    <li><?php echo $passeio['titulo']?></li>
                <?php endforeach;?>
            </ul>
        </p>

        <!-- Hospedagem -->
        <p> 
            <?php if($pacoteSelecionado['pacote']['hospedagem'] == "true"):?>
                <b>Hospedagem</b><br>
                Hospedagem para 1 pessoa durante todo o período do pacote
                por apenas R$ <?php echo number_format($pacoteSelecionado['pacote']['valorHospedagem'], 2, ',', '.'); ?> 
                por dia em um dos melhores hoteis da região!
            <?php endif;?>
        </p>

        <!-- Traslado -->
        <p> 
            <?php if($pacoteSelecionado['pacote']['traslado'] == "true"):?>
                <b>Traslado</b><br>
                Não se preocupe, nos te pegamos e deixamos no aeroporto!
                por apenas R$ <?php echo number_format($pacoteSelecionado['pacote']['valorTraslado'], 2, ',', '.'); ?> 
                comodidade e segurança é a nossa marca!
            <?php endif;?>
        </p>

        <!-- Transporte aéreo -->
        <p> 
            <?php if($pacoteSelecionado['pacote']['traslado'] == "true" ):?>
                <b>Transporte Aéreo</b><br>
                Em um voô saindo de 
                
                <?php   echo carrega_cidade_id($pacoteSelecionado['pacote']['codCidadeOrigem'])['nome'] . " / " .
                             carrega_estado_id($pacoteSelecionado['pacote']['codEstadoOrigem'])['uf']; ?>
                
                por apenas R$ <?php echo number_format($pacoteSelecionado['pacote']['valorAereo'], 2, ',', '.'); ?> 
                comprando seu pacote com 15 dias de antecedência
            <?php endif;?>
        </p>
        
        <!-- Custo do pacote -->
        <p> 
            <b>Quanto custa tudo isso?</b><br>
            Tudo isso por apenas 
            <b> 
                R$ <?php echo number_format(calculaValorTotalPacote($pacoteSelecionado['pacote']), 2, ',', '.'); ?> 
            </b>
            em <?php echo $pacoteSelecionado['pacote']['quantidadeParcelas']?> x sem juros!
        </p><br/>

        <!-- Botão de comprar -->
        <center>
            <button type="submit" class="btn btn-success">Adicionar pacote ao carrinho</button>
        </center>
    </div>

</div>
   
    <!-- Coluna Direita -->
    <div class="col-md-4">

        <!-- Caixa de titulo ----------------------------------->
        <div class="bg-dark text-white" id="caixa-detalhe-tit-pacote">
                <div id="titulo-detalhe-pacote">  
                    <h3>
                        <?php echo $pacoteSelecionado['pacote']['titulo'] ; ?>
                    </h3>
                </div>
                <div id="diarias-detalhe-pacote">
                    
                    <h4>
                    <i class="fa fa-hotel"></i>  <?php echo caculaDiarias($pacoteSelecionado['pacote']['dataInicio'], $pacoteSelecionado['pacote']['dataFim']) . " Diarias"; ?>
                    </h4>
                </div>
        </div>
        
        <!-- Serviços inclusos ----------------------------------->
        
        <h5 class="mt-3">
            <i class="fa fa-check"></i>  O que o pacote inclui
        </h5>
        <hr id="hr-detalhe-pacote"/>
        
        <center>
            <?php
                if($pacoteSelecionado['pacote']['traslado'] == "true"){
                    echo '<i title="Traslado" class="fa fa-bus mx-4 fa-2x"></i>';
                }
                if($pacoteSelecionado['pacote']['hospedagem']  == "true"){
                    echo '<i title="Hospedagem" class="fa fa-hotel mx-4 fa-2x"></i>';
                }
                if($pacoteSelecionado['pacote']['aereo']  == "true"){
                    echo ' <i title="Passagem Aérea" class="fa fa-plane mx-4 fa-2x"></i>';
                }
                if( ($pacoteSelecionado['pacote']['traslado'] == "false") &&
                    ($pacoteSelecionado['pacote']['hospedagem']  == "false") &&
                    ($pacoteSelecionado['pacote']['aereo']  == "false")){
                    
                        echo '<i title="Passagem Aérea" class="fa fa-ban mx-4 fa-2x"></i>' ;
                    
                }

            ?>
        </center>



        <!-- Personalização de pacote ----------------------------------->
        <h5 class="bg-dark text-light py-2 pl-2 my-4">
        <i class="fa fa-cogs fa-1x"></i>
            Personalise seu pacote
        </h5>
        
        <input type="hidden" name="pedidoPersonalizado[codPacote]" value="<?php echo $pacoteSelecionado['pacote']['codPacote']?>" />
        <div class="row">
        
            <!-- Data Ida-->
            <div class="form-group col-md-6">
                <label for="dataIda"><b>Data Ida *</b></label>
                <div class="input-group">
                    <input type="text" class="form-control dataFormatada"  name="pedidoPersonalizado[dataInicio]" placeholder="<?php echo date('d/m/Y', strtotime($pacoteSelecionado['pacote']['dataInicio']));?>" aria-describedby="basic-addon2" id="dataIda" maxlength="10">
                    <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>

            <!-- Data Volta-->
            <div class="form-group col-md-6">
                <label for="dataVolta"><b>Data Volta *</b></label>
                <div class="input-group">
                    <input type="text" class="form-control dataFormatada"  name="pedidoPersonalizado[dataFim]" placeholder="<?php echo date('d/m/Y', strtotime($pacoteSelecionado['pacote']['dataFim']));?>" aria-describedby="basic-addon2" id="dataVolta" maxlength="10">
                    <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>

            <!-- Parcelamento -->  
            <?php if($pacoteSelecionado['pacote']['parcela']  == "true") : ?>  
                <div class="form-group col-md-12">
                    <label for="cidade_origem"><b>Parcelamento</b></label>
                    <select class="custom-select" name="pedidoPersonalizado[quantidadeParcelas]">
                        <?php for($i = 1 ; $i <= $pacoteSelecionado['pacote']['quantidadeParcelas']; $i ++ ):?>
                            <?php if($i == $pacoteSelecionado['pacote']['quantidadeParcelas'] ):?>
                                <option value="<?php echo $i ?>" selected ><?php echo $i ?> x sem juros </option>
                            <? else :?>
                                <option value="<?php echo $i ?>"><?php echo $i ?> x sem juros </option>
                            <? endif; ?>
                        <?php endfor;?>
                    </select>
                </div>
            <? endif;?>

            <!-- Traslado ----------------------------->
            <?php if($pacoteSelecionado['pacote']['traslado']  == "true") : ?>  
                <div class="form-group col-md-12">
                    <label for="traslado"><b>Traslado</b></label>
                    <div class="input-group col-mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">        
                                <input  type="checkbox" value="true" name="pedidoPersonalizado[traslado]" checked>
                            </div>
                        </div>
                        <input type="text" class="form-control" style="background-color: #ffffff;"  
                               placeholder="Custo adicional do serviço<?php echo " R$ " . number_format($pacoteSelecionado['pacote']['valorTraslado'], 2, ',', '.'); ?>" disabled>
                    </div>
                </div>
            <? else :?>
                <div class="form-group col-md-12">
                    <label for="traslado"><b>Traslado</b></label>
                    <div class="input-group col-mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">        
                                <input  type="checkbox" value="true" name="pedidoPersonalizado[traslado]">
                            </div>
                        </div>
                        <input type="text" class="form-control" style="background-color: #ffffff;"  
                               placeholder="Incluir serviço por<?php echo " R$ " . number_format($pacoteSelecionado['pacote']['valorTraslado'], 2, ',', '.'); ?>" disabled>
                    </div>
                </div>
            <? endif;?>    

            <!-- Hospedagem ----------------------------->
            <?php if($pacoteSelecionado['pacote']['hospedagem']  == "true") : ?>  
                <div class="form-group col-md-12">
                    <label for="traslado"><b>Hospedagem</b></label>
                    <div class="input-group col-mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">        
                                <input  type="checkbox" value="true" name="pedidoPersonalizado[hospedagem]" checked>
                            </div>
                        </div>
                        <input type="text" class="form-control" style="background-color: #ffffff;"  
                               placeholder="Custo adicional do serviço<?php echo " R$ " . number_format($pacoteSelecionado['pacote']['valorHospedagem'], 2, ',', '.'); ?>" disabled>
                    </div>
                </div>
            <? else :?>
                <div class="form-group col-md-12">
                    <label for="traslado"><b>Hospedagem</b></label>
                    <div class="input-group col-mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">        
                                <input  type="checkbox" value="true" name="pedidoPersonalizado[hospedagem]">
                            </div>
                        </div>
                        <input type="text" class="form-control" style="background-color: #ffffff;"  
                               placeholder="Incluir serviço por<?php echo " R$ " . number_format($pacoteSelecionado['pacote']['valorHospedagem'], 2, ',', '.'); ?>" disabled>
                    </div>
                </div>
            <? endif;?>    

            <!-- Transporte Arérop ----------------------------->
            <?php if($pacoteSelecionado['pacote']['aereo']  == "true") : ?>  
                <div class="form-group col-md-12">
                    <label for="traslado"><b>Transporte Aéreo</b></label>
                    <div class="input-group col-mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">        
                                <input  type="checkbox" value="true" name="pedidoPersonalizado[aereo]" checked>
                            </div>
                        </div>
                        <input type="text" class="form-control" style="background-color: #ffffff;"  
                               placeholder="Custo adicional do serviço<?php echo " R$ " . number_format($pacoteSelecionado['pacote']['valorAereo'], 2, ',', '.'); ?>" disabled>
                    </div>
                </div>
            <? else :?>
                <div class="form-group col-md-12">
                    <label for="traslado"><b>Transporte Aéreo</b></label>
                    <div class="input-group col-mb-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">        
                                <input  type="checkbox" value="true" name="pedidoPersonalizado[aereo]">
                            </div>
                        </div>
                        <input type="text" class="form-control" style="background-color: #ffffff;"  
                               placeholder="Incluir serviço por<?php echo " R$ " . number_format($pacoteSelecionado['pacote']['valorAereo'], 2, ',', '.'); ?>" disabled>
                    </div>
                </div>
            <? endif;?>  


        </div>
    </form>

    <hr id="hr-detalhe-pacote"/>
    
    <!-- Mensagem de ajuda ----------------------------------->
    <h6 class="bg-dark text-light py-2 pl-2 mt-3">
        <i class="fa fa-info-circle fa-1x"></i>
        &nbspFicou com duvida sobre esse pacote?<br>&nbsp&nbsp&nbsp&nbsp A gente te ajuda
    </h6>
    <form action="#" method="post">
        <input name="mensagem[codigoUsuario]" type="hidden" value="<?php echo $_SESSION['logado']['codigoUsuario']; ?>">
        <input name="mensagem[identificacao]" type="hidden" value="<?php echo $_SESSION['logado']['email']; ?>">
        <input name="mensagem[codPacote]" type="hidden" value="<?php echo $pacoteSelecionado['pacote']['codPacote']; ?>">
        <input name="mensagem[status]" type="hidden" value="Não Lida">
        <input name="mensagem[dataHoraCadastro]" type="hidden" value="<?php echo date('Y/m/d H:i')?>">
        
        <div class="form-group col-md-13 mt-3">
            <div class="form-group">
            <label for="comment">Escreva sua mensagem:</label>
            <textarea class="form-control" rows="5" id="comment" placeholder="Te responderemos o mais breve possível" name="mensagem[mensagem]"></textarea>
            </div> 
        </div>
          <!-- Botões -->
        <div id="actions" class="row text-right mt-4">
            <div class="col-md-12">
            <button type="reset" class="btn btn-info">Limpar</button>
            <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </form>
    </div>

</div>

<!-- Inclusão dos Modulos JavaScrips -->
<script src="../../node_modules/jquery/dist/jquery.js"></script>
<script src="../../node_modules/popper.js/dist/umd/popper.js"></script>
<script src="../../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="../../node_modules/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../../controller/scripts/main.js"></script>
<script src="../../controller/scripts/mascaras.js"></script>


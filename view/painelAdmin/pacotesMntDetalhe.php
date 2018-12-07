<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/pacotesBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');
    carrega_pacotes();

    $id = $_GET['id'];
    
    $imagensPacote = consultaIMGporIdPCT($id);

    foreach ($pacotes as $pacote) :
    if($pacote['codPacote']== $id)	{ 
?>



<!-- Navegador da Pagina-->
<hr>
<header>
	<div class="row">
		<div class="col-sm-7 pt-2">
		<h4>Pacotes > Consultar > <b>Detalhe </b></h4>
		</div>
		<div class="col-sm-5 text-right h2">
	    	<a class="btn btn-warning" href="./painelAdm.php?adm=pacotesMntAlterar&id=<?php echo $pacote['codPacote'];?>"><i class="fa fa-pencil"></i></i> Editar</a>
	    	<a class="btn btn-info" href="./painelAdm.php?adm=pacotesMnt"><i class="fa fa-backward"></i> Voltar</a>
	    </div>
	</div>
</header>
<hr>

<div class="row">
    <div class="col-sm-9 text-left">
        
        <section class="mb-3">
            <div>
                <?php foreach($imagensPacote as $imagem => $value) : ?>
                
                    <a class="example-image-link" href="../imagens/img_pacotes/<?php echo $value['nome']; ?>" data-lightbox="example-set" data-title="">
                        <img class="example-image" src="../imagens/img_pacotes/<?php echo $value['nome']; ?>"/>
                    </a>

                <?php endforeach; ?>                    
            </div>
        </section>
        <hr>
        <h3 class="mb-3 text-left"><?php echo $pacote['titulo'] . " - " . caculaDiarias($pacote['dataInicio'],$pacote['dataFim']) . " dias";?></h3>

        <table class="table table-hover text-left table-bordered table-striped table-sm">

            <!-- Conteudo -->
            <tbody>
                <tr>		
                    <td class="col-sm-4"><b>Código do Pacote</b></td>
                    <td><?php echo $pacote['codPacote']; ?></td>
                </tr>
                <tr>		
                    <td><b>Titulo</b></td>
                    <td><?php echo $pacote['titulo']; ?></td>
                </tr>
                <tr>		
                    <td><b>Data Inicio</b></td>
                    <td><?php echo date('d/m/Y', strtotime($pacote['dataInicio'])); ?></td>
                </tr>
                <tr>		
                    <td><b>Data fim</b></td>
                    <td><?php echo date('d/m/Y', strtotime($pacote['dataFim'])); ?></td>
                </tr>
                <tr>		
                    <td><b>Diarias</b></td>
                    <td><?php echo caculaDiarias($pacote['dataInicio'],$pacote['dataFim']) ?></td>
                </tr>
                <tr>		
                    <td><b>Origem do pacote [UF/Cidade]</b></td>
                    <td>
                        <?php 
                            echo    carrega_estado_id($pacote['codEstadoOrigem'])['nome'] ." / ".
                                    carrega_cidade_id($pacote['codCidadeOrigem'])['nome'];
                        ?>
                    </td>
                </tr>
                <tr>		
                    <td><b>Destino do pacote [UF/Cidade]</b></td>
                    <td>
                        <?php 
                            echo    carrega_estado_id($pacote['codEstadoDestino'])['nome'] ." / ".
                                    carrega_cidade_id($pacote['codCidadeDestino'])['nome'];
                        ?>
                    </td>
                </tr>
                <tr>		
                    <td><b>Descrição</b></td>
                    <td><pre><?php echo $pacote['descricao']; ?></pre></td>
                </tr>
                <tr>		
                    <td><b>Valor Base</b></td>
                    <td ><?php echo 'R$ ' . number_format($pacote['valorBase'], 2, ',', '.');?></td>
                </tr>
                <tr>		
                    <td><b>Valor Hospedagem/dia</b></td>
                    <td ><?php echo 'R$ ' . number_format($pacote['valorHospedagem'], 2, ',', '.');?></td>
                </tr>
                <tr>		
                    <td><b>Valor Traslado</b></td>
                    <td ><?php echo 'R$ ' . number_format($pacote['valorTraslado'], 2, ',', '.');?></td>
                </tr>
                <tr>		
                    <td><b>Valor Passagem Aérea</b></td>
                    <td ><?php echo 'R$ ' . number_format($pacote['valorAereo'], 2, ',', '.');?></td>
                </tr>
                <tr>		
                    <td><b>Pode parcelar?</b></td>
                    <?php if ($pacote['parcela']=="true") : ?>
                        <td>Sim</td>
                    <?php endif; ?>
                    <?php if ($pacote['parcela']=="false") : ?>
                        <td>Não</td>
                    <?php endif; ?>
                </tr>
                <tr>		
                    <td><b>Quantidade de parcelas</b></td>
                    <?php if ($pacote['parcela']=="true") : ?>
                        <td><?php echo $pacote['quantidadeParcelas'] . " vezes"; ?></td>
                    <?php endif; ?>
                    <?php if ($pacote['parcela']=="false") : ?>
                        <td>--</td>
                    <?php endif; ?>
                </tr>
                <tr>		
                    <td><b>Hospedagem incluida?</b></td>
                    <?php if ($pacote['hospedagem']=="true") : ?>
                        <td>Sim</td>
                    <?php endif; ?>
                    <?php if ($pacote['hospedagem']=="false") : ?>
                        <td>Não</td>
                    <?php endif; ?>
                </tr>
                <tr>		
                    <td><b>Traslado incluido?</b></td>
                    <?php if ($pacote['traslado']=="true") : ?>
                        <td>Sim</td>
                    <?php endif; ?>
                    <?php if ($pacote['traslado']=="false") : ?>
                        <td>Não</td>
                    <?php endif; ?>
                </tr>
                <tr>		
                    <td><b>Aéreo incluido?</b></td>
                    <?php if ($pacote['aereo']=="true") : ?>
                        <td>Sim</td>
                    <?php endif; ?>
                    <?php if ($pacote['aereo']=="false") : ?>
                        <td>Não</td>
                    <?php endif; ?>
                </tr>
                <tr>		
                    <td><b>Status</b></td>
                    <td><?php echo $pacote['status']; ?></td>
                </tr>
                <tr>		
                    <td><b>Exibe na página incial?</b></td>
                    <?php if ($pacote['evidencia']=="true") : ?>
                        <td>Sim</td>
                    <?php endif; ?>
                    <?php if ($pacote['evidencia']=="false") : ?>
                        <td>Não</td>
                    <?php endif; ?>
                </tr>              
                <tr>		
                    <td><b>Data e hora do Cadastro</b></td>
                    <td><?php echo $pacote['dataHoraCadastro']; ?></td>
                </tr>
                <tr>		
                    <td><b>Passeios</b></td>
                    <td>
                        <ul>
                            <?php 
                                $passeios = carregaPasseiosDoPacote($pacote['codPacote']);
                                foreach ($passeios as $passeio => $titulos) : 
                            ?>
                                <li>
                                    <?php echo $titulos['titulo']; ?>
                                </li>
                            <?php 
                                endforeach;
                             ?>
                        </ul> 
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
                                
    <?php 
        }
        endforeach;
    ?>


<!--
=============================  
#         JAVASCRIP         #
=============================-->

<script src="../../controller/scripts/galeriaImagem.js"></script>
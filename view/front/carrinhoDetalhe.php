<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/pacotesBean.php');
    require_once('../../controller/beans/pedidoBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');

    /** Verifiica se o usuário esta logado */
    require_once('../../controller/verificaLogado.php');

    $pacotePadrao = null;
    $pacotePersonalizado = null;
    
    /** Carrega o pacote selecionado */
    if(isset($_GET['id'])){

        $idPacote = $_GET['id'];
        $pacotePadrao = carregaDadosPacoteFull($idPacote);
        $pacotePersonalizado = $_SESSION['carrinho'][$idPacote];

    }
?>

<!-- Area de alerta e mensagens de erro -->
<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $_SESSION['message']; ?>
	</div>
<?php endif; ?>

<!-- Titulo da pagina-->
<div class="row ml-3">
<h4><b>Detalhe do pedido</b></h4>
</div>

<hr/>

	<div class="container">
		<div class="card py-3 px-3">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
                                                
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
                                foreach($pacotePadrao['imagens'] as $imagem => $value) : 
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
                        
                        <p class="mt-4">
                            <h5>Sobre a viagem</h5>
                            <?php echo $pacotePadrao['pacote']['descricao'];?>
                        </p>


					</div>

                    <!-- Corpo do pedido-->
					<div class="col-md-6">
     
                      <table class="table table-hover">
                            <tbody>
                                <tr class="bg-light">
                                    <td colspan="2"><h3><?php echo $pacotePadrao['pacote']['titulo'];?></h3></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Data Saída:</td>
                                    <td><?php echo date('d/m/Y', strtotime($pacotePersonalizado['dataInicio'])); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Data Volta:</td>
                                    <td><?php echo date('d/m/Y', strtotime($pacotePersonalizado['dataFim'])); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Diarias:</td>
                                    <td><?php echo caculaDiarias($pacotePersonalizado['dataInicio'], $pacotePersonalizado['dataFim']) . " noites"; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Local de saída:</td>
                                    <td>
                                    <?php 
                                        echo   carrega_estado_id($pacotePadrao['pacote']['codEstadoOrigem'])['nome'] ." / ".
                                                carrega_cidade_id($pacotePadrao['pacote']['codCidadeOrigem'])['nome'];
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Local do Destino:</td>
                                    <td>
                                    <?php 
                                        echo   carrega_estado_id($pacotePadrao['pacote']['codEstadoDestino'])['nome'] ." / ".
                                                carrega_cidade_id($pacotePadrao['pacote']['codCidadeDestino'])['nome'];
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Hospedagem:</td>
                                    <td>
                                        <?php
                                         if($pacotePersonalizado['hospedagem']=="true"){
                                             echo "Incluida no pacote";
                                         } else {
                                            echo "Não Incluida no pacote";
                                         }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Traslado:</td>
                                    <td>
                                        <?php
                                         if($pacotePersonalizado['traslado']=="true"){
                                             echo "Incluido no pacote";
                                         } else {
                                            echo "Não Incluido no pacote";
                                         }
                                        ?>
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td colspan="2"><h3>Composição do valor</h3></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Valor do pacote: </td>
                                    <td>
                                        <?php 
                                            $valorBase = $pacotePadrao['pacote']['valorBase'];
                                            echo "<b>R$ " . number_format($valorBase, 2, ',', '.'). "</b>";
                                        ?>
                                    </td>
                                </tr>

                                <?php if($pacotePersonalizado['hospedagem'] == "true") : ?>
                                    <tr>
                                        <td class="text-right">Hospedagem: </td>
                                        <td>
                                            <?php 
                                                $valorHospedagem = $pacotePadrao['pacote']['valorHospedagem'];
                                                $quantidadeDiarias = intval(caculaDiarias($pacotePersonalizado['dataInicio'], $pacotePersonalizado['dataFim']));
                                                $totalHospedagem = floatval($valorHospedagem * $quantidadeDiarias);
                                                
                                                echo "R$ " . number_format($valorHospedagem, 2, ',', '.') . 
                                                     " x " . $quantidadeDiarias . " diarias " . 
                                                     " = " . "<b> R$ " . number_format($totalHospedagem, 2, ',', '.') . "</b>";
                                            ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if($pacotePersonalizado['traslado'] == "true") : ?>
                                    <tr>
                                        <td class="text-right">Traslado: </td>
                                        <td>
                                            <?php 
                                                $valorTraslado = $pacotePadrao['pacote']['valorTraslado'];
                                                echo "<b>R$ " . number_format($valorTraslado, 2, ',', '.'). "</b>";
                                            ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if($pacotePersonalizado['aereo'] == "true") : ?>
                                    <tr>
                                        <td class="text-right">Aéreo: </td>
                                        <td>
                                            <?php 
                                                $valorAereo = $pacotePadrao['pacote']['valorAereo'];
                                                echo "<b>R$ " . number_format($valorAereo, 2, ',', '.'). "</b>";
                                            ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <tr>
                                    <td class="text-right">Valor Total: </td>
                                    <td>
                                        <?php 
                                            $valorTotal = $pacotePersonalizado['valorTotal'];
                                            echo "<b>R$ " . number_format($valorTotal, 2, ',', '.'). "</b>";
                                        ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>                      
					</div>
				</div>
			</div>
		</div>
	</div>
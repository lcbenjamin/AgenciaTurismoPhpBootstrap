<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/pacotesBean.php');
    require_once('../../controller/beans/pedidoBean.php');

    /** Verifiica se o usuário esta logado */
    require_once('../../controller/verificaLogado.php');

?>

<!-- Titulo Carrinho-->
<div class="row" id="tituloCarrinho">
    <div class="col-12 text-left my-3">
    <h2 class="display-6 text-dark">
            <i class="fa fa-cart-plus mr-2"></i>    
            Carrinho
    </h2>
    </div>
</div>
<!-- Area de alerta e mensagens de erro -->
<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $_SESSION['message']; ?>
		<?php unset($_SESSION['message']); ?>
	</div>
<?php endif; ?>

<hr/>

<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="bg-dark text-light">
                            <th scope="col" class="text-center"> </th>
                            <th scope="col" class="text-center">Pacote</th>
                            <th scope="col" class="text-center">Diarias</th>
                            <th scope="col" class="text-center">Serviços incluidos</th>
                            <th scope="col" class="text-center" >Valor</th>
                            <th> </th>
                        </tr>
					</thead>
					
                    <tbody>

						<?php if (!empty($_SESSION['carrinho'])) : ?>
							<?php $ValorTotalCarrinho = null; ?>
							<?php foreach ($_SESSION['carrinho'] as $pedido) : ?>
							<?php $pacoteSelecionado = carregaDadosPacoteFull($pedido['codPacote']); ?>

								<tr>
									<!-- Imagem do pacote -->
									<td class="text-center align-middle"><img id="img_carrinho" src="../imagens/img_pacotes/<?php echo $pacoteSelecionado['imagens'][0]['nome']; ?>" /> </td>

									<!-- PAcote -->
									<td class="text-center align-middle"><?php echo $pacoteSelecionado['pacote']['titulo']; ?></td>
									
									<!-- Diarias -->
									<td class="text-center align-middle"><?php echo caculaDiarias($pedido['dataInicio'],$pedido['dataFim']); ?> Dias </td>

									<!-- Itens Inclusos -->
									<td class="text-center align-middle">

										<!-- Exibe quando nenhum adicional é solicitado -->
										<?php if ( ($pedido['hospedagem'] == "false") &&
												($pedido['traslado'] == "false" )  &&
												($pedido['aereo'] == "false" ) )
												: ?>
											<i class="fa fa-ban"></i> Sem serviços
										<?php endif; ?>

										<!-- Hospedagem -->
										<?php if ($pedido['hospedagem']=="true") : ?>
											<i title="Hospedagem" class="fa fa-hotel mx-1"></i>
										<?php endif; ?>

										<!-- Traslado -->
										<?php if ($pedido['traslado']=="true") : ?>
											<i title="Traslado" class="fa fa-bus mx-1"></i>
										<?php endif; ?>

										<!-- Aereo -->
										<?php if ($pedido['aereo']=="true") : ?>
											<i title="Passagens AéreaAéreo" class="fa fa-plane mx-1"></i>
										<?php endif; ?>
									
									</td>

									<!-- Valor -->
									<td class="text-center align-middle"><?php echo "R$ " .  number_format($pedido['valorTotal'], 2, ',', '.'); ?></td>

									<!-- Ações -->
									<td class="actions text-center align-middle" >
										<a href="#" class="btn btn-sm btn-success">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="index.php?p=carrinhoDetalhe&id=<?php echo $pedido['codPacote']; ?>" class="btn btn-sm btn-warning">  
											<i class="fa fa-eye"></i> 
										</a>
										<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal-item-carrinho"  onclick="setaDadosModalDelete('<?php echo $pedido['codPacote']; ?>')">
											<i class="fa fa-trash"></i> 
										</a>
									</td>
								</tr>

							<!-- Soma valor dos pacotes selecionados -->	
							<?php  $ValorTotalCarrinho += $pedido['valorTotal']?>
							<?php endforeach; ?>

							<tr class="bg-secondary text-light">
								<td colspan="4"></td>
								<td class="text-center align-middle"><strong>Total</strong></td>
								<td class="text-center align-middle">
								<strong>
								
								<?php echo "R$ " .  number_format($ValorTotalCarrinho, 2, ',', '.'); ?>
								
								</strong>
								</td>

						<?php else : ?>
							<tr class="text-center">
								<td colspan="6">Nenhum item no carrinho.</td>
							</tr>
						<?php endif; ?>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
		<!-- Botões de Continue comprando e comprar-->
        <div class="col mb-2">
            <div class="row justify-content-end">
                <div class="col-md-3">
                    <a href="index.php#tituloPrincipal" class="btn btn-md btn-block btn-info ">Continue comprando</a>
                </div>
                <div class="col-md-2 text-right">
                    <a href="#" class="btn btn-md btn-block btn-success"  data-toggle="modal" data-target="#confirma-modal-item-carrinho">Fechar Compra</a>
                </div>
            </div>
        </div>

    </div>
</div>


<?php include('modal.php'); ?>

<script>
	//Modal para exclusão de pacote do carrinho
	function setaDadosModalDelete(valor) {
		document.getElementById('confirmaExcPacoteCarrinho').setAttribute('href', 'index.php?p=carrinho&idExcluir='+ valor);
	}
</script>


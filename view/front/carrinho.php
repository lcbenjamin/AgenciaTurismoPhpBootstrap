<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/pacotesBean.php');
    require_once('../../controller/beans/pedidoBean.php');

    /** Verifiica se o usuário esta logado */
    require_once('../../controller/verificaLogado.php');

?>

<!-- Area de alerta e mensagens de erro -->
<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $_SESSION['message']; ?>
	</div>
<?php endif; ?>

<!-- Corpo do carrinho-->
<div class="row">
<h4><b>Meus Pedidos</b></h4>
</div>


<!-- Tabela de pediso-->
<table class="table table-hover text-center table-bordered table-striped">

	<!-- Cabeçalho -->
	<thead class="thead-dark">
		<tr>
			<th>PACOTE</th>
			<th width="20%">Itens inclusos</th>
			<th>Valor</th>
			<th>Açoes</th>
		</tr>
	</thead>
	<!-- Conteudo -->
	<tbody>
	<?php if (isset($_SESSION['carrinho'])) : ?>

	<?php foreach ($_SESSION['carrinho'] as $pedido) : ?>
	<?php $pacoteSelecionado = carregaDadosPacoteFull($pedido['codPacote']);  ?>

		<tr>
			<!-- PAcote -->
			<td><?php echo $pacoteSelecionado['pacote']['titulo']; ?></td>
			<!-- Itens Inclusos -->
			<td>
				<?php if ( ($pedido['hospedagem'] == "false") &&
						   ($pedido['traslado'] == "false" ) &&
						   ($pedido['aereo'] == "false" ) )
						: ?>
                    <i class="fa fa-ban"></i> Sem serviços
                <?php endif; ?>


                <?php if ($pedido['hospedagem']=="true") : ?>
                    <i title="Hospedagem" class="fa fa-hotel mx-1"></i>
                <?php endif; ?>

                <?php if ($pedido['traslado']=="true") : ?>
                    <i title="Traslado" class="fa fa-bus mx-1"></i>
                <?php endif; ?>

                <?php if ($pedido['aereo']=="true") : ?>
                    <i title="Passagens AéreaAéreo" class="fa fa-plane mx-1"></i>
                <?php endif; ?>
            
            </td>
			<!-- Valor -->
			<td><?php echo "Valor"; ?></td>

        	<!-- Ações -->
			<td class="actions">
				<a href="./painelAdm.php?adm=passeiosMntDetalhe&id= " class="btn btn-sm btn-success"><i class="fa fa-eye"></i> </a>
				<a href="./painelAdm.php?adm=passeiosMntAlterar&id= " class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> </a>
				<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal-passeio"  onclick="setaDadosModal('<?php echo $pacotesCarrinho['codPasseio']; ?>')">
					<i class="fa fa-trash"></i> 
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
	<?php else : ?>
		<tr>
			<td colspan="6">Nenhum registro encontrado.</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>

<?php include('modalDelete.php'); ?>

<script>
	function setaDadosModal(valor) {
		document.getElementById('confirmaExcPedidoCliente').setAttribute('href', './painelAdm.php?adm=passeiosMnt&idExcluir='+ valor);
	}
</script>


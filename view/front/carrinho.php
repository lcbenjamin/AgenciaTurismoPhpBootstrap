<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/pacotesBean.php');
    require_once('../../controller/beans/pedidoBean.php');

    /** Verifiica se o usuário esta logado */
    require_once('../../controller/verificaLogado.php');
    
    /** Carrega o pacote selecionado */
    if(isset($_GET['id'])){
        $idPacote = $_GET['id'];
        $pacoteSelecionado = carregaDadosPacoteFull($idPacote);
    }

    validaSolicitacaoPedidoPersonalizado();
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
	<?php if ($pacotesCarrinho) : ?>
	<?php foreach ($pacotesCarrinho as $pedido) : ?>
		<tr>
			<!-- PAcote -->
			<td><?php echo $pacoteSelecionado['pacote']['titulo']; ?></td>
			<!-- Itens Inclusos -->
			<td><?php echo $pacotesCarrinho['traslado']; ?></td>
			<!-- Valor -->
			<td><?php echo $pacotesCarrinho['traslado']; ?></td>

        	<!-- Ações -->
			<td class="actions">
				<a href="./painelAdm.php?adm=passeiosMntDetalhe&id=<?php echo $pacotesCarrinho['codPasseio']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> </a>
				<a href="./painelAdm.php?adm=passeiosMntAlterar&id=<?php echo $pacotesCarrinho['codPasseio']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> </a>
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


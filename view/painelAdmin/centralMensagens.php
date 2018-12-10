<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
	require_once('../../controller/beans/mensagemBean.php');
	
	carrega_mensagens();

?>
<hr>
<!-- Navegador da Pagina-->
<header>
	<div class="row">
		<div class="col-sm-7">
			<h4 class="mt-2 ml-1">Central de Mensagens</h4>
		</div>
	</div>
</header>

<!-- Area de alerta e mensagens de erro -->
<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $_SESSION['message']; ?>
		<?php unset($_SESSION['message']); ?>
	</div>
<?php endif; ?>

<hr>

<!-- Tabela de usuários-->
<table class="table table-hover text-center table-bordered table-striped">

	<!-- Cabeçalho -->
	<thead class="thead-dark">
		<tr>
			<th>ID</th>
			<th width="30%">Remetente</th>
			<th>Data Recebimento</th>
			<th>Status</th>
            <th>Ações</th>
		</tr>
	</thead>
	<!-- Conteudo -->
	<tbody>
	<?php if ($mensagens) : ?>
	<?php foreach ($mensagens as $mensagem) : ?>
		<tr>
			<!-- Codigo da mensagem -->
			<td><?php echo $mensagem['codMensagem']; ?></td>
			<!-- Remetente -->
			<td><?php echo $mensagem['identificacao']; ?></td>
			<!-- Data Recebimento -->
			<td><?php echo date('d/m/Y H:m', strtotime($mensagem['dataHoraCadastro'])); ?></td>
			<!-- Status -->
			<td><?php echo $mensagem['status']; ?></td>

        	<!-- Ações -->
			<td class="actions">
				<a href="./painelAdm.php?adm=centralMensagensDetalhe&id=<?php echo $mensagem['codMensagem']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> </a>
				<a href="./painelAdm.php?adm=passeiosMntAlterar&id=<?php echo $passeio['codPasseio']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> </a>
				<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal-passeio"  onclick="setaDadosModal('<?php echo $passeio['codPasseio']; ?>')">
					<i class="fa fa-trash"></i> 
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
	<?php else : ?>
		<tr>
			<td colspan="5">Nenhum registro encontrado.</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>

<?php include('modalDelete.php'); ?>

<script>
	function setaDadosModal(valor) {
		document.getElementById('confirmaExcPasseio').setAttribute('href', './painelAdm.php?adm=passeiosMnt&idExcluir='+ valor);
	}
</script>
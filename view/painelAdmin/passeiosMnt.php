<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/passeioBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');
	carrega_passeios();
	deleta_passeio();
?>
<hr>
<!-- Navegador da Pagina-->
<header>
	<div class="row">
		<div class="col-sm-7">
		<h4 class="mt-2 ml-1">Passeios > Consultar</h4>
		</div>
		<div class="col-sm-5 text-right h2">
	    	<a class="btn btn-primary" href="./painelAdm.php?adm=passeiosInc"><i class="fa fa-plus"></i> Novo Passeio</a>
	    	<a class="btn btn-info" href="./painelAdm.php?adm=passeiosMnt"><i class="fa fa-refresh"></i> Atualizar</a>
	    </div>
	</div>
</header>

<!-- Area de alerta e mensagens de erro -->
<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $_SESSION['message']; ?>
	</div>
<?php endif; ?>

<hr>

<!-- Tabela de usuários-->
<table class="table table-hover text-center table-bordered table-striped">

	<!-- Cabeçalho -->
	<thead class="thead-dark">
		<tr>
			<th>ID</th>
			<th width="20%">Titulo</th>
			<th>Estado</th>
			<th>Cidade</th>
            <th>Valor</th>
            <th>Status</th>
            <th>Ações</th>
		</tr>
	</thead>
	<!-- Conteudo -->
	<tbody>
	<?php if ($passeios) : ?>
	<?php foreach ($passeios as $passeio) : ?>
		<tr>
			<!-- Identificador -->
			<td><?php echo $passeio['codPasseio']; ?></td>
			<!-- Titulo -->
			<td><?php echo $passeio['titulo']; ?></td>
			<!-- Estado -->
            <td><?php echo carrega_estado_id($passeio['codEstado'])['nome']; ?></td>
			<!-- Cidade -->
			<td><?php echo carrega_cidade_id($passeio['codCidade'])['nome']; ?></td>
			<!-- Valor -->
			<td><?php echo 'R$ ' . number_format($passeio['valor'], 2, ',', '.'); ?></td>
			<!-- Status -->
			<td><?php echo $passeio['status']; ?></td>

        	<!-- Ações -->
			<td class="actions">
				<a href="./painelAdm.php?adm=passeiosMntDetalhe&id=<?php echo $passeio['codPasseio']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> </a>
				<a href="./painelAdm.php?adm=passeiosMntAlterar&id=<?php echo $passeio['codPasseio']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> </a>
				<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal-passeio"  onclick="setaDadosModal('<?php echo $passeio['codPasseio']; ?>')">
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
		document.getElementById('confirmaExcPasseio').setAttribute('href', './painelAdm.php?adm=passeiosMnt&idExcluir='+ valor);
	}
</script>
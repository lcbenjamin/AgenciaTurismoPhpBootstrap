<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/usuarioBean.php');
	carrega_usuarios();
	deleta_usuario();
?>
<hr>
<!-- Navegador da Pagina-->
<header>
	<div class="row">
		<div class="col-sm-7">
		<h4 class="mt-2 ml-1">Usuários > Consultar</h4>
		</div>
		<div class="col-sm-5 text-right h2">
	    	<a class="btn btn-primary" href="./painelAdm.php?adm=usuariosInc"><i class="fa fa-plus"></i> Novo Usuário</a>
	    	<a class="btn btn-info" href="./painelAdm.php?adm=usuariosMnt"><i class="fa fa-refresh"></i> Atualizar</a>
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
			<th width="20%">Nome</th>
			<th>Perfil</th>
			<th>Status</th>
			<th>Opções</th>
		</tr>
	</thead>
	<!-- Conteudo -->
	<tbody>
	<?php if ($usuarios) : ?>
	<?php foreach ($usuarios as $usuario) : ?>
		<tr>
			<!-- Identificador -->
			<td><?php echo $usuario['codigoUsuario']; ?></td>
			<!-- Primeiro e ultimo nome -->
			<td><?php echo $usuario['primeiroNome']." ".$usuario['ultimoNome']; ?></td>
			<!-- Perfil -->
			<td><?php
				if ($usuario['codPerfil'] == 1){
					echo "Administrador";
				}else if($usuario['codPerfil'] == 2){
					echo "Cliente";
				} ?>
			</td>
			<!-- Status -->
			<td><?php echo $usuario['status'] ?></td>
			<!-- Ações -->

			<td class="actions">
				<a href="./painelAdm.php?adm=usuariosMntDetalhe&id=<?php echo $usuario['codigoUsuario']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> </a>
				<a href="./painelAdm.php?adm=usuariosMntAlterar&id=<?php echo $usuario['codigoUsuario']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> </a>
				<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal-usuario"  onclick="setaDadosModal('<?php echo $usuario['codigoUsuario']; ?>')">
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
		document.getElementById('confirmaExcUsuario').setAttribute('href', './painelAdm.php?adm=usuariosMnt&idExcluir='+ valor);
	}
</script>
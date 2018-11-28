<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/pacotesBean.php');
    require_once('../../controller/beans/estadoBean.php');
	carrega_pacotes();
	deleta_pacote();
?>
<hr>
<!-- Navegador da Pagina-->
<header>
	<div class="row">
		<div class="col-sm-7">
		<h4 class="mt-2 ml-1">Pacotes > Consultar</h4>
		</div>
		<div class="col-sm-5 text-right h2">
	    	<a class="btn btn-primary" href="./painelAdm.php?adm=pacotesInc"><i class="fa fa-plus"></i> Novo Pacote</a>
	    	<a class="btn btn-info" href="./painelAdm.php?adm=pacotesMnt"><i class="fa fa-refresh"></i> Atualizar</a>
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


<!-- Tabela de Pacotes-->
<table class="table table-hover text-center table-bordered table-striped">

	<!-- Cabeçalho -->
	<thead class="thead-dark">
		<tr>
			<th>ID</th>
			<th width="20%">Titulo</th>
			<th>Diarias</th>
			<th>Estado</th>
			<th>Serviçoes inclusos</th>
            <th>Valor</th>
            <th>Ações</th>
		</tr>
	</thead>
	<!-- Conteudo -->
	<tbody>
	<?php if ($pacotes) : ?>
	<?php foreach ($pacotes as $pacote) : ?>
		<tr>
			<!-- Identificador -->
			<td><?php echo $pacote['codPacote']; ?></td>
			<!-- Titulo -->
			<td><?php echo $pacote['titulo']; ?></td>
			<!-- Perfil -->
			<td><?php echo caculaDiarias($pacote['dataInicio'],$pacote['dataFim'])  ?></td>
			<!-- Estado -->
			<td><?php echo carrega_estado_id($pacote['codEstadoDestino'])['nome'];?></td>
            <!-- Serviços inclusos -->
			<td>
                <?php if ($pacote['parcela']=="true") : ?>
                    <i title="Parcelamento" class="fa fa-credit-card mx-1"></i>
                <?php endif; ?>

                <?php if ($pacote['hospedagem']=="true") : ?>
                    <i title="Hospedagem" class="fa fa-hotel mx-1"></i>
                <?php endif; ?>

                <?php if ($pacote['traslado']=="true") : ?>
                    <i title="Traslado" class="fa fa-bus mx-1"></i>
                <?php endif; ?>

                <?php if ($pacote['aereo']=="true") : ?>
                    <i title="Passagens AéreaAéreo" class="fa fa-plane mx-1"></i>
                <?php endif; ?>
            
            </td>
   			<!-- Valor Total -->
			<td ><?php echo 'R$ ' . number_format(calculaValorTotalPacote($pacote), 2, ',', '.');?></td>

			<!-- Ações -->

			<td class="actions">
				<a href="./painelAdm.php?adm=pacotesMntDetalhe&id=<?php echo $pacote['codPacote']; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> </a>
				<a href="./painelAdm.php?adm=pacotesMntAlterar&id=<?php echo $pacote['codPacote']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> </a>
				<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal-pacote"  onclick="setaDadosModal('<?php echo $pacote['codPacote']; ?>')">
					<i class="fa fa-trash"></i> 
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
	<?php else : ?>
		<tr>
			<td colspan="7">Nenhum registro encontrado.</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>

<?php include('modalDelete.php'); ?>

<script>
	function setaDadosModal(valor) {
		document.getElementById('confirmaExcPacote').setAttribute('href', './painelAdm.php?adm=pacotesMnt&idExcluir='+ valor);
	}
</script>
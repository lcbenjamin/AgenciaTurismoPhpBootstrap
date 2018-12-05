<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/pedidoBean.php');
    require_once('../../controller/beans/pacotesBean.php');

    carrega_pedidos();
    confirmaPedido();
    cancelaPedido();
    
?>
<hr>
<!-- Navegador da Pagina-->
<header>
	<div class="row">
		<div class="col-sm-7">
		    <h4 class="mt-2 ml-1">Meus Pedidos</h4>
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

<div class="container">
    <div class="row ">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <div class="pull-right mb-3">
                    <a class="btn btn-info" href="./painelUsr.php?adm=meusPedidos"><i class="fa fa-refresh"></i> Atualizar</a>
                    <button class="btn btn-warning btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtrar </button>
                </div>
            </div>
            <table class="table table-hover text-center table-bordered table-striped">
                <thead>
                    <tr class="filters bg-secondary text-light">
                        <th style="width: 18%"><input type="text" class="form-control text-center" placeholder="Cliente" disabled></th>
                        <th style="width: 22%"><input type="text" class="form-control text-center" placeholder="Pacote" disabled></th>
                        <th style="width: 12%"><input type="text" class="form-control text-center" placeholder="Data Saida" disabled></th>
                        <th style="width: 10%"><input type="text" class="form-control text-center" placeholder="Diarias" disabled></th>
                        <th style="width: 12%"><input type="text" class="form-control text-center" placeholder="Valor Total" disabled></th>
                        <th style="width: 10%"><input type="text" class="form-control text-center" placeholder="Status" disabled></th>
                        <th style="width: 14%" class="align-middle">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($pedidos) : ?>
                    <?php foreach ($pedidos as $pedido) : ?>  
                    <?php if ($pedido['codigoUsuario'] == $usuarioLogado['codigoUsuario']) : ?>  
                        <tr>
                            <td class="align-middle"><?php echo retornaNomeSobrenomeUsuario($pedido['codigoUsuario']); ?></td>
                            <td class="align-middle"><?php echo retornaTituloPacote($pedido['codPacote']); ?></td>
                            <td class="align-middle"><?php echo date('d/m/Y', strtotime($pedido['dataInicio'])); ?></td>
                            <td class="align-middle"><?php echo caculaDiarias($pedido['dataInicio'],$pedido['dataFim']); ?></td>
                            <td class="align-middle"><?php echo "R$ " . number_format($pedido['valorTotal'], 2, ',', '.'); ?></td>
                            <td class="align-middle"><?php echo $pedido['status']; ?></td>
                            <td class="align-middle">
                                <a href="./painelUsr.php?adm=meusPedidosDetalhe&id=<?php echo $pedido['codPedido']; ?>" class="btn btn-sm btn-success">
                                    <i class="fa fa-eye"></i>
                                </a>

                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#cancela-modal-pedido"  onclick="cancelaPedido('<?php echo $pedido['codPedido']; ?>')">
                                    <i class="fa fa-trash"></i> 
                                </a>    
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
	                <?php else : ?>
                        <tr>
                            <td colspan="7">Nenhum registro encontrado.</td>
                        </tr>
            	    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('modal.php'); ?>



<!--
=============================  
#         JAVASCRIP         #
=============================-->

<!-- Inclusão dos Modulos JavaScrips -->
<script src="../../node_modules/jquery/dist/jquery.js"></script>
<script src="../../node_modules/popper.js/dist/umd/popper.js"></script>
<script src="../../node_modules/bootstrap/dist/js/bootstrap.js"></script>

<script>
	function cancelaPedido(valor) {
		document.getElementById('cancelaPedido').setAttribute('href', 'painelUsr.php?adm=meusPedidos&cancelaPedido='+ valor);
	}
</script>

<script>

$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
});
</script>
<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/pedidoBean.php');
    require_once('../../controller/beans/pacotesBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');

    $pedido = null;
    $pacotePadrao = null;

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $pedido = retornaPedidoPorID($id);
        $pacotePadrao = retornaPacotePorID($pedido['codPacote']);

    }
    
?>

<hr>
<header>
	<div class="row">
		<div class="col-sm-7 pt-2">
		<h4>Meus Pedidos > <b>Detalhe </b></h4>
		</div>
		<div class="col-sm-5 text-right h2">
	    	<a class="btn btn-info" href="./painelUsr.php?adm=meusPedidos"><i class="fa fa-backward"></i> Voltar</a>
	    </div>
	</div>
</header>
<hr>
<div class="row">

    <div class="col-sm-8 text-left">
        <table class="table table-hover text-left table-bordered table-striped table-sm">

            <!-- Conteudo -->
            <tbody>
                <?php if($pedido != null) : ?>
                <tr>		
                    <td><b>Código pedido</b></td>
                    <td><?php echo $pedido['codPedido']; ?></td>
                </tr>
                <tr>		
                    <td><b>Pacote Contratado</b></td>
                    <td><?php echo retornaTituloPacote($pedido['codPacote']); ?></td>
                </tr>
                <tr>		
                    <td><b>Cliente</b></td>
                    <td><?php echo retornaNomeSobrenomeUsuario($pedido['codigoUsuario']); ?></td>
                </tr>
                <tr>		
                    <td><b>Origem [UF/Cidade]</b></td>
                    <td><?php 
                        echo carrega_estado_id($pacotePadrao['codEstadoOrigem'])['nome'] . " / " .
                             carrega_cidade_id($pacotePadrao['codCidadeOrigem'])['nome'];
                        ?>
                    </td>
                </tr>
                <tr>		
                    <td><b>Destino [UF/Cidade]</b></td>
                    <td><?php 
                        echo carrega_estado_id($pacotePadrao['codEstadoDestino'])['nome'] . " / " .
                             carrega_cidade_id($pacotePadrao['codCidadeDestino'])['nome'];
                        ?>
                    </td>
                </tr>
                <tr>		
                    <td><b>Inicio da Viagem</b></td>
                    <td><?php echo date('d/m/Y', strtotime($pedido['dataInicio'])); ?></td>
                </tr>
                <tr>		
                    <td><b>Fim da Viagem</b></td>
                    <td><?php echo date('d/m/Y', strtotime($pedido['dataFim'])); ?></td>
                </tr>
                <tr>		
                    <td><b>Traslado</b></td>
                    <td><?php
                        if($pedido['traslado'] == "true"){
                            echo "Incluido";
                        } else {
                            echo "Não incluso";
                        }
                     ?></td>
                </tr>
                <tr>		
                    <td><b>Hospedagem</b></td>
                    <td><?php
                        if($pedido['hospedagem'] == "true"){
                            echo "Incluido";
                        } else {
                            echo "Não incluso";
                        }
                     ?></td>
                </tr>                
                <tr>		
                    <td><b>Transporte Aéreo</b></td>
                    <td><?php
                        if($pedido['aereo'] == "true"){
                            echo "Incluido";
                        } else {
                            echo "Não incluso";
                        }
                     ?></td>
                </tr>                
                <tr>		
                    <td><b>Forma de pagamento</b></td>
                    <td><?php echo $pedido['quantidadeParcelas'] . " x sem juros"; ?></td>
                </tr>
                <tr>		
                    <td><b>Composição dos custos</b></td>
                    <td><?php
                    echo "Base: <b>R$ " . number_format($pacotePadrao['valorBase'], 2, ',', '.'). "</b>" . "<br />";
                    
                    /** Traslado */
                    if($pedido['traslado'] == "true"){
                        echo "Traslado: <b>R$ " . number_format($pedido['valorTraslado'], 2, ',', '.'). "</b>" . "<br />";
                    }
                    /** Hospedagem */
                    if($pedido['hospedagem'] == "true"){
                        $valorHospedagem = $pacotePadrao['valorHospedagem'];
                        $quantidadeDiarias = intval(caculaDiarias($pedido['dataInicio'], $pedido['dataFim']));
                        $totalHospedagem = floatval($valorHospedagem * $quantidadeDiarias);
                    
                        echo "Hospedagem: R$ " . number_format($valorHospedagem, 2, ',', '.') . 
                             " x " . $quantidadeDiarias . " diarias " . 
                             " = " . "<b> R$ " . number_format($totalHospedagem, 2, ',', '.') . "</b>" . "<br />";
                    }
                    /** Aereo */
                    if($pedido['aereo'] == "true"){
                        echo "Transp. Aéreo: <b>R$ " . number_format($pedido['valorAereo'], 2, ',', '.'). "</b>" . "<br />";
                    }            

                    ?></td>
                </tr>
                <tr>		
                    <td><b>Valor Total</b></td>
                    <td><?php echo "R$ " . number_format($pedido['valorTotal'], 2, ',', '.'); ?></td>
                </tr>
                <tr>		
                    <td><b>Data e hora da Compra</b></td>
                    <td><?php echo date('d/m/Y H:m', strtotime($pedido['dataHoraCadastro'])); ?></td>
                </tr>
                <?php else :?>
                <tr>		
                    <td colspan="2"><b>Erro ao exibir pedido</b></td>
                </tr>
                <?php endif;?>
            </tbody>
        </table>
    </div>
</div>
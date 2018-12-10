<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/mensagemBean.php');
    require_once('../../controller/beans/usuarioBean.php');

    /** Carrega Mensagem */
    $idMensagem = $_GET['id'];
    $mensagem = carrega_mensagem($idMensagem);

    /** Carrega remetente */
    $remetente = carregaUsuarioPorId($mensagem['codigoUsuario']);

    /** Carrega pacote associado*/
    $pacote = null;
    if($mensagem['codPacote'] != null){
        $pacote = find('PCT', 'codPacote',$mensagem['codPacote'], false );
    }

    /** Marca mensagem como lida */
    $mensagem['status'] = "Lida";
    update('MSG','codMensagem',$idMensagem,$mensagem);


?>


<!-- Navegador da Pagina-->
<hr>
<header>
	<div class="row">
		<div class="col-sm-7 pt-2">
		<h4>Mensagem > <b>Detalhe </b></h4>
		</div>
		<div class="col-sm-5 text-right h2">
	    	<a class="btn btn-warning" href="./painelAdm.php?adm=centralMensagensResponder&id=<?php echo $passeio['codPasseio'];?>"><i class="fa fa-pencil"></i></i> Responder</a>
	    	<a class="btn btn-info" href="./painelAdm.php?adm=centralMensagens"><i class="fa fa-backward"></i> Voltar</a>
	    </div>
	</div>
</header>
<hr>
<div class="row">

    <div class="col-sm-7 text-left">
        
        <table class="table table-hover text-left table-bordered table-striped table-sm" style=" table-layout: fixed;">

            <!-- Conteudo -->
            <tbody>
                <tr >		
                    <td width="200px"><b>Código Mensagem</b></td>
                    <td width="300px"><?php echo $mensagem['codMensagem']; ?></td>
                </tr>
                <tr>		
                    <td><b>Usuario</b></td>
                    <td><?php echo $remetente['primeiroNome'] . " " . $remetente['ultimoNome']; ?></td>
                </tr>
                <tr>		
                    <td><b>Email remetente</b></td>
                    <td><?php echo $mensagem['identificacao']; ?></td>
                </tr>
                <tr height="150px">		
                    <td><b>Mensagem</b></td>
                    <td><div width="300px">
                            <?php echo $mensagem['mensagem']; ?>
                        </div>
                    </td>
                </tr>
                <tr>		
                    <td><b>Pacote relacionado?</b></td>
                    <?php if(isset($mensagem['codPacote'])) :  ?>
                        <td><?php echo $pacote['titulo']; ?></td>
                    <?php else :  ?>
                        <td> -- </td>
                    <?php endif ; ?>
                </tr>
                <tr>		
                    <td><b>Data recebimento</b></td>
                    <td><?php echo date('d/m/Y H:m', strtotime($mensagem['dataHoraCadastro'])); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


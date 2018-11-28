<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/passeioBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');
    carrega_passeios();

    $id = $_GET['id'];
    foreach ($passeios as $passeio) :
    if($passeio['codPasseio']== $id)	{ ?>


<!-- Navegador da Pagina-->
<hr>
<header>
	<div class="row">
		<div class="col-sm-7 pt-2">
		<h4>Passeios > Consultar > <b>Detalhe </b></h4>
		</div>
		<div class="col-sm-5 text-right h2">
	    	<a class="btn btn-warning" href="./painelAdm.php?adm=passeiosMntAlterar&id=<?php echo $passeio['codPasseio'];?>"><i class="fa fa-pencil"></i></i> Editar</a>
	    	<a class="btn btn-info" href="./painelAdm.php?adm=passeiosMnt"><i class="fa fa-backward"></i> Voltar</a>
	    </div>
	</div>
</header>
<hr>
<div class="row">

    <div class="col-sm-7 text-left">
        
        <table class="table table-hover text-left table-bordered table-striped table-sm">

            <!-- Conteudo -->
            <tbody>
                <tr>		
                    <td><b>Código Passeio</b></td>
                    <td><?php echo $passeio['codPasseio']; ?></td>
                </tr>
                <tr>		
                    <td><b>Titulo</b></td>
                    <td><?php echo $passeio['titulo']; ?></td>
                </tr>
                <tr>		
                    <td><b>Descrição</b></td>
                    <td><?php echo $passeio['descricao']; ?></td>
                </tr>
                <tr>		
                    <td><b>Descrição Resumida</b></td>
                    <td><?php echo $passeio['descResumida']; ?></td>
                </tr>
                <tr>		
                    <td><b>Valor</b></td>
                    <td><?php echo $passeio['valor']; ?></td>
                </tr>
                <tr>		
                    <td><b>Estado</b></td>
                    <td><?php echo carrega_estado_id($passeio['codEstado'])['nome'];?></td>
                </tr>
                <tr>		
                    <td><b>Município</b></td>
                    <td><?php echo carrega_cidade_id($passeio['codCidade'])['nome'];?></td>
                </tr>
                <tr>		
                    <td><b>Status</b></td>
                    <td><?php echo $passeio['status']; ?></td>
                </tr>
                <tr>		
                    <td><b>Data e hora do Cadastro</b></td>
                    <td><?php echo $passeio['dataHoraCadastro']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


    
    <?php 
    }
    endforeach;
?>

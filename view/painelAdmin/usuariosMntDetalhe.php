<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    require_once('../../controller/beans/usuarioBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');
    carrega_usuarios();

    $id = $_GET['id'];
    foreach ($usuarios as $usuario) :
    if($usuario['codigoUsuario']== $id)	{ ?>


<!-- Navegador da Pagina-->
<hr>
<header>
	<div class="row">
		<div class="col-sm-7 pt-2">
		<h4>Usuários > Consultar > <b>Detalhe </b></h4>
		</div>
		<div class="col-sm-5 text-right h2">
	    	<a class="btn btn-warning" href="./painelAdm.php?adm=usuariosMntAlterar&id=<?php echo $usuario['codigoUsuario'];?>"><i class="fa fa-pencil"></i></i> Editar</a>
	    	<a class="btn btn-info" href="./painelAdm.php?adm=usuariosMnt"><i class="fa fa-backward"></i> Voltar</a>
	    </div>
	</div>
</header>
<hr>
<!-- <h3 class="mb-5 text-center">Perfil de <?php echo $usuario['primeiroNome'];?></h3> -->
<div class="row">

    <div class="col-sm-2 ml-3 text-left">
        <img class="media-object" src="../imagens/img_usuarios/<?php echo carrega_caminho_imagem($usuario['codImagem'])['nome'];?>">    
    </div>

    <div class="col-sm-7 text-left">
        
        <table class="table table-hover text-left table-bordered table-striped table-sm">

            <!-- Conteudo -->
            <tbody>
                <tr>		
                    <td><b>Código Usuário</b></td>
                    <td><?php echo $usuario['codigoUsuario']; ?></td>
                </tr>
                <tr>		
                    <td><b>Nome</b></td>
                    <td><?php echo $usuario['primeiroNome']; ?></td>
                </tr>
                <tr>		
                    <td><b>Sobrenome</b></td>
                    <td><?php echo $usuario['ultimoNome']; ?></td>
                </tr>
                <tr>		
                    <td><b>Data de nascimento</b></td>
                    <td><?php echo $usuario['dataNascimento']; ?></td>
                </tr>
                <tr>		
                    <td><b>E-mail</b></td>
                    <td><?php echo $usuario['email']; ?></td>
                </tr>
                <tr>		
                    <td><b>CPF</b></td>
                    <td><?php echo $usuario['cpf']; ?></td>
                </tr>
                <tr>		
                    <td><b>Telefone</b></td>
                    <td><?php echo $usuario['telefone']; ?></td>
                </tr>
                <tr>		
                    <td><b>Status no sistema</b></td>
                    <td><?php echo $usuario['status']; ?></td>
                </tr>
                <tr>		
                    <td><b>Endereço</b></td>
                    <td><?php echo $usuario['endereco']; ?></td>
                </tr>
                <tr>		
                    <td><b>CEP</b></td>
                    <td><?php echo $usuario['cep']; ?></td>
                </tr>
                <tr>		
                    <td><b>Perfil</b></td>
                    <td><?php echo $usuario['codPerfil']; ?></td>
                </tr>
                <tr>		
                    <td><b>Estado</b></td>
                    <td><?php echo carrega_estado_id($usuario['codEstado'])['nome'];?></td>
                </tr>
                <tr>		
                    <td><b>Município</b></td>
                    <td><?php echo carrega_cidade_id($usuario['codCidade'])['nome'];?></td>
                </tr>
                <tr>		
                    <td><b>Data e hora do Cadastro</b></td>
                    <td><?php echo $usuario['dataHoraCadastro']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


    
    <?php 
    }
    endforeach;
?>

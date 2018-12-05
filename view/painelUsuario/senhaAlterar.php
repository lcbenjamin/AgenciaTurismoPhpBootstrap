<?php
    /** Includes e conexões com o banco */
    require_once '../../config.php';
    require_once DBAPI;

    require_once('../../controller/beans/usuarioBean.php');
    alterarSenha();
?>

<hr />
<div class="bg-gradient-light py-1 pl-1 align-middle" >
  <h4>Alterar senha</h4>
</div>
<hr />
<!-- Area de alerta e mensagens de erro -->
<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?php echo $_SESSION['message']; ?>
    <?php unset($_SESSION['message']); ?>
	</div>
<?php endif; ?>

<!-- Formulario de inclusão -->
<form action="painelUsr.php?adm=senhaAlterar&alteraSenha=ok" method="post" enctype="multipart/form-data">


	<div class="row">
		<div class="col-sm-3">

		    <label>Senha atual</label>
		    <div class="form-group pass_show"> 
                <input type="password" name="senha[atual]" class="form-control" required> 
            </div> 
		       <label>Nova Senha</label>
            <div class="form-group pass_show"> 
                <input type="password" name="senha[nova]" class="form-control" required> 
            </div> 
		       <label>Confirme nova senha</label>
            <div class="form-group pass_show"> 
                <input type="password"  name="senha[confirma]" class="form-control" required> 
            </div> 
            
		</div>  
	</div>

  <!-- Botões -->
    <div id="actions" class="row text-left mt-4">
        <div class="col-md-12">
        <button type="reset" class="btn btn-info">Limpar</button>
        <button type="submit" class="btn btn-primary">Alterar</button>
        </div>
    </div>
</form>

<hr />

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../../node_modules/jquery/dist/jquery.js"></script>
<script src="../../node_modules/bootstrap/dist/js/bootstrap.js"></script>

<script>
    $(document).ready(function(){
        $('.pass_show').append('<span class="ptxt">Mostrar</span>');  
        });


        $(document).on('click','.pass_show .ptxt', function(){ 

        $(this).text($(this).text() == "Mostrar" ? "Esconder" : "Mostrar"); 

        $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

    });  

</script>
<?php
    /** Includes e conexões com o banco */
    require_once '../../config.php';
    require_once DBAPI;

    require_once('../../controller/beans/usuarioBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');
    
    carrega_usuarios();
    carrega_estados();
    editar_usuario();

    $id = $_GET['id'];
    $usuario =  carregaUsuarioPorId($id);
?>

<hr />
<div class="bg-gradient-light py-1 pl-1 align-middle" >
  <h4>Usuários > Atualizar</h4>
</div>
<hr />
<!-- Area de alerta e mensagens de erro -->
<?php if (!empty($_SESSION['message'])) : ?>
	<div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $_SESSION['message']; ?>
	</div>
<?php endif; ?>

<!-- Formulario de inclusão -->
<form action="painelAdm.php?adm=usuariosMntAlterar&id=<?php echo $usuario['codigoUsuario']; ?>&altera=ok" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="99999999"/>

  <!-- Linha 1 do formulario -->
  <div class="row">
     <!-- Primeiro Nome -->
    <div class="form-group col-md-4">
      <label for="primeiroNome">Primeiro Nome</label>
      <input type="text" value="<?php echo $usuario['primeiroNome']; ?>" class="form-control" name="usuario[primeiroNome]" >
    </div>
     <!-- Sobrenome -->
    <div class="form-group col-md-3">
      <label for="ultimoNome">Sobrenome</label>
      <input type="text" value="<?php echo $usuario['ultimoNome']; ?>" class="form-control" name="usuario[ultimoNome]">
    </div>
     <!-- CPF -->
    <div class="form-group col-md-3">
      <label for="cpf">CPF</label>
      <input type="text"  value="<?php echo $usuario['cpf']; ?>" class="form-control" name="usuario[cpf]" onkeydown="javascript: fMasc( this, mCPF );" maxlength="14">
    </div>
     <!-- Data Nascimento -->
    <div class="form-group col-md-2">
      <label for="dataNascimento">Data de Nascimento</label>
      <div class="input-group mb-2">
        <input type="text"  value="<?php echo $usuario['dataNascimento']; ?>" class="form-control dataFormatada" name="usuario[dataNascimento]"  aria-describedby="basic-addon2" id="dataNascimento" maxlength="10">
        <div class="input-group-append">
          <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
    </div>

  </div>
  
  <!-- Linha 2 do formulario -->
  <div class="row">
    <!-- Endereço -->
    <div class="form-group col-md-4">
      <label for="endereco">Endereço </label>
      <input type="text"  value="<?php echo $usuario['endereco']; ?>" class="form-control" name="usuario[endereco]" maxlength="100">
    </div>
     <!-- CEP -->
    <div class="form-group col-md-2">
      <label for="cep">CEP</label>
      <input type="text"  value="<?php echo $usuario['cep']; ?>" class="form-control" name="usuario[cep]" onkeydown="javascript: fMasc( this, mCEP );" maxlength="10">
    </div>
     <!-- Email -->
    <div class="form-group col-md-4">
      <label for="email">Email </label>
      <input type="email"  value="<?php echo $usuario['email']; ?>" class="form-control" name="usuario[email]" maxlength="30">
    </div>

    <!-- Status -->
    <div class="form-group col-md-2">
      <label for="status">Status </label>
      <select id="status" name="usuario[status]" class="form-control">
        <?php if($usuario['status']=="Ativo"){ ?>
          <option value="Ativo" selected >Ativo</option>
          <option value="Inativo">Inativo</option>
        <?php } else if($usuario['status']=="Inativo"){ ?>
          <option value="Inativo" selected>Inativo</option>
          <option value="Ativo" >Ativo</option>
        <?php } ?>
      </select>
    </div>

  </div>
  
  <!-- Linha 3 do formulario -->
  <div class="row">
     <!-- Estado -->
    <div class="form-group col-md-3">
      <label for="id_estado">UF </label>
      <select name="usuario[codEstado]" id="id_estado" class="form-control">
        <option value ="<?php echo $usuario['codEstado']; ?>" selected><?php echo carrega_estado_id($usuario['codEstado'])['nome'];?></option>        
            <?php if ($estados) : ?>
              <?php foreach ($estados as $estado) : ?>
                  <option value="<?php echo $estado['codEstado'];?>" > <?php echo $estado['nome'];?></option>
              <?php endforeach; ?>
            <?php else : ?>
                  <option>Erro na Consulta</option>   
            <?php endif; ?>
      </select>
    </div>
     <!-- Municipio -->
    <div class="form-group col-md-3">
      <label for="cidade">Município </label>
       <select id="cidade" name="usuario[codCidade]" class="form-control">
            <option value ="<?php echo $usuario['codCidade'];?>" selected><?php echo carrega_cidade_id($usuario['codCidade'])['nome'];?></option>
        </select>
    </div>
     <!-- Telefone -->
    <div class="form-group col-md-3">
      <label for="telefone">Telefone</label>
      <input type="text" value="<?php echo $usuario['telefone'];?>" class="form-control" name="usuario[telefone]" onkeydown="javascript: fMasc( this, mTel );" maxlength="20">
    </div>
     <!-- Perfil -->
    <div class="form-group col-md-2">
      <label for="perfil">Perfil </label>
      <select id="perfil" name="usuario[codPerfil]" class="form-control">
        <?php if($usuario['codPerfil']==1){ ?>
          <option value="1" selected >Cliente</option>
          <option value="2">Administrador</option>
        <?php } else if($usuario['codPerfil']==2){ ?>
          <option value="2" selected>Administrador</option>
          <option value="1" >Cliente</option>
        <?php } ?>
      </select>
    </div>

  </div>

  <!-- Linha 4 do formulario -->
   <div class="row"> 
       <!-- Foto do perfil -->
      <div class="col-xs-12 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">  
      <label for="status">Foto do Perfil </label>
          <div class="input-group image-preview">
              <input type="text" class="form-control image-preview-filename" disabled="disabled">
              <span class="input-group-btn">
                
                  <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                      <span class="glyphicon glyphicon-remove"></span> Limpar
                  </button>
                
                  <div class="btn btn-default image-preview-input">
                      <span class="glyphicon glyphicon-folder-open"></span>
                      <span class="image-preview-input-title">Procurar</span>
                      <input type="file" accept="image/png, image/jpeg, image/gif" name="fotoPerfil"/>
                  </div>
              </span>
          </div>
      </div>
  </div>

  <!-- Botões -->
  <div id="actions" class="row text-right mt-4">
    <div class="col-md-12">
      <button type="button" class="btn btn-info" onclick='history.go(-1)'>Cancelar</button>
      <button type="submit" class="btn btn-primary">Alterar</button>
    </div>
  </div>
</form>
<hr />
    

<!--
=============================  
#         JAVASCRIP         #
=============================-->

<!-- Inclusão dos Modulos JavaScrips -->
<script src="../../node_modules/jquery/dist/jquery.js"></script>
<script src="../../node_modules/popper.js/dist/umd/popper.js"></script>
<script src="../../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="../../node_modules/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script src="../../controller/scripts/main.js"></script>
<script src="../../controller/scripts/mascaras.js"></script>

<!-- Script para tratamento do campo Municipio-->
<script>
//quando o valor da combo de estado alterar ele vai executar essa linha
$("#id_estado").change(function () {
    //armazenando o valor do codigo do estado
    var valor = document.getElementById("id_estado").value;
        //chamada da controller e passando o ID estado via GET
    $.get('../../controller/beans/cidadeBean.php?search=' + valor, function (data) {
            //procurando a tag OPTION com id da cidade e removendo 
        $('#cidade').find("option").remove();
            //motando a combo da cidade
        $('#cidade').append(data);
    });
});
</script>
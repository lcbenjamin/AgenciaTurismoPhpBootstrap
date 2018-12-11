
<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    
    /** Inclusão dos controllers */
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/passeioBean.php');

    /** Carrega array com todos os estados */
    carrega_estados();

    validaInclusaoPasseio();
?>

<!-- Cabeçalho -->
<hr />
<div class="bg-gradient-light py-1 pl-1 align-middle" >
  <h4>Passeios > Incluir</h4>
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
<form action="painelAdm.php?adm=passeiosInc" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="20000"/>

  <!-- Linha 1 do formulario -->
  <div class="row">

    <div class="form-group col-md-4">
      <label for="titulo">Titulo *</label>
      <input type="text" class="form-control" name="passeio[titulo]" >
    </div>

    <div class="form-group col-md-3">
      <label for="descricao">Descrição </label>
      <input type="text" class="form-control" name="passeio[descricao]">
    </div>

    <div class="form-group col-md-3">
      <label for="descResumida">Descrição Resumida </label>
      <input type="text" class="form-control" name="passeio[descResumida]">
    </div>

    <div class="form-group col-md-2">
      <label for="valor">Valor *</label>
      <input type="text" class="form-control valorMoeda" name="passeio[valor]">
    </div>
  </div>
  
  <!-- Linha 3 do formulario -->
  <div class="row">
    <div class="form-group col-md-3">
      <label for="id_estado">UF *</label>
      <select name="passeio[codEstado]" id="id_estado" class="form-control">
        <option value ="NA" selected>Escolher...</option>        
            <?php if ($estados) : ?>
            <?php foreach ($estados as $estado) : ?>
                <option value="<?php echo $estado['codEstado'];?>" > <?php echo $estado['nome'];?></option>
            <?php endforeach; ?>
	        <?php else : ?>
                <option>Erro na Consulta</option>   
	        <?php endif; ?>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="cidade">Município *</label>
       <select id="cidade" name="passeio[codCidade]" class="form-control">
            <option value ="NA" selected>Escolher...</option>
        </select>
    </div>

    <div class="form-group col-md-2">
      <label for="status">Status *</label>
      <select id="status" name="passeio[status]" class="form-control">
        <option value ="NA" selected>Escolher...</option>
        <option value="Ativo">Ativo</option>
        <option value="Inativo">Inativo</option>
      </select>
    </div>

  </div>

  <!-- Botões -->
  <div id="actions" class="row text-right mt-4">
    <div class="col-md-12">
      <button type="reset" class="btn btn-info">Limpar</button>
      <button type="submit" class="btn btn-primary">Salvar</button>
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

<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    
    /** Inclusão do controller */
    require_once('../../controller/beans/pacotesBean.php');

    /** Inclusão dos controllers Auxiliares */
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');
    require_once('../../controller/beans/passeioBean.php');



    /** Funções de carga */
    if(isset($_GET['id'])){
        $pacote = carregaDadosPacoteFull($_GET['id']);
    }   
    
    carrega_estados();
    carrega_passeios();
    
    /** Valida pacote antes de persistir na base */
    
?>
        
<hr />
<div class="bg-gradient-light py-1 pl-1 align-middle" >
  <h4>Pacotes > Alterar</h4>
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
<form action="painelAdm.php?adm=pacotesMntAlterar" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="999999"/>

    <!-- Linha 1 do formulario -->
    <div class="row">

        <!-- Titulo do Pacote -->
        <div class="form-group col-md-4">
            <label for="titulo"><b>Titulo do Pacote</b></label>
            <input type="text" class="form-control" name="pacote[titulo]" value="<?php echo $pacote['pacote']['titulo'];?>" >
        </div>
  
        <!-- Data Ida-->
        <div class="form-group col-md-3">
        <label for="dataIda"><b>Data Ida </b></label>
        <div class="input-group mb-2">
            <input type="text" class="form-control dataFormatada"  name="pacote[dataInicio]"  value="<?php echo date('d/m/Y', strtotime($pacote['pacote']['dataInicio']));?>" aria-describedby="basic-addon2" id="dataIda" maxlength="10">
                <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
        </div>
  
        <!-- Data Volta-->
        <div class="form-group col-md-3">
        <label for="dataVolta"><b>Data Volta </b></label>
        <div class="input-group mb-2">
            <input type="text" class="form-control dataFormatada"  name="pacote[dataFim]" value="<?php echo date('d/m/Y', strtotime($pacote['pacote']['dataFim']));?>" aria-describedby="basic-addon2" id="dataVolta" maxlength="10">
            <div class="input-group-append">
            <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
        </div>

        <!-- Valor Base -->
        <div class="form-group col-md-2">
            <label for="valor"><b>Valor Base </b></label>
            <input type="text" class="form-control valorMoeda" name="pacote[valorBase]" value="<?php echo number_format($pacote['pacote']['valorBase'], 2, ',', '.');?>">
        </div>

    </div>

    <!-- Linha 2 do formulario -->
    <div class="row">

        <!-- Estado de Origem -->
        <div class="form-group col-md-3">
            <label for="id_estado_origem"><b>UF Origem</b></label>
            <select name="pacote[codEstadoOrigem]" id="id_estado_origem" class="form-control">
                <option value ="<?php echo $pacote['pacote']['codEstadoOrigem']; ?>" selected><?php echo carrega_estado_id($pacote['pacote']['codEstadoOrigem'])['nome'];?></option>        
                    <?php if ($estados) : ?>
                    <?php foreach ($estados as $estado) : ?>
                        <option value="<?php echo $estado['codEstado'];?>" > <?php echo $estado['nome'];?></option>
                    <?php endforeach; ?>
                    <?php else : ?>
                        <option>Erro na Consulta</option>   
                    <?php endif; ?>
            </select>
        </div>

        <!-- Cidade de Origem -->
        <div class="form-group col-md-3">
            <label for="cidade_origem"><b>Município Origem</b></label>
            <select id="cidade_origem" name="pacote[codCidadeOrigem]" class="form-control">
                <option value ="<?php echo $pacote['pacote']['codCidadeOrigem'];?>" selected><?php echo carrega_cidade_id($pacote['pacote']['codCidadeOrigem'])['nome'];?></option>
            </select>
        </div>        

        <!-- Estado de Destino -->
        <div class="form-group col-md-3">
            <label for="id_estado_destino"><b>UF Destino</b></label>
            <select name="pacote[codEstado]" id="id_estado_destino" class="form-control">
                <option value ="<?php echo $pacote['pacote']['codEstadoDestino']; ?>" selected><?php echo carrega_estado_id($pacote['pacote']['codEstadoDestino'])['nome'];?></option>        
                    <?php if ($estados) : ?>
                    <?php foreach ($estados as $estado) : ?>
                        <option value="<?php echo $estado['codEstado'];?>" > <?php echo $estado['nome'];?></option>
                    <?php endforeach; ?>
                    <?php else : ?>
                        <option>Erro na Consulta</option>   
                    <?php endif; ?>
            </select>
        </div>

        <!-- Cidade de Destino -->
        <div class="form-group col-md-3">
            <label for="cidade_destino"><b>Município Destino</b></label>
            <select id="cidade_destino" name="pacote[codCidadeDestino]" class="form-control">
                <option value ="<?php echo $pacote['pacote']['codCidadeDestino'];?>" selected><?php echo carrega_cidade_id($pacote['pacote']['codCidadeDestino'])['nome'];?></option>
            </select>
        </div>   

    </div>
    <!-- Linha 3 do formulario -->
    <div class="row">

        <!-- Pode parcelar?  Quantidade de parcelas -->
        <div class="form-group col-md-3">
            <label for="parcelas"><b>Quantidade de Parcelas</b></label>
            <div class="input-group col-mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <?php if($pacote['pacote']['parcela'] == 'true') : ?>
                        <input type="checkbox" value="true" name="pacote[parcela]" checked >
                    <?php else :?>
                        <input type="checkbox" value="true" name="pacote[parcela]" >
                    <?php endif; ?>
                </div>
            </div>
            <input type="text" name="pacote[quantidadeParcelas]" class="form-control" value="<?php echo $pacote['pacote']['quantidadeParcelas']?>" >
            </div>
        </div>

        <!-- Hospedagem ? Valor Hospedagem -->
        <div class="form-group col-md-3">
            <label for="hospedagem"><b>Hospedagem</b></label>
            <div class="input-group col-mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <?php if($pacote['pacote']['hospedagem'] == 'true') : ?>
                        <input type="checkbox" value="true" name="pacote[hospedagem]" checked >
                    <?php else :?>
                        <input type="checkbox" value="true" name="pacote[hospedagem]" >
                    <?php endif; ?>
                </div>
            </div>
            <input type="text" name="pacote[valorHospedagem]" class="form-control valorMoeda"  value="<?php echo number_format($pacote['pacote']['valorHospedagem'], 2, ',', '.');?>" >
            </div>
        </div>

        <!-- Traslado?  Valor Traslado -->
        <div class="form-group col-md-3">
            <label for="traslado"><b>Traslado</b></label>
            <div class="input-group col-mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox" value="true" name="pacote[traslado]" >
                </div>
            </div>
            <input type="text" name="pacote[valorTraslado]" class="form-control valorMoeda"  value="<?php echo number_format($pacote['pacote']['valorTraslado'], 2, ',', '.');?>" >
            </div>
        </div> 

        <!-- Aereo?  Valor Aereo -->
        <div class="form-group col-md-3">
            <label for="aereo"><b>Aéreo</b></label>
            <div class="input-group col-mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                <input type="checkbox" value="true" name="pacote[aereo]">
                </div>
            </div>
            <input type="text" name="pacote[valorAereo]" class="form-control valorMoeda"  value="<?php echo number_format($pacote['pacote']['valorAereo'], 2, ',', '.');?>" >
            </div>
        </div> 

    </div>

    <!-- Linha 4 do formulario -->
    <div class="row">

        <!-- Status do pacote -->
        <div class="form-group col-md-3">
            <label for="status"><b>Status</b></label>
            <select name="pacote[status]" class="form-control">
                <?php if($pacote['pacote']['status'] == "Ativo") :?>
                    <option value="Ativo" selected >Ativo</option>
                    <option value="Inativo">Inativo</option>                    
                <?php else :?>
                    <option value="Ativo" >Ativo</option>
                    <option value="Inativo" selected>Inativo</option>      
                <?php endif ;?>
            </select>
        </div>

        <!-- Evidencia do pacote nas promoções -->
        <div class="form-group col-md-3">
            <label for="status"><b>Pacote em evidência </b></label>
            <select name="pacote[evidencia]" class="form-control">
                <?php if($pacote['pacote']['evidencia'] == "true") :?>
                    <option value="true" selected >Sim</option>
                    <option value="false">não</option>                
                <?php else :?>
                    <option value="true">Sim</option>
                    <option value="false" selected>não</option>
                <?php endif ;?>

            </select>
        </div>

    </div>    
    <hr/>
    <!-- Linha 5 do formulario -->
    <div class="row">
        <div class="form-group col-md-6">
            <label for="hospedagem"><b> Alterar fotos do pacote</b></label>
        </div>
    </div>
    <div class="row pl-2">

        <?php $contador = 0;?>
        <?php foreach($pacote['imagens'] as $imagem) : ?>

            <label for="Upload<?php echo $contador; ?>">
                <img src="../imagens/img_pacotes/<?php echo $imagem['nome']?>"  id="thumbnail<?php echo $contador; ?>" class="thumbnail_alt_pacote" style="cursor:pointer;">
            </label>
            <input type="file"  id="Upload<?php echo $contador; ?>"  style="display:none;" name="imagemPacote[]">

            <?php 
            $contador ++;
            endforeach; ?>

    </div>

    <!-- Linha 6 do formulario -->
    <div class="row">

        <!-- Descrição -->    
        <div class="form-group col-md-6">
            <label for="comment"><b>Descrição </b></label>
            <textarea class="form-control" rows="7" id="comment" name="pacote[descricao]"> <?php echo $pacote['pacote']['descricao']?></textarea>
        </div> 

        <!-- Adicionar Passeios -->
        <div class="form-group col-md-6">
            <label><b>Selecione os passeios</b></label>
            <select multiple class="form-control selectpicker" data-size="15"  data-actions-box="true" style="height: 195px;" name="passeiosSelecionados[]">
            <?php if ($estados) : ?>
                <?php foreach ($estados as $estado) : ?>
                    <optgroup label="<?php echo $estado['nome'];?>">
                        <?php foreach ($passeios as $passeio) : ?>
                            <?php if ($passeio['codEstado'] == $estado['codEstado']) : ?>
                                <option value="<?php echo $passeio['codPasseio'];?>"><?php echo $passeio['titulo'];?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <option>Erro na Consulta</option>   
            <?php endif; ?>
            </optgroup>
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

<!-- Script para tratamento do campo Municipio de Origem-->
<script>
//quando o valor da combo de estado alterar ele vai executar essa linha
$("#id_estado_origem").change(function () {
    //armazenando o valor do codigo do estado
    var valor = document.getElementById("id_estado_origem").value;
        //chamada da controller e passando o ID estado via GET
    $.get('../../controller/beans/cidadeBean.php?search=' + valor, function (data) {
            //procurando a tag OPTION com id da cidade e removendo 
        $('#cidade_origem').find("option").remove();
            //motando a combo da cidade
        $('#cidade_origem').append(data);
    });
});
</script>

<!-- Script para tratamento do campo Municipio de Destino-->
<script>
//quando o valor da combo de estado alterar ele vai executar essa linha
$("#id_estado_destino").change(function () {
    //armazenando o valor do codigo do estado
    var valor = document.getElementById("id_estado_destino").value;
        //chamada da controller e passando o ID estado via GET
    $.get('../../controller/beans/cidadeBean.php?search=' + valor, function (data) {
            //procurando a tag OPTION com id da cidade e removendo 
        $('#cidade_destino').find("option").remove();
            //motando a combo da cidade
        $('#cidade_destino').append(data);
    });
});
</script>

<!-- Script para troca dinamica da imagem do pacote -->
<!-- Implementar forma mais elegante -->
<script>
 
// Imagem pacote 1 
$(function () {
    $(document).on("change", "#Upload0", function(e) {
        showThumbnail(this.files);
    });
    
    function showThumbnail(files) {
        if (files && files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#thumbnail0').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(files[0]);
        }
    }
});

// Imagem pacote 2     
$(function () {
    $(document).on("change", "#Upload1", function(e) {
        showThumbnail(this.files);
    });
    
    function showThumbnail(files) {
        if (files && files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#thumbnail1').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(files[0]);
        }
    }
});

// Imagem pacote 3     
$(function () {
    $(document).on("change", "#Upload2", function(e) {
        showThumbnail(this.files);
    });
    
    function showThumbnail(files) {
        if (files && files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#thumbnail2').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(files[0]);
        }
    }
});

// Imagem pacote 4     
$(function () {
    $(document).on("change", "#Upload3", function(e) {
        showThumbnail(this.files);
    });
    
    function showThumbnail(files) {
        if (files && files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#thumbnail3').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(files[0]);
        }
    }
});
</script>


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
    carrega_estados();
    carrega_passeios();

    /** Valida pacote antes de persistir na base */
    validaInclusaoPacote();
?>
        
<hr />
<div class="bg-gradient-light py-1 pl-1 align-middle" >
  <h4>Pacotes > Incluir</h4>
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
<form action="painelAdm.php?adm=pacotesInc" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="999999"/>

    <!-- Linha 1 do formulario -->
    <div class="row">

        <!-- Titulo do Pacote -->
        <div class="form-group col-md-4">
            <label for="titulo"><b>Titulo do Pacote *</b></label>
            <input type="text" class="form-control" name="pacote[titulo]" >
        </div>
  
        <!-- Data Ida-->
        <div class="form-group col-md-3">
        <label for="dataIda"><b>Data Ida *</b></label>
        <div class="input-group mb-2">
            <input type="text" class="form-control dataFormatada"  name="pacote[dataInicio]" placeholder="dd/mm/aaaa" aria-describedby="basic-addon2" id="dataIda" maxlength="10">
            <div class="input-group-append">
            <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
        </div>
  
        <!-- Data Volta-->
        <div class="form-group col-md-3">
        <label for="dataVolta"><b>Data Volta *</b></label>
        <div class="input-group mb-2">
            <input type="text" class="form-control dataFormatada"  name="pacote[dataFim]" placeholder="dd/mm/aaaa" aria-describedby="basic-addon2" id="dataVolta" maxlength="10">
            <div class="input-group-append">
            <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
        </div>

        <!-- Valor Base -->
        <div class="form-group col-md-2">
            <label for="valor"><b>Valor Base *</b></label>
            <input type="text" class="form-control valorMoeda" name="pacote[valorBase]">
        </div>

    </div>

    <!-- Linha 2 do formulario -->
    <div class="row">

        <!-- Estado de Origem -->
        <div class="form-group col-md-3">
            <label for="id_estado_origem"><b>UF Origem *</b></label>
            <select name="pacote[codEstadoOrigem]" id="id_estado_origem" class="form-control">
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

        <!-- Cidade de Origem -->
        <div class="form-group col-md-3">
            <label for="cidade_origem"><b>Município Origem*</b></label>
            <select id="cidade_origem" name="pacote[codCidadeOrigem]" class="form-control">
                <option value ="NA" selected>Escolher...</option>
            </select>
        </div>

        <!-- Estado de Origem -->
        <div class="form-group col-md-3">
            <label for="id_estado_destino"><b>UF Destino *</b></label>
            <select name="pacote[codEstadoDestino]" id="id_estado_destino" class="form-control">
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
        <!-- Cidade de Origem -->
        <div class="form-group col-md-3">
            <label for="cidade_destino"><b>Município Destino*</b></label>
            <select id="cidade_destino" name="pacote[codCidadeDestino]" class="form-control">
                <option value ="NA" selected>Escolher...</option>
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
                <input type="checkbox" value="true" name="pacote[parcela]" >
                </div>
            </div>
            <input type="text" name="pacote[quantidadeParcelas]" class="form-control" placeholder="Quantidade Parcelas">
            </div>
        </div>

        <!-- Hospedagem ? Valor Hospedagem -->
        <div class="form-group col-md-3">
            <label for="hospedagem"><b>Hospedagem</b></label>
            <div class="input-group col-mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input  type="checkbox" value="true" name="pacote[hospedagem]" >
                </div>
            </div>
            <input type="text" name="pacote[valorHospedagem]" class="form-control valorMoeda"  placeholder="Valor Hospedagem">
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
            <input type="text" name="pacote[valorTraslado]" class="form-control valorMoeda" placeholder="Valor Traslado">
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
            <input type="text" name="pacote[valorAereo]" class="form-control valorMoeda"  placeholder="Valor Aéreo">
            </div>
        </div> 

    </div>

    <!-- Linha 4 do formulario -->
    <div class="row">

        <!-- Status do pacote -->
        <div class="form-group col-md-3">
            <label for="status"><b>Status *</b></label>
            <select name="pacote[status]" class="form-control">
                <option value="Ativo" selected >Ativo</option>
                <option value="Inativo">Inativo</option>
            </select>
        </div>

        <!-- Evidencia do pacote nas promoções -->
        <div class="form-group col-md-3">
            <label for="status"><b>Pacote em evidência *</b></label>
            <select name="pacote[evidencia]" class="form-control">
                <option value="true" selected >Sim</option>
                <option value="false">não</option>
            </select>
        </div>

    </div>    
    <hr/>
    <!-- Linha 5 do formulario -->
    <div class="row">
        <div class="form-group col-md-6">
            <label for="hospedagem"><b>Selecione uma ou mais fotos para o pacote *</b></label>
        </div>
    </div>
    <div class="row">
        <!-- Imagem Pacote 1 -->
        <div class="form-group col-md-6">
            <div class="custom-file">
                <input id="inputImagemPacote1" type="file" class="custom-file-input" name="imagemPacote[]">
                <label id="labelImagemPacote1" for="logo" class="custom-file-label text-truncate">Escolha a primeira imagem</label>
            </div>
        </div>

        <!-- Imagem Pacote 2 -->
        <div class="form-group col-md-6">
            <div class="custom-file">
                <input id="inputImagemPacote2" type="file" class="custom-file-input" name="imagemPacote[]">
                <label id="labelImagemPacote2" for="logo" class="custom-file-label text-truncate">Escolha a segunda imagem</label>
            </div>
        </div>

        <!-- Imagem Pacote 3 -->
        <div class="form-group col-md-6">
            <div class="custom-file">
                <input id="inputImagemPacote3" type="file" class="custom-file-input" name="imagemPacote[]">
                <label id="labelImagemPacote3" for="logo" class="custom-file-label text-truncate">Escolha a terceira imagem</label>
            </div>
        </div>

        <!-- Imagem Pacote 4 -->
        <div class="form-group col-md-6">
            <div class="custom-file">
                <input id="inputImagemPacote4" type="file" class="custom-file-input" name="imagemPacote[]">
                <label id="labelImagemPacote4" for="logo" class="custom-file-label text-truncate">Escolha a quarta imagem</label>
            </div>
        </div>


    </div>

    <!-- Linha 6 do formulario -->
    <div class="row">

        <!-- Descrição -->    
        <div class="form-group col-md-6">
            <label for="comment"><b>Descrição * </b></label>
            <textarea class="form-control" rows="7" id="comment" name="pacote[descricao]"></textarea>
        </div> 

        <!-- Adicionar Passeios -->
        <div class="form-group col-md-6">
            <label><b>Selecione os passeios * </b></label>
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
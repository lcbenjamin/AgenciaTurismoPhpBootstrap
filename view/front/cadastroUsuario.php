<?php
    require_once '../../config.php';
    require_once DBAPI;

    /** Inclusão dos controllers */
    require_once('../../controller/beans/usuarioBean.php');
    require_once('../../controller/beans/estadoBean.php');
    require_once('../../controller/beans/cidadeBean.php');

    validaCadastroNovoUsuario();
    carrega_estados();
?>

<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.css">

    <!-- Personalizado CSS -->
    <link rel="stylesheet" href="../css/estilos_backend.css">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="../../node_modules/font-awesome/css/font-awesome.min.css">

    <title>Bubu Turismo</title>
</head>

<body class="bg-dark">

    <div class="container bg-light">
        <hr />
        <div class="bg-gradient-light py-1 pl-1 align-middle" >
            <h4>Seja bem vindo!</h4>
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
        <form action="cadastroUsuario.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="99999999"/>
            <input type="hidden" class="form-control" name="usuario[codPerfil]" value="1"/>
            <input type="hidden" class="form-control" name="usuario[status]" value="Pendente"/>

            <!-- Linha 1 do formulario -->
            <div class="row">

                <div class="form-group col-md-4">
                    <label for="primeiroNome">Primeiro Nome *</label>
                    <input type="text" class="form-control" name="usuario[primeiroNome]" maxlength="30" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="ultimoNome">Sobrenome *</label>
                    <input type="text" class="form-control" name="usuario[ultimoNome]" maxlength="30" required>
                </div>

                <div class="form-group col-md-3">
                    <label for="cpf">CPF *</label>
                    <input type="text" class="form-control" name="usuario[cpf]" onkeydown="javascript: fMasc( this, mCPF );" maxlength="14" required>
                </div>

                <div class="form-group col-md-2">
                    <label for="dataNascimento">Data de Nascimento*</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control dataFormatada"  name="usuario[dataNascimento]" placeholder="dd/mm/aaaa" aria-describedby="basic-addon2" id="dataNascimento" maxlength="10" required> 
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Linha 2 do formulario -->
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="endereco">Endereço *</label>
                    <input type="text" class="form-control" name="usuario[endereco]" maxlength="100" required>
                </div>

                <div class="form-group col-md-2">
                    <label for="cep">CEP</label>
                    <input type="text" class="form-control" name="usuario[cep]" onkeydown="javascript: fMasc( this, mCEP );" maxlength="10">
                </div>

                <div class="form-group col-md-4">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control" name="usuario[email]" maxlength="30" required>
                </div>

                <div class="form-group col-md-2">
                    <label for="senha">Senha *</label>
                    <input type="password" class="form-control" name="usuario[senha]" maxlength="16" required>
                </div>
            </div>
        
            <!-- Linha 3 do formulario -->
            <div class="row">
               
                <div class="form-group col-md-2">
                    <label for="id_estado">UF *</label>
                    <select name="usuario[codEstado]" id="id_estado" class="form-control" required>
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
                    <select id="cidade" name="usuario[codCidade]" class="form-control">
                        <option value ="NA" selected>Escolher...</option>
                    </select>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="telefone">Telefone</label>
                    <input type="text" class="form-control" name="usuario[telefone]" onkeydown="javascript: fMasc( this, mTel );" maxlength="20">
                </div>

            </div>

            <!-- Linha 4 do formulario -->
            <div class="row">    
                
                <div class="col-xs-12 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">  
                    <label for="status">Foto do Perfil *</label>
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
                    <button type="reset" class="btn btn-info">Limpar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>

        </form>
        
        <hr />

    </div>
</body>


</html>

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


<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Painel</title>

<link rel="stylesheet" href="includes/bootstrap.min.css" />
<link rel="stylesheet" href="includes/navbar-fixed-left.min.css">
<script src="includes/jquery.min.js"></script>
<script src="includes/bootstrap.min.js"></script>
</head>

<body>

	<!-- INICIO do Menu lateral-->
	<nav class="navbar navbar-inverse navbar-fixed-left">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="./painelusr.php?p=home">Nome do Usuario</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="./painelusr.php?p=pedidos">Meus Pedidos</a></li>
					<li><a href="./painelusr.php?p=editCadastro">Editar cadastro</a></li>
					<li><a href="./painelusr.php?p=altSenha">Alterar senha</a></li>
					<li><a href="./painelusr.php?p=excPerfil">Excluir Perfil</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- FIM do Menu lateral-->

	<!-- INICIO do contexto interno-->
	<div class="container">
      <?php
    $paginaSelecionada = @$_GET['p'];

    if ($paginaSelecionada == null) {
        require_once 'principal.php';
    }
    if ($paginaSelecionada == "home") {
        require_once 'principal.php';
    }
    if ($paginaSelecionada == "pedidos") {
        require_once 'pedidos.php';
    }
    if ($paginaSelecionada == "editCadastro") {
        require_once 'editarCadastro.php';
    }
    if ($paginaSelecionada == "altSenha") {
        require_once 'alterarSenha.php';
    }
    if ($paginaSelecionada == "excPerfil") {
        require_once 'excluirPerfil.php';
    }
    ?>
    </div>
	<!-- FIM do contexto interno-->
</body>
</html>
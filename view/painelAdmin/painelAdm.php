<!DOCTYPE html>
<html lang="pt-br">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- Bootstrap CSS e Estilos personalizados-->
	<link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.css">
	<link rel="stylesheet" href="../../node_modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js">
	<link rel="stylesheet" href="../../node_modules/bootstrap-datepicker/css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="../../node_modules/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/estilos_backend.css">

	<!-- modal de confirmarção - Deletar Item -->
	<?php include('modalDelete.php'); ?>

	<title>Bubu Turismo</title>

</head>

<body>

	<!-- 
	Cabecalho navbar
	=====================
	-->
	<nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-dark">
		<div class="collapse navbar-collapse" id="navbarCabecalho">
			<ul class="navbar-nav ml-left">
				<a class="navbar-brand h1 mb-0 py-0" href="../front/index.php?p=home">
					<a class="navbar-brand" href="#"><span class="text-primary">Bubu</span>Admin</a>
				</a>
			</ul>
		</div>
	</nav>


	<div class="container-fluid pl-0">
		<div class="row">
			<!-- 
			Menu Lateral
			=====================-->
			<div class="col-md-3 col-xs-1 p-l-0 p-r-0 in menu-lateral" id="sidebar">
				<div class="list-group panel">
					<!-- Menu OverView-->
					<a href="./painelAdm.php?adm=overview" class="list-group-item collapsed" data-parent="#sidebar"><i class="fa fa-list"></i> <span class="hidden-sm-down">Overview</span></a>
					<!-- Menu Usuários-->
					<a href="#menu2" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-users"></i> <span class="hidden-sm-down">Usuários </span></a>
					<div class="collapse" id="menu2">
						<a href="./painelAdm.php?adm=usuariosMnt" class="list-group-item" data-parent="#menu2">Consultar / Alterar / Excluir</a>
						<a href="./painelAdm.php?adm=usuariosInc" class="list-group-item" data-parent="#menu2">Incluir</a>
					</div>
					<!-- Menu Passeios-->
					<a href="#menu3" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-map-pin"></i> <span class="hidden-sm-down">Passeios </span></a>
					<div class="collapse" id="menu3">
						<a href="./painelAdm.php?adm=passeiosMnt" class="list-group-item" data-parent="#menu3">Consultar / Alterar / Excluir</a>
						<a href="./painelAdm.php?adm=passeiosInc" class="list-group-item" data-parent="#menu3">Incluir</a>
					</div>
					<!-- Menu Pacotes-->
					<a href="#menu4" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-suitcase"></i> <span class="hidden-sm-down">Pacotes </span></a>
					<div class="collapse" id="menu4">
						<a href="./painelAdm.php?adm=pacotesMnt" class="list-group-item" data-parent="#menu4">Consultar / Alterar / Excluir</a>
						<a href="./painelAdm.php?adm=pacotesInc" class="list-group-item" data-parent="#menu4">Incluir</a>
					</div>
					<!-- Menu Pedidos-->
					<a href="#menu5" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-clipboard"></i> <span class="hidden-sm-down">Pedidos </span></a>
					<div class="collapse" id="menu5">
						<a href="./painelAdm.php?adm=pedidosMnt" class="list-group-item" data-parent="#menu5">Consultar / Alterar / Excluir</a>
					</div>
					<!-- Menu Caixa de entrada-->
					<a href="./painelAdm.php?adm=caixaEntrada" class="list-group-item collapsed" data-parent="#sidebar"><i class="fa fa-comments"></i> <span class="hidden-sm-down">Caixa de entrada</span></a>
				</div>
			</div>
			<!-- 
			Conteudo Injetado
			=====================-->
			<main class="col-md-9 col-xs-11 p-l-2 p-t-2 main-principal">				
				<div class="page-header">

						<?php
							$paginaSelecionada = @$_GET['adm'];

							if($paginaSelecionada == null){require_once 'painelAdm.php';}
							if($paginaSelecionada == "home"){require_once '../principal/index.php';}
							if($paginaSelecionada == "overview"){require_once 'overview.php';}
							if($paginaSelecionada == "usuariosMnt"){require_once 'usuariosMnt.php';}
							if($paginaSelecionada == "usuariosMntDetalhe"){require_once 'usuariosMntDetalhe.php';}
							if($paginaSelecionada == "usuariosMntAlterar"){require_once 'usuariosMntAlterar.php';}
							if($paginaSelecionada == "usuariosInc"){require_once 'usuariosInc.php';}
							if($paginaSelecionada == "passeiosMnt"){require_once 'passeiosMnt.php';}
							if($paginaSelecionada == "passeiosMntDetalhe"){require_once 'passeiosMntDetalhe.php';}
							if($paginaSelecionada == "passeiosMntAlterar"){require_once 'passeiosMntAlterar.php';}																
							if($paginaSelecionada == "passeiosInc"){require_once 'passeiosInc.php';}
							if($paginaSelecionada == "pacotesMnt"){require_once 'pacotesMnt.php';}
							if($paginaSelecionada == "pacotesMntDetalhe"){require_once 'pacotesMntDetalhe.php';}
							if($paginaSelecionada == "pacotesMntAlterar"){require_once 'pacotesMntAlterar.php';}																
							if($paginaSelecionada == "pacotesInc"){require_once 'pacotesInc.php';}
							if($paginaSelecionada == "pedidosMnt"){require_once 'pedidosMnt.php';}
							if($paginaSelecionada == "pedidosInc"){require_once 'pedidosInc.php';}
							if($paginaSelecionada == "caixaEntrada"){require_once 'caixaEntrada.php';}
							
						?>

				</div>
			</main>
		</div>
	</div>


	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="../../node_modules/jquery/dist/jquery.js"></script>
	<script src="../../node_modules/jquery/dist/jquery.inputmask.js"></script>
	<script src="../../node_modules/popper.js/dist/umd/popper.js"></script>
	<script src="../../node_modules/bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>
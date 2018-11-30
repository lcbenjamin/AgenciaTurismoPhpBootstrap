
<!-- Inclusão da camada de banco de dados -->
<?php
    require_once '../../config.php';
    require_once DBAPI;
    $db = open_database();

    require_once('../../controller/beans/telaPrincipalBean.php');
    trataMensagemRodape();
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
    <link rel="stylesheet" href="../css/estilos_frontend.css">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="../../node_modules/font-awesome/css/font-awesome.min.css">

    <title>Bubu Turismo</title>
</head>

<body>

    <!-- NavBar do cabecalho-->
    <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-dark bg-dark pt-0 pb-0">
        <div class="collapse navbar-collapse" id="navbarCabecalho">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="https://www.linkedin.com/in/lcbenjamin/" target="_blank">
                        <img src="../imagens/logos/LinkedIn-Logo.png" alt="Linkedin Lucas Costa">
                    </a>
                </li>
                <li class="nav-item">
                    <?php if(!isset($_SESSION['logado'])) : ?>
                        <a class="nav-link text-white" href="login.php"><small><b>Entrar</b></small></a>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['logado'])) : ?>
                        <a class="nav-link text-white" href="#">
                            <small>
                                <b>Bem vindo <?php echo $_SESSION['logado']['primeiroNome'];?> !</b>
                            </small>
                        </a>
                    <?php endif; ?>
                </li>
                <?php if(isset($_SESSION['logado'])) : ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../../controller/logout.php"><small>Sair</small></a>
                </li>
                <?php endif; ?>
  
  
  
            </ul>
        </div>
    </nav>

    <!-- NavBar do menu-->
    <nav class="navbar navbar-fixed-top navbar-expand-lg navbar-light bg-gradient-light">
        <div class="container">
            <a class="navbar-brand h1 mb-0 py-0" href="./index.php?p=home">
            <img src="../imagens/logos/IconeBubu.png">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSite">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ml-5 mt-2" id="navbarSite">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="./index.php?p=home">Home</a>
                    </li>
                    <li class="nav-item dropdown mr-4">
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="./index.php?p=pacotes">Pacotes</a>
                    </li>
                    </li>
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="./index.php?p=quemSomos">Quem somos</a>
                    </li>
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="./index.php?p=contato">Contato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../painelAdmin/painelAdm.php">Painel</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carousel-->
    <div id="carouselPrincipal" class="carousel slide" data-ride="carousel">
        <!-- Controles central de troca de item-->
        <ol class="carousel-indicators">
            <li data-target="#carouselPrincipal" data-slide-to="0" class="active"></li>
            <li data-target="#carouselPrincipal" data-slide-to="1" class="active"></li>
            <li data-target="#carouselPrincipal" data-slide-to="2" class="active"></li>
            <li data-target="#carouselPrincipal" data-slide-to="3" class="active"></li>
        </ol>

        <!-- Imagens do carousel e legenda -->
        <div class="carousel-inner ">
            <div class="carousel-item active">
                <img src="../imagens/carousel/carousel_1.jpg" class="img-fluid d-block mx-auto">
                <div class="carousel-caption d-none d-md-block">
                    <h3 class="text-white">Campos do Jordão - SP</h3>
                    <p class="text-white" >O destino mais romantico do Brasil te espera</p>
                </div>
            </div>
            
            <div class="carousel-item">
                <img src="../imagens/carousel/carousel_2.jpg" class="img-fluid d-block mx-auto">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Olinda - PE</h3>
                    <p>Terra de surpresas e senções!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../imagens/carousel/carousel_3.jpg" class="img-fluid d-block mx-auto">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Paris</h3>
                    <p>Cidade Luz!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../imagens/carousel/carousel_4.jpg" class="img-fluid d-block mx-auto">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Praia do Pina</h3>
                    <p>Gente bonita e muita curtição. Tudo em um só lugar</p>
                </div>
            </div>
        </div>

        <!--Controle de retroceder o carrosel -->
        <a class="carousel-control-prev" href="#carouselPrincipal" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="sr-only">Anterior</span>
        </a>

        <!--Controle de avançar o carrosel -->
        <a class="carousel-control-next" href="#carouselPrincipal" role="button" data-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="sr-only">Avançar</span>
        </a>

    </div>

<!-- Verifica se o banco de dados está conectado -->
<?php if ($db) : ?>

    <!--injeção do conteudo de contexto -->
    <div class="container jumbotron">
        <?php
            $paginaSelecionada = @$_GET['p'];

            if($paginaSelecionada == null){require_once 'principal.php';}
            if($paginaSelecionada == "home"){require_once 'principal.php';}
            if($paginaSelecionada == "cadUsr"){require_once 'cadastrar.html';}
            if($paginaSelecionada == "contato"){require_once 'contato.html';}
            if($paginaSelecionada == "carrinho"){require_once 'carrinho.php';}
            if($paginaSelecionada == "pacotes"){require_once 'pacotes.php';}
            if($paginaSelecionada == "detalhePacote"){require_once 'detalhePacote.php';}
            if($paginaSelecionada == "pctInternacionais"){require_once 'pacotesInternacionais.html';}
            if($paginaSelecionada == "quemSomos"){require_once 'quemSomos.html';}
            
        ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalSite" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Titulo do modal</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>kskdjskdalksjdlkasjldkajsldkjalskdjalskd</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <span>fechar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>


<!-- Caso não esteja exibe mensagem de erro na tela -->
<?php else : ?>
	<div class="alert alert-danger text-center" role="alert">
		<p><strong>ERRO:</strong> Não foi possível Conectar ao Banco de Dados!</p>
	</div>

<?php endif; ?>

<!-- Rodapé do site -->
<footer class="footer bg-dark py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                    <h5 class="align-middle text-muted">
                        <i class="fa fa-compass fa-lg"></i> 
                        Bubu viagens e turismo Ltda.
                    </h5>
                <div class="row mt-2">
                    <div class="col-5">
                        <ul class="list-unstyled">
                            <li><a class="text-muted" href="./index.php?p=home">Pricipal</a></li>
                            <li><a class="text-muted" href="./index.php?p=pacotes">Pacotes</a></li>
                            <li><a class="text-muted" href="./index.php?p=quemSomos">Quem somos</a></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><a class="text-muted" href="#">Contato</a></li>
                            <li><a class="text-muted" href="../painelUsuario/painelusr.php">Área do usuário</a></li>
                        </ul>
                    </div>
                </div>
                <ul class="nav">
                    <li class="nav-item"><a href="" class="nav-link pl-0 text-muted"><i class="fa fa-facebook fa-lg"></i></a></li>
                    <li class="nav-item"><a href="" class="nav-link text-muted"><i class="fa fa-twitter fa-lg"></i></a></li>
                    <li class="nav-item"><a href="" class="nav-link text-muted"><i class="fa fa-github fa-lg"></i></a></li>
                    <li class="nav-item"><a href="" class="nav-link text-muted"><i class="fa fa-instagram fa-lg"></i></a></li>
                </ul>
                <br>
            </div>
            <!-- Mensagem do usuário -->
            <div class="col-md-2">
                <h5 class="text-md-right text-muted">Entre em contato</h5>
                <hr>
            </div>
            <div class="col-md-5">
                <form action="index.php" method="post" enctype="multipart/form-data">
                    <fieldset class="form-group">
                        <input type="email" class="form-control" id="emailUsuario" placeholder="Digite seu email" name="email[identificacao]">
                    </fieldset>
                    <fieldset class="form-group">
                        <textarea class="form-control" id="mensagemUsuario" placeholder="Escreva aqui e te responderemos prontamente" name="email[mensagem]"></textarea>
                    </fieldset>
                    <fieldset class="form-group text-xs-right">
                        <button type="submit" class="btn btn-secondary-outline btn-lg"><i class="fa fa-envelope-open fa-1x"></i> Enviar</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</footer>


    <!-- Java Scripts -->
    <script src="../../node_modules/jquery/dist/jquery.js"></script>
    <script src="../../node_modules/popper.js/dist/umd/popper.js"></script>
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>
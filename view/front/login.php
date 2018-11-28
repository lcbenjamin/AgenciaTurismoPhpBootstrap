
<?php
    /** Includes e conexões com o banco */    
    require_once '../../config.php';
    require_once DBAPI;
    
    /** Inclusão dos controllers */
    require_once('../../controller/beans/loginBean.php');

    /** Valida se usuário e senha estão corretos */
    validaLogin();

?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Login</title>

    <!-- Principal CSS do Bootstrap -->
    <link href="../../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos customizados para esse template -->
    <link href="../css/login.css" rel="stylesheet">

  </head>

  <!-- Area de alertas e mensagens de erro -->
  <div class="text-center">        
    <?php if (!empty($_SESSION['message'])) : ?>
      <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $_SESSION['message']; ?>
      </div>
    <?php endif; ?>
  </div>

  <body class="text-center">
    <form class="form-signin" action="login.php" method="post">
      <img class="mb-4" src="../imagens/logos/bootstrap-solid.svg" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Faça login</h1>
      <label for="inputEmail" class="sr-only">Endereço de email</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Seu email" name="login[email]" required autofocus>
      <label for="inputPassword" class="sr-only">Senha</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="login[senha]" required>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
      <div class="mt-3 text-center">
        <a href="#" target="_self" >Ainda não sou cadastrado</a>
        </div>
      <p class="mt-5 mb-3 text-muted">&copy; 2018-2018</p>
    </form>
  </body>
</html>

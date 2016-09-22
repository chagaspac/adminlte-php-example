<?php
session_start();

if(isSet($_POST['btnEnviar'])){
  $campos = array();
  $campos['username'] = $_POST['username'];
  $campos['password'] =  md5($_POST['password']);


  include_once("configs/db.php");
  $connection = Db::getInstance();

  $statement = $connection->prepare('SELECT * FROM usuario WHERE login = :username and senha_md5 = :password');
  $statement->execute($campos);
  $usuarios = $statement->fetchAll(PDO::FETCH_ASSOC);

  if(!empty($usuarios)){
    $usuario = $usuarios[0];
    $_SESSION['usuario'] = $usuario;
      header("Location: home.php");
  }else{
    $_SESSION['msg_session'] = 'Usuário/Senha inválidos'.md5($_POST['password']);
      header('Location:'.$_SERVER['PHP_SELF']);
  }
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OS | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <?php
    if(isset($_SESSION['msg_session'])){
      echo $_SESSION['msg_session'];
      unset($_SESSION['msg_session']);
    }
  ?>
  <div class="login-logo">
    <a href="index.php"><b>Acesso</b>Geek</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Coloque as credenciais de acesso</p>

    <form action="index.php" method="POST">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Usuário" name="username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Senha" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="btnEnviar">Entrar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
</body>
</html>

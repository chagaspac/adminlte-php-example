<?php
include_once("configs/config.php");
$connection = Db::getInstance();

if(isset($_POST['inputDescricao'])){
  $campos = array();
  $campos['descricao'] = $_POST['inputDescricao'];
  $campos['equipamento'] = $_POST['inputEquipamento'];
  $campos['senha'] = md5($_POST['inputSenha']);
  $campos['grupoId'] = $_POST['inputGrupo'];

  $statement = $connection->prepare('INSERT INTO mensagem (descricao,usuario_id) VALUES(:descricao,:usuario_id)');
  $statement->execute(array('descricao'=>$campos['descricao'],'usuario_id'=>$_SESSION['usuario']['id']));
  $msgId = $connection->lastInsertId();

  $statement = $connection->prepare('INSERT INTO solicitacao(status_id,usuario_solicitante_id,equipamento_id) VALUES(1,:usuario_id,:equipamento_id)');
  $statement->execute(array('usuario_id'=>$_SESSION['usuario']['id'],'equipamento_id'=>$campos['equipamento']));
  $solId = $connection->lastInsertId();

  $statement = $connection->prepare('INSERT INTO solicitacao_mensagem(solicitacao_id,mensagem_id) VALUES(:solicitacao_id,:mensagem_id)');
  $statement->execute(array('solicitacao_id'=>$solId,'mensagem_id'=>$msgId));

  header('Location:'.$_SERVER['PHP_SELF'].'?success=true');
  exit();
}

$statement = $connection->prepare('SELECT id,nome FROM equipamento');
$statement->execute();
$equipamentos = $statement->fetchAll(PDO::FETCH_ASSOC);


?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>OS</title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS sidedar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->
<body class="hold-transition skin-yellow sidebar-collapse sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    <?php include_once("header.php"); ?>

    <!-- =============================================== -->
    <?php include_once("menu.php"); ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Nova Solicitação
          <small></small>
        </h1>

      </section>

      <!-- Main content -->
      <section class="content">
      <?php if(!empty($_GET['success'])){ ?>
        <div class="callout callout-success text-center">
          <h4>SOLICITAÇÃO REALIZADA COM SUCESSO!</h4>
        </div>
        <?php }     ?>
        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Solicitação</h3>

            <a class='btn btn-default pull-right' href="cadastrar_posicao.php">Voltar</a>

          </div>
          <div class="box-body">
            <form action="" method=POST>

              <input type="hidden" name="inputId" id="inputId" value="">

              <div class="form-group">
                <label for="inputEquipamento">Equipamento</label>
                <select required class="form-control" id="inputEquipamento" name="inputEquipamento">
                  <?php
                  if(!empty($equipamentos)){
                    foreach($equipamentos as $equipamento){
                      echo "<option selected='selected' value='{$equipamento['id']}'>{$equipamento['nome']}</option>";
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="inputDescricao">Descrição</label>
                <input type="text" required class="form-control" id="inputDescricao" name="inputDescricao" placeholder="">
              </div>

              <button type="submit" class="btn btn-primary pull-right">Solicitar</button>
            </form>

          </div>

          <!-- /.box-body -->
          <div class="box-footer">

          </div>
          <!-- /.box-footer-->
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="cadastrarModal" tabindex="-1" role="dialog" aria-labelledby="cadastrarModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
      </div>
    </div>

    <?php include_once("footer.php"); ?>

  </div>
  <!-- ./wrapper -->

  <!-- jQuery 2.2.3 -->
  <script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- SlimScroll -->
  <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="assets/plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/dist/js/app.min.js"></script>

</body>
</html>

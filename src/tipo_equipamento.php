<?php
include_once("configs/config.php");
$connection = Db::getInstance();

if(isset($_POST['inputNome'])){
  $campos = array();
  $campos['nome'] = $_POST['inputNome'];
  if(empty($_POST['inputId'])){
    $statement = $connection->prepare('INSERT INTO tipo_equipamento (nome) VALUES(:nome)');
    $statement->execute($campos);
  }else{
    $campos['id'] = $_POST['inputId'];
    $statement = $connection->prepare('UPDATE tipo_equipamento SET nome =:nome where id = :id');
    $statement->execute($campos);
  }

    header('Location:'.$_SERVER['PHP_SELF'].'?id='.$campos['posicao']);
  exit();
}else if(!empty($_GET['remove'])){
    $statement = $connection->prepare('DELETE FROM tipo_equipamento WHERE id = :id');
    $statement->execute(array('id'=>$_GET['id']));
}

$statement = $connection->prepare('SELECT * FROM tipo_equipamento');
$statement->execute();
$lista = $statement->fetchAll(PDO::FETCH_ASSOC);




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
          Tipo de Equipamentos
          <small></small>
        </h1>

      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Equipamentos</h3>

            <a class='btn btn-default pull-right' href="cadastrar_posicao.php">Voltar</a>

            </div>
            <div class="box-body">
              <button type="button" class="btn btn-primary pull-right" style="margin-bottom: 10px;" data-toggle="modal" data-id='0' data-target="#cadastrarModal">
                Cadastrar
              </button>

              <table id="table" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(!empty($lista)){
                    foreach($lista as $item){
                      echo '<tr>';
                      echo "<td>{$item['id']}</td>";
                      echo "<td>{$item['nome']}</td>";
                      echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#cadastrarModal' data-id='{$item['id']}' data-nome='{$item['nome']}' >Editar</button></td>";
                      echo "<td><a type='button' class='btn btn-danger' href='?id={$item['id']}&remove=true'>Excluir</button></td>";
                      echo '</tr>';
                    }
                  }
                  ?>
                </tbody>
              </table>
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
            <form action="" method=POST>
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cadastro</h4>
              </div>
              <div class="modal-body">

                <input type="hidden" name="inputId" id="inputId" value="">

                <div class="form-group">
                  <label for="inputNome">Nome</label>
                  <input type="text" required class="form-control" id="inputNome" name="inputNome" placeholder="">
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
              </div>
            </form>
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

    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
    $(function () {
      $('#table').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": true
      });


      $('#cadastrarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        if(id != 0){
          var login = button.data('login');
          var nome = button.data('nome');

          modal.find('.modal-title').text('Editar');
          $('#inputId').val(id);
          $('#inputNome').val(nome);

        }else{
          modal.find('.modal-title').text('Cadastrar');
          $('#inputId').val('');
          $('#inputNome').val('');
        }
      });

    });

    </script>
  </body>
  </html>

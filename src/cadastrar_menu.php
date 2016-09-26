<?php
include_once("configs/config.php");
$connection = Db::getInstance();



if(isset($_POST['inputNome'])){
  $campos = array();
  $campos['nome'] = $_POST['inputNome'];
  $campos['url'] = $_POST['inputUrl'];
  $campos['icon'] = $_POST['inputIcon'];
  $campos['ordem'] = $_POST['inputOrdem'];
  $campos['menu_pai'] = ($_POST['inputMenuPai'] == 0 || empty($_POST['inputMenuPai']))?NULL:$_POST['inputMenuPai'];

  if(empty($_POST['inputId'])){

    $statement = $connection->prepare('INSERT INTO menu (nome,url,icon,ordem,url_pai) VALUES(:nome,:url,:icon,:ordem,:menu_pai)');
    $statement->execute($campos);
  }else{
    $campos['id'] = $_POST['inputId'];
    $statement = $connection->prepare('UPDATE menu SET nome = :nome, url = :url, icon = :icon, ordem = :ordem, url_pai = :menu_pai WHERE id = :id');
    $statement->execute($campos);
  }

  header('Location:'.$_SERVER['PHP_SELF']);
  exit();
}



$statement = $connection->prepare('SELECT * FROM menu');
$statement->execute();

$lista = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement = $connection->prepare('SELECT * FROM menu WHERE url_pai is null');
$statement->execute();

$lista_menu_pai = $statement->fetchAll(PDO::FETCH_ASSOC);


?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Order<System/title>
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
          Menus
          <small></small>
        </h1>

      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Menu</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Minimizar">
                <i class="fa fa-minus"></i></button>
                <!--button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button -->
              </div>
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
                    <th>Url</th>
                    <th>Icon</th>
                    <th>Ordem</th>
                    <th>Menu Pai</th>
                    <th>Editar</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(!empty($lista)){
                    foreach($lista as $item){
                      echo '<tr>';
                      echo "<td>{$item['id']}</td>";
                      echo "<td>{$item['nome']}</td>";
                      echo "<td>{$item['url']}</td>";
                      echo "<td>{$item['icon']}</td>";
                      echo "<td>{$item['ordem']}</td>";
                      echo "<td>{$item['url_pai']}</td>";
                      echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#cadastrarModal' data-id='{$item['id']}' data-nome='{$item['nome']}' data-url='{$item['url']}' data-icon='{$item['icon']}' data-ordem='{$item['ordem']}' data-menu_pai='{$item['url_pai']}'>Editar</button></td>";
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
                  <input type="text" class="form-control" id="inputNome" name="inputNome" placeholder="">
                </div>

                <div class="form-group">
                  <label for="inputUrl">Url</label>
                  <input type="text" class="form-control" id="inputUrl" name="inputUrl" placeholder="">
                </div>

                <div class="form-group">
                  <label for="inputIcon">Icon</label>
                  <input type="text" class="form-control" id="inputIcon" name="inputIcon" placeholder="">
                </div>

                <div class="form-group">
                  <label for="inputOrdem">Ordem</label>
                  <input type="number" class="form-control" id="inputOrdem" name="inputOrdem" placeholder="">
                </div>

                <div class="form-group">
                  <label for="inputMenuPai">Menu Pai</label>
                  <select class="form-control" id="inputMenuPai" name="inputMenuPai">
                    <option value="">Selecione o menu pai</option>
                    <?php
                    if(!empty($lista_menu_pai)){

                      foreach($lista_menu_pai as $item){
                        echo "<option value='{$item['id']}'>{$item['nome']}</option>";
                      }
                    }
                    ?>
                  </select>
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
          var nome = button.data('nome');
          var url = button.data('url');
          var icon = button.data('icon');
          var ordem = button.data('ordem') ;
          var menupai = button.data('menu_pai');

          modal.find('.modal-title').text('Editar');
          $('#inputId').val(id);
          $('#inputNome').val(nome);
          $('#inputUrl').val(url);
          $('#inputIcon').val(icon);
          $('#inputOrdem').val(ordem);
          $('#inputMenuPai').val(menupai);
        }else{
          modal.find('.modal-title').text('Cadastrar');
          $('#inputId').val('');
          $('#inputNome').val('');
          $('#inputUrl').val('');
          $('#inputIcon').val('');
          $('#inputOrdem').val('');
          $('#inputMenuPai').val('');
        }
      });

    });

    </script>
  </body>
  </html>

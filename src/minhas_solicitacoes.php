<?php
include_once("configs/config.php");
$connection = Db::getInstance();

if(isset($_POST['inputSolicitacaoId'])){
  $statement = $connection->prepare('UPDATE solicitacao SET status_id = :stid, dt_resolucao = NOW() WHERE id = :id');
  $statement->execute(array('stid'=>3,'id'=>$_POST['inputSolicitacaoId']));
}



$statement = $connection->prepare('SELECT s.id,s.dt_criacao, e.nome \'equipamento\', u.nome \'atendente\', st.nome \'status\', s.usuario_solicitante_id \'usuario_id\' FROM solicitacao s INNER JOIN equipamento e ON e.id = s.equipamento_id LEFT JOIN usuario u ON (u.id = s.usuario_atendente_id) INNER JOIN status st ON (st.id = s.status_id) where usuario_solicitante_id = :usu');
$statement->execute(array('usu'=>$_SESSION['usuario']['id']));
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
          Minhas Solicitações
          <small></small>
        </h1>

      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Solicitações</h3>

            <a class='btn btn-default pull-right' href="cadastrar_posicao.php">Voltar</a>

          </div>
          <div class="box-body">
            <table id="table" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Data da Solicitação</th>
                  <th>Equipamento</th>
                  <th>Atentende</th>
                  <th>Status</th>
                  <th>Acompanhar</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if(!empty($lista)){
                  foreach($lista as $item){
                    echo '<tr>';
                    echo "<td>{$item['id']}</td>";
                    echo "<td>{$item['dt_criacao']}</td>";
                    echo "<td>{$item['equipamento']}</td>";
                    echo "<td>{$item['atendente']}</td>";
                    echo "<td>{$item['status']}</td>";
                    echo "<td><button type='button' class='btn btn-primary' style='margin-bottom: 10px;' data-toggle='modal' data-target='#responderModal' onclick='getMessages({$item['id']},{$item['usuario_id']})'>
                    Acompanhar
                  </button></td>";
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
  <div class="modal fade" id="responderModal" tabindex="-1" role="dialog" aria-labelledby="responderModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="" method=POST>
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            
          </div>
          <div class="modal-body">

            <input type="hidden" name="inputUsuarioId" id="inputUsuarioId" value="">
            <input type="hidden" name="inputSolicitacaoId" id="inputSolicitacaoId" value="">


            <div class="box-body chat" id="chat-box" style="overflow: hidden; width: auto; height: 250px;">



            </div>
            <div class="modal-footer">
              <div class="input-group">
                <input class="form-control" id="inputDescricao" name="inputDescricao" placeholder="Escreva sua mensagem...">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-success" onclick="putMessages();"><i class="fa fa-plus"></i></button>
                </div>
              </div>
              <div class="text-center" style="margin-top:5px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Encerrar Solicitação</button>
              </div>
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
  <!-- Slimscroll -->
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>

  <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script>

    function getMessages(idSolicitacao,idUsuario){
      $('#inputUsuarioId').val(idUsuario);
      $('#inputSolicitacaoId').val(idSolicitacao);
      $.ajax({
        type: "POST",
        url: 'ajax/mensagem.php',
        data: {'usuario_id':idUsuario, 'solicitacao_id':idSolicitacao, 'action':'get'},
        success: function(result){
          console.log(result);
          var json = JSON.parse(result);
          var html = '';

          $.each(json, function (index, element){
            html = html + '<div class="item">' +
            '<img src="assets/dist/img/avatar5.png" alt="user image" class="online">' +
            '<p class="message">' +
            '<a href="#" class="name">' +
            '<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> '+element.dt_criacao+'</small>' +
            element.nome +
            '</a>' +
            element.descricao +
            '</p>' +
            '</div>';
          });

          $('#chat-box').html(html);
        }
      });
    }
    function putMessages(){
      var idUsuario = $('#inputUsuarioId').val();
      var idSolicitacao = $('#inputSolicitacaoId').val();
      var descricao = $('#inputDescricao').val();

      console.log(idUsuario+" "+idSolicitacao+" "+descricao);

      $.ajax({
        type: "POST",
        url: 'ajax/mensagem.php',
        data: {'usuario_id':idUsuario, 'solicitacao_id':idSolicitacao, 'descricao':descricao, 'action':'add'},
        success: function(result){
          console.log(result);
          var json = JSON.parse(result);
          if(json.length > 0){
            $('#chat-box').append(
              '<div class="item">' +
              '<img src="assets/dist/img/avatar5.png" alt="user image" class="online">' +
              '<p class="message">' +
              '<a href="#" class="name">' +
              '<small class="text-muted pull-right"><i class="fa fa-clock-o"></i> '+json[0].dt_criacao+'</small>' +
              json[0].nome +
              '</a>' +
              json[0].descricao +
              '</p>' +
              '</div>'
              );
          }
        }
      });
    }

  </script>
</body>
</html>

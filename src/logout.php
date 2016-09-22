<?php
  session_start();

  $msg = $_SESSION['msg_session'];

  // DESTROI SESSAO;
  session_unset();
  session_destroy();

  // CRIA NOVA SESSAÔ COM MSG DE ERRRO
  session_start();
  $_SESSION['msg_session'] = $msg;


  header("Location:index.php");
 ?>

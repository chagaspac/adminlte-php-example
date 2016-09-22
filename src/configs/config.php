<?php
session_start();
$atual_url = $_SERVER['PHP_SELF'];

include_once("utils.php");
include_once("configs/db.php");
$connection = Db::getInstance();

  // CHECA SE EXISTE OPERADOR
if(!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])){
  $_SESSION['msg_session'] = '<div class="callout callout-danger">
  <h4>Operador não encontrado!</h4>

  <p>O sistema não encontrou o seu usuário, tente novamente mais tarde.</p>
</div>';
header('Location: logout.php');
}

  // VERIFICA SESSÃO
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 600 )) {
  $_SESSION['msg_session'] = '<div class="callout callout-danger">
  <h4>Sessão expirou!</h4>

  <p>Você está inativo por muito tempo, e sua sessão expirou.</p>
</div>';
header('Location: logout.php');
}else{
  $_SESSION['LAST_ACTIVITY'] = time();
}


//CHECA SE TEM ACESSO A PAGINA ACESSADA
if(!isset($public)){
  $statement = $connection->prepare('SELECT m.id, m.nome, m.url, m.icon 
                                    FROM menu m 
                                    INNER JOIN grupo_menu gm ON gm.menu_id = m.id 
                                    INNER JOIN usuario u ON u.grupo_id = gm.grupo_id
                                    where u.id = '.$_SESSION['usuario']['id']);
  $statement->execute();
  $acesso = $statement->fetchAll(PDO::FETCH_ASSOC);
  if(empty($acesso)){
    $_SESSION['msg_session'] = '<div class="callout callout-danger">
    <h4>Acesso negado!</h4>

    <p>Você está tentando acessar uma página que não está autorizada para sua posição.</p>
  </div>';
  header("Location: logout.php");
}
}
?>

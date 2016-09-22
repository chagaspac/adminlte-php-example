<?php
//include_once("../configs/config.php");
include_once("../configs/db.php");
$connection = Db::getInstance();
$hoje = date('Y-m-d H:i:s');
if(isset($_POST['solicitacao_id']) && 
  isset($_POST['action'])){
  if($_POST['action'] == 'get'){

    $statement = $connection->prepare("SELECT m.descricao,m.dt_criacao,u.nome 'nome' FROM mensagem m inner join solicitacao_mensagem sm on m.id = sm.mensagem_id inner join usuario u on m.usuario_id = u.id WHERE sm.solicitacao_id = :id");
    $statement->execute(array('id'=>$_POST['solicitacao_id']));
    $mensagens = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($mensagens);

  }else if($_POST['action'] == 'add'){

    $statement = $connection->prepare('INSERT INTO mensagem (descricao,usuario_id) VALUES(:descricao,:usuario_id)');
    $statement->execute(array('descricao'=>$_POST['descricao'],'usuario_id'=>$_POST['usuario_id']));
    $msgId = $connection->lastInsertId();

    $statement = $connection->prepare('INSERT INTO solicitacao_mensagem(solicitacao_id,mensagem_id) VALUES(:solicitacao_id,:mensagem_id)');
    $statement->execute(array('solicitacao_id'=>$_POST['solicitacao_id'],'mensagem_id'=>$msgId));


    $statement = $connection->prepare("SELECT m.descricao,m.dt_criacao,u.nome 'nome' FROM mensagem m inner join solicitacao_mensagem sm on m.id = sm.mensagem_id inner join usuario u on m.usuario_id = u.id WHERE sm.solicitacao_id = :id and m.id = :mid");
    $statement->execute(array('id'=>$_POST['solicitacao_id'],'mid'=>$msgId));
    $mensagens = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($mensagens);

  }

}

?>

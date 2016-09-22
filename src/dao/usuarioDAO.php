<?php
include_once('configs/db.php');
include_once('bean/usuario.php');

class UsuarioDAO {



  public function getUsuarioById($id){

    $connection = Db::getInstance();
    $statement = $connection->prepare('SELECT * FROM usuario WHERE id = :id');
    $statement->execute([':id' => $id]);

    $results = $statement->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    if(!empty($results)){
      return $results[0];
    }else{
      return false;
    }
  }

  public function getUsuarioByEmail($email){

    $connection = Db::getInstance();
    $statement = $connection->prepare('SELECT * FROM usuario WHERE email = :email');
    $statement->execute([':email' => $email]);

    $results = $statement->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    if(!empty($results)){
      return $results[0];
    }else{
      return false;
    }
  }
}

?>

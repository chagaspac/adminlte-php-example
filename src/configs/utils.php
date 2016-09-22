<?php


    function parr($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }


    function gerarCodigo($tipo){
      include_once("configs/config.php");
      include_once("configs/db.php");
      $connection = Db::getInstance();

        $numero = rand(10000000,99999999);

        $codigo = $tipo.$numero;
        $statement = $connection->prepare('SELECT codigo FROM credencial WHERE codigo = :codigo');
        $statement->execute(array('codigo'=>$codigo));

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if(empty($result)){
          return $codigo;
        }else{
          return gerarCodigo($tipo);
        }
    }
 ?>

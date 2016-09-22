<?php

class Usuario {

  protected $id;
  protected $nome;
  protected $email;
  protected $senha;
  protected $foto;
  protected $chave;
  protected $ativo;

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getNome(){
    return $this->nome;
  }

  public function setNome($nome){
    $this->nome = $nome;
  }


  public function getEmail(){
    return $this->email;
  }

  public function setEmail($email){
    $this->email = $email;
  }


  public function getSenha(){
    return $this->senha;
  }

  public function setSenha($senha){
    $this->senha = $senha;
  }


  public function getFoto(){
    return $this->foto;
  }

  public function setFoto($foto){
    $this->foto = $foto;
  }


  public function getChave(){
    return $this->chave;
  }

  public function setChave($foto){
    $this->chave = $chave;
  }


  public function getAtivo(){
    return $this->ativo;
  }

  public function setAtivo($ativo){
    $this->ativo = $ativo;
  }

}

?>

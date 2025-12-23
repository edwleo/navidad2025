<?php

require_once 'Conexion.php';

class Premio extends Conexion{

  private $pdo;

  public function __construct(){
    $this->pdo = parent::getConexion();
  }

  public function obtenerPremios(){
    try{
      $sql = "SELECT * FROM premios";
      $consulta = $this->pdo->prepare($sql);
      $consulta->execute();

      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

}
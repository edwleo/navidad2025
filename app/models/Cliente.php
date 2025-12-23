<?php

require_once 'Conexion.php';

class Cliente extends Conexion
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = parent::getConexion();
  }

  private function resumenCanastas(){
    try{
      $sql = "
      SELECT
        clientes.distrito, COUNT(clientes.distrito)
        FROM ganadores
        INNER JOIN clientes ON clientes.idcliente = ganadores.idcliente
        WHERE ganadores.idpremio = 1
        GROUP BY clientes.distrito;
      ";

      $consulta = $this->pdo->prepare($sql);
      
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  /* Se debe indicar el distrito de donde se obtendrá */
  public function obtenerCanasta($distrito): array
  {
    /* 
    let distribucionCanastas = {
      "CHINCHA ALTA" : 9,
      "GROCIO PRADO": 2,
      "PUEBLO NUEVO": 3,
      "SUNAMPE": 14,
      "TAMBO DE MORA": 2
    }
    */



    try {
      $sql = "
      SELECT idcliente, cliente, dni 
        FROM clientes 
        WHERE activo = 1 AND distrito = ?
        ORDER BY RAND() LIMIT 1
      ";

      $consulta = $this->pdo->prepare($sql);
      $consulta->execute(array($distrito));

      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

}
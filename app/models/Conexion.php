<?php

//Todos los modelos (lógica / motor de la App) requieren acceder 
//a la base de datos, esta clase, brindará este acceso.
class Conexion{

  //Atributos
  private $servidor = "localhost";
  private $puerto = "3306";
  private $baseDatos = "tiendaperu";
  private $usuario = "root";
  private $clave = "";

  //Método
  public function getConexion(){
    //try catch = manejador de excepciones|errores
    //try   (intentar)
    //catch (accidente, error)
    try{
      //La clase PDO permite conectarte a diferentes motores de BD,
      //requiere una configuración mínima y es fácil de utilizar
      $pdo = new PDO(
        "mysql:host={$this->servidor}; port={$this->puerto}; dbname={$this->baseDatos}; charset=UTF8", 
        $this->usuario, 
        $this->clave);

      //Configurar el manejo de errores en PDO
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      return $pdo;
    }
    catch(Exception $e){
      //Cuando se suscitó un error...
      die($e->getMessage());
    }
  }

}
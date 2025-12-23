<?php

//Requerimos de la conexión
require_once 'Conexion.php';

//Herencia (Conexion sede su método a Producto)
class Producto extends Conexion
{

  //Este atributo contendrá la conexión
  private $pdo;

  //Constructor
  public function __construct()
  {
    //La conexión asigna el acceso a $this->pdo
    $this->pdo = parent::getConexion();
  }

  //¿Qué funciones podemos realizar?
  public function listar(): array
  {
    try {
      //1. Crear la consulta SQL
      $sql = "
        SELECT 
          id, clasificacion, marca, descripcion, garantia, ingreso, cantidad
          FROM productos
          ORDER BY id DESC
      ";

      //2. Enviar la consulta preparada a PDO
      $consulta = $this->pdo->prepare($sql);

      //3. Ejecutar la consulta
      $consulta->execute();

      //4. Entregar resultado
      //fetchAll (colección de arreglos)
      //PDO::FETCH_ASSOC (los valores son asociativos)
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return [];
    }
  }

  public function registrar($registro = []): int
  {
    try {
      //Los comodines, poseen índices (arreglos)
      $sql = "
      INSERT INTO productos 
        (clasificacion, marca, descripcion, garantia, ingreso, cantidad) VALUES
        (?,?,?,?,?,?)
      ";

      $consulta = $this->pdo->prepare($sql);

      //La consulta, lleva comodines, pasamos los datos en execute()
      $consulta->execute(
        array(
          $registro['clasificacion'],
          $registro['marca'],
          $registro['descripcion'],
          $registro['garantia'],
          $registro['ingreso'],
          $registro['cantidad']
        )
      );

      //Retornar la PK (Primary Key) generada
      return $this->pdo->lastInsertId();

    } catch (Exception $e) {
      return -1;
    }
  }

  public function eliminar($id): int
  {
    try {
      $sql = "DELETE FROM productos WHERE id = ?";
      $consulta = $this->pdo->prepare($sql);

      //El execute() está vacío cuando NO utilizas comodines
      $consulta->execute(
        array($id)
      );

      //¿Qué debemos devolver?
      //Retorna la cantidad de filas afectadas
      return $consulta->rowCount();
    } catch (Exception $e) {
      return -1;
    }
  }

  public function actualizar($registro = []): int
  {
    try {
      //Los comodines, poseen índices (arreglos)
      $sql = "
      UPDATE productos SET
        clasificacion = ?,
        marca = ?,
        descripcion = ?,
        garantia = ?,
        ingreso = ?,
        cantidad = ?,
        updated = now()
      WHERE id = ?
      ";

      $consulta = $this->pdo->prepare($sql);

      //La consulta, lleva comodines, pasamos los datos en execute()
      $consulta->execute(
        array(
          $registro['clasificacion'],
          $registro['marca'],
          $registro['descripcion'],
          $registro['garantia'],
          $registro['ingreso'],
          $registro['cantidad'],
          $registro['id']
        )
      );

      //¿Cuántos registros fueron afectados?
      return $consulta->rowCount();

    } catch (Exception $e) {
      return -1;
    }
  }

  public function buscar($id)
  {
    try {
      //1. Crear la consulta SQL
      $sql = "
        SELECT 
          id, clasificacion, marca, descripcion, garantia, ingreso, cantidad
          FROM productos
          WHERE id = ?
      ";

      //2. Enviar la consulta preparada a PDO
      $consulta = $this->pdo->prepare($sql);

      //3. Ejecutar la consulta
      $consulta->execute(array($id));

      //4. Entregar resultado
      //fetchAll (colección de arreglos)
      //PDO::FETCH_ASSOC (los valores son asociativos)
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return [];
    }
  }

}
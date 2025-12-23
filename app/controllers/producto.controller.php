<?php

//Necesita del modelo para poder responder...
require_once '../models/Producto.php';
$producto = new Producto();

//¿Qué operación desea realizar el usuario?
//consulta, registro, actualizar, eliminar, buscar ¿?

//isset()     : función que determina si un objeto existe, fue definido
//$_POST['']  : permite interactuar con valores que envía la vista

//JSON        : JavaScript Object Notation
//Mecanismo de intercambio de datos
if (isset($_POST['operacion'])) {

  //El usuario nos envío una tarea...
  switch ($_POST['operacion']) {
    case 'listar':
      $registros = $producto->listar();
      echo json_encode($registros);
      break;
    case 'registrar':
      //$_POST['variable] ... son datos que vienen de la vista
      $datos = [
        "clasificacion" => $_POST['clasificacion'],
        "marca"         => $_POST['marca'],
        "descripcion"   => $_POST['descripcion'],
        "garantia"      => $_POST['garantia'],
        "ingreso"       => $_POST['ingreso'],
        "cantidad"      => $_POST['cantidad']
      ];
      $idobtenido = $producto->registrar($datos);
      echo json_encode(["id" => $idobtenido]);
      break;
    case 'actualizar':
      //Algoritmo...
      break;
    case 'eliminar':
      //Algoritmo...
      break;
  }

}
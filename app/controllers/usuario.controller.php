<?php
session_start();

//Sino existe creamos una sesión, solo la primera vez
if (!isset($_SESSION['acceso'])){
  $_SESSION['acceso'] = false;
}

require_once "../models/Usuario.php";
$usuario = new Usuario();

if (isset($_POST['operacion'])){
  if ($_POST['operacion'] == 'login'){
    $resultado = $usuario->login(["username" => $_POST['username'], "password" => $_POST['password']]);
    
    //Asignamos el estado del resultado a la sesión
    $_SESSION['acceso'] = $resultado['status'];

    echo json_encode($resultado);
  }
}

if (isset($_GET['operacion'])){
  if ($_GET['operacion'] == 'destroy'){
    session_start();
    session_destroy();
    session_unset();
    header("Location: ../../"); //index
  }
}
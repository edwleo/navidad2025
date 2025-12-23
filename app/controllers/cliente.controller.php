<?php

require_once '../models/Cliente.php';
$cliente = new Cliente();

if (isset($_POST['operacion'])){

  if ($_POST['operacion'] == 'obtenerCanasta'){
    echo json_encode($cliente->obtenerCanasta($_POST['distrito']));
  }

}
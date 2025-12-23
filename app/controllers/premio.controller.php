<?php

require_once '../models/Premio.php';
$premio = new Premio();

if (isset($_POST['operacion'])){

  if ($_POST['operacion'] == 'obtenerPremios'){
    echo json_encode($premio->obtenerPremios());
  }

}
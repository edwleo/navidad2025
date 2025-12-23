<?php

class Usuario{

  public function login($datos = []): array{
    $usuarios = [
      ["username" => "ivan", "password" => ".sorteo2025", "datos" => "José Ivan de la Cruz Napa"],
      ["username" => "animador", "password" => ".navidad2025", "datos" => "Animador"],
      ["username" => "sistemas", "password" => ".premios2025", "datos" => "Jhon Francia Minaya" ]
    ];

    $resultado = ["status" => false, "usuario" => ""];
    $i = 0;
    while (!$resultado["status"] && $i < count($usuarios)){
      if ($datos['username'] == $usuarios[$i]['username'] && $datos['password'] == $usuarios[$i]['password']){
        $resultado["status"] = true;
        $resultado["usuario"] = $usuarios[$i]["datos"];
      }
      $i++;
    }

    return $resultado;    
  }

}
<?php

require_once 'Conexion.php';

class Cliente extends Conexion
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = parent::getConexion();
  }

  public function resumenCanastas(): array{
    try{
      $sql = "
      SELECT
        clientes.distrito, COUNT(clientes.distrito) 'total'
        FROM ganadores
        INNER JOIN clientes ON clientes.idcliente = ganadores.idcliente
        WHERE ganadores.idpremio = 1
        GROUP BY clientes.distrito;
      ";

      $consulta = $this->pdo->prepare($sql);
      $consulta->execute();

      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function descontarPremio(int $idpremio){
    try{
      $sql = "UPDATE premios SET disponible = disponible - 1 WHERE idpremio = ?";
      $consulta = $this->pdo->prepare($sql);
      $consulta->execute(array($idpremio));
    }catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function desactivarJugador($idcliente){
    try{
      $sql = "UPDATE clientes SET activo = 0 WHERE idcliente = ?";
      $consulta = $this->pdo->prepare($sql);
      $consulta->execute(array($idcliente));
    }catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function registrarGanador($idcliente, $idpremio){
    try{
      $sql = "INSERT INTO ganadores (idcliente, idpremio) VALUES (?,?)";
      $consulta = $this->pdo->prepare($sql);
      $consulta->execute(array($idcliente, $idpremio));
    }catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function obtenerPremio(int $idpremio){
    try{
      $sql = "
      SELECT idcliente, cliente, dni, distrito 
        FROM clientes 
        WHERE activo = 1 AND distrito != 'SUNAMPE'
        ORDER BY RAND() LIMIT 1
      ";

      $consulta = $this->pdo->prepare($sql);
      $consulta->execute();
      $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

      $this->descontarPremio($idpremio); 
      $this->desactivarJugador($resultado[0]['idcliente']);
      $this->registrarGanador($resultado[0]['idcliente'], $idpremio); 

      return $resultado[0];
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  /* Se debe indicar el distrito de donde se obtendrá */
  public function obtenerCanasta(): array
  {
    /* De esta manera sabemos como está la distribución */
    $listaDistritos = ["CHINCHA ALTA", "GROCIO PRADO", "PUEBLO NUEVO", "SUNAMPE", "TAMBO DE MORA"];
    $distrito = "";
    $resumen = $this->resumenCanastas();

    //Este algoritmo permite balancear los ganadores en todos los distritos proporcionalmente
    if (count($resumen) == 0){
      /* No ha salido ninguna canasta */
      $distrito = "SUNAMPE"; //Iniciamos con el distrito que tiene más clientes
    }else{

      $debeBuscarDistrito = true;

      while ($debeBuscarDistrito){
        //Elegimos un distrito de la lista aleatoriamente
        $aleatorio = rand(0, 4);
  
        //Buscamos el distrito seleccionado aleatoriamente en el resultado obtenido del método
        $encontrado = false;
        $indice = -1;
        for ($i = 0; $i < count($resumen); $i++){
          if ($resumen[$i]['distrito'] == $listaDistritos[$aleatorio]){
            $indice = $i;
            $encontrado = true;
          }
        }

        //Si NO lo encontramos es porque todavía no ha salido, entonces podemos utilizarlo
        if (!$encontrado){
          $distrito = $listaDistritos[$aleatorio];
          $debeBuscarDistrito = false;
        }else{
          //En caso exista, hay que verificar que no exceda el total asignado para ese distrito
          $maximo = 0;
          switch($resumen[$indice]['distrito']){
            case 'CHINCHA ALTA': $maximo = 9; break;
            case 'GROCIO PRADO': $maximo = 2; break;
            case 'PUEBLO NUEVO': $maximo = 3; break;
            case 'SUNAMPE': $maximo = 14; break;
            case 'TAMBO DE MORA': $maximo = 2; break;
          }
  
          if ($resumen[$indice]['total'] < $maximo){
            $distrito = $resumen[$indice]['distrito'];
            $debeBuscarDistrito = false;
          }else{
            $debeBuscarDistrito = true;

            //Solo se puede intentar otro distrito cuando el juego no esté terminado
            if (count($resumen) == 5){
              //Si la suma de los totales da 30 entonces terminó
              $totalAcumulado =  intval($resumen[0]['total']) + intval($resumen[1]['total']) + intval($resumen[2]['total']) + intval($resumen[3]['total']) + intval($resumen[4]['total']);
              if ($totalAcumulado == 30){
                $distrito = "";
                $debeBuscarDistrito = false;
              }
            }
          }
        }
      }
    }

    try {

      if ($distrito == ""){
        return [];
      }

      $sql = "
      SELECT idcliente, cliente, dni, distrito 
        FROM clientes 
        WHERE activo = 1 AND distrito = ?
        ORDER BY RAND() LIMIT 1
      ";

      $consulta = $this->pdo->prepare($sql);
      $consulta->execute(array($distrito));

      $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

      //Descontamos una canasta
      $this->descontarPremio(1);  //PK 1 = Canasta
      $this->desactivarJugador($resultado[0]['idcliente']);
      $this->registrarGanador($resultado[0]['idcliente'], 1); //1 = canasta
      
      return $resultado[0];

    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

}


//$temp = new Cliente();
//var_dump($temp->obtenerCanasta());
//var_dump($temp->resumenCanastas());
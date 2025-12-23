USE navidad;

-- Obtener todos los premios
SELECT * FROM premios;

-- Una persona al azahar
SELECT idcliente, cliente, dni 
  FROM clientes 
  WHERE activo = 1 AND distrito = 'CHINCHA ALTA'
  ORDER BY RAND() LIMIT 1;


SELECT * FROM clientes;

-- Registrar de prueba
SELECT idcliente, cliente, distrito FROM clientes WHERE distrito = 'PUEBLO NUEVO';

SELECT * FROM premios;

SELECT * FROM ganadores;

INSERT INTO ganadores (idcliente, idpremio) VALUES
  (10,1),
  (13,1),
  (72,1),
  (502,1),
  (588,1),
  (145,1);

SELECT
  ganadores.idganador,
  clientes.cliente, clientes.distrito,
  premios.nombre
  FROM ganadores
  INNER JOIN clientes ON clientes.idcliente = ganadores.idcliente
  INNER JOIN premios ON premios.idpremio = ganadores.idpremio;

-- esta consulta retorna la cantidad de canastas por distrito que salieron
SELECT
  clientes.distrito, COUNT(clientes.distrito)
  FROM ganadores
  INNER JOIN clientes ON clientes.idcliente = ganadores.idcliente
  WHERE ganadores.idpremio = 1
  GROUP BY clientes.distrito;
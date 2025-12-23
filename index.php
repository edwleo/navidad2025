<?php
session_start();

if (isset($_SESSION['acceso']) && $_SESSION['acceso']){
  header("Location: ./views/sorteo/");
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    />
  </head>
  <body>
    <div class="container mt-3 text-center">
      <img
        src="./public/images/delafiber.png"
        style="max-width: 320px"
        class="img-fluid"
        alt=""
      />
      <div class="row">
        <div class="col-md-4 mx-auto">
          <form action="" autocomplete="off" id="login">
            <div class="card rounded-0 mt-3">
              <div class="card-header rounded-0 bg-dark text-light">
                Complete sus datos
              </div>
              <div class="card-body rounded-0">
                <div class="form-floating mb-2">
                  <input
                    type="text"
                    class="form-control"
                    id="usuario"
                    value="ivan"
                    required
                    autofocus
                  />
                  <label for="usuario" class="form-label">Usuario</label>
                </div>
                <div class="form-floating">
                  <input
                    type="password"
                    class="form-control"
                    id="clave"
                    value=".sorteo2025"
                    required
                    autofocus
                  />
                  <label for="clave" class="form-label">Password</label>
                </div>
              </div>
            </div>
            <div class="d-grid mt-2">
              <button class="btn btn-primary rounded-0">Iniciar sesión</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        document.querySelector("#login").addEventListener("submit", function (event){
          event.preventDefault()

          const datos = new FormData()
          datos.append("operacion", "login")
          datos.append("username", document.querySelector("#usuario").value)
          datos.append("password", document.querySelector("#clave").value)

          fetch(`./app/controllers/usuario.controller.php`, {
            method: 'POST',
            body: datos
          })
            .then(response => response.json())
            .then(data => {
              if (data.status){
                window.location.href = './views/sorteo/'
              }else{
                document.querySelector("#usuario").focus()
                alert('Verifique los datos para continuar')
              }
            })
        })
      })
    </script>

  </body>
</html>

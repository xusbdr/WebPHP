<?php 

if(empty($_SERVER['HTTP_REFERER'])) {
    // Si no hay URL de referencia, redirigir al usuario a la página de inicio o a donde quieras
    header('Location: index.php');
    exit();
}


// Incluir el archivo que contiene la configuración de la base de datos y establece la conexión
include("BaseDatos.php");


// Incluir el script de comprobación de inactividad
include("Temporizador.php");



$fotoUsuario = "";
?>




<?php include("templatesss/headerUsuario.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            background-image: url('imagenes/fonfoPrincipal.jpg');
            background-color: #ADD8E6;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        figure {
            border-radius: 10px;
            background-image: url('imagenes/fonga.jpg');
            padding: 15px 5px 15px;
            box-shadow:rgb(7, 6, 3) 5px 5px 7px;
            text-align: center;
            margin: 25px;
            justify-content: space-between;
        }

        .figure img:hover {
            transform:scale(1.03);
            transition: transform 0.5s;
        }

        .section {
            flex: 0 0 50%;
            padding: 10px;
            text-align:right;
        }

        figcaption {
            text-align: center;
            color: white;
            font-size: 20px;
            padding: auto;
            font-family: fantasy;
        }
    </style>




</head>
<body>
    <section class="section">
        <figure class="figure img:hover">
            <img src="imagenes/f.jpg" width="200px" height="145px" />
            <figcaption>Juegos del año </figcaption>
        </figure>
    </section>

    <section class="section">
        <figure class="figure img:hover">
            <img src="imagenes/video4.jpg" width="200px" height="145px" />
            <figcaption>Lanzamientos </figcaption>
        </figure>
    </section>

    <section class="section">
        <figure class="figure img:hover">
            <img src="imagenes/video3.jpg" width="200px" height="145px" />
            <figcaption>Play  </figcaption>
        </figure>
    </section>

   


<?php

  
  if (isset($user["nombre"])) {
      $_SESSION["username"] = $user["nombre"]; // Asignar el nombre de usuario a la variable de sesión
  }

  $idUsuario = isset($_SESSION["username"]) ? $_SESSION["username"] : ""; // Obtener el nombre de usuario de la sesión
  $rutaPagina = basename($_SERVER['PHP_SELF']); // Obtener la ruta de la página actual

  // Consultar el ID de la página en la tabla `pagina`
  $queryPagina = "SELECT idpagina FROM pagina WHERE rutapagina = '$rutaPagina'";
  $resultPagina = mysqli_query($conexion, $queryPagina);
  if ($resultPagina && mysqli_num_rows($resultPagina) > 0) {
      $pagina = mysqli_fetch_assoc($resultPagina);
      $idPagina = $pagina['idpagina'];
  } else {
      // Manejar el caso en el que la ruta de la página no está en la tabla `pagina`
      $idPagina = null;
  }

  $fechaVisita = date('Y-m-d');
  $horaVisita = date('H:i:s');
  

  // Verificar si los valores están definidos antes de usarlos
  if (isset($fechaVisita) && isset($horaVisita)) {
      $sql = "INSERT INTO visitas (idUsuario, idPagina, fechavisita, horavisita) 
              VALUES ('$idUsuario', '$idPagina', '$fechaVisita', '$horaVisita')";
      mysqli_query($conexion, $sql);
  } else {
      // Manejar el caso en el que las variables no están definidas
      echo "Error: No se pudo obtener la fecha y hora de la visita.";
  }

?>


</body>
</html>



<?php
// inicio de sesion
session_start();





// Base URL
$url_base = "http://localhost/ProyectoJesus/";

// Verificar si se ha iniciado sesión y obtener el nombre de usuario y la foto del usuario desde la sesión
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = '';
}

if(isset($_SESSION['foto'])) {
    $foto = $_SESSION['foto'];
} else {
    $foto = '';
}



if(isset($_SESSION['idUsuario'])) {
    $idUsuario = $_SESSION['idUsuario'];
} else {
    $idUsuario = '';
}




?>

<!doctype html>
<html lang="en">
<head>
    <title>Title</title>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <style>
    .welcome-container {
        font-family:fantasy;
        font-size:large;
    }
    </style>

</head>

<body>
    <header>
   
    </header>

    <nav class="navbar navbar-expand navbar-light bg-light">
        <ul class="nav navbar-nav">

            


            <a class="nav-link" href="modificarUsuario.php?idUsuario=<?php echo $idUsuario; ?>">Modificar</a>




            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base; ?>contacto">Contacto</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base; ?>cerrarConexion">Cerrar Sesión</a>
            </li>

            &nbsp;
          
            <div class="welcome-container">
                <?php if(!empty($username)): ?>
                    <li class="nav-item">
                        <span class="nav-link disabled">Bienvenido <?php echo $username; ?></span>
                    </li>
                <?php endif; ?>
            </div>

            &nbsp; &nbsp; &nbsp; &nbsp;
<!-- Foto del usuario en la esquina superior derecha -->
<img src="<?php echo $foto; ?>" alt=" " class="user-photo">


            <td>
    


        </ul>
    </nav>


</body>
</html>

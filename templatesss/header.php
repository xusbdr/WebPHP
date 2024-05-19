
<?php
$url_base="http://localhost/ProyectoJesus/";


// Incluir el script de comprobación de inactividad
include("Temporizador.php");
?>





<!doctype html>
<html lang="en">
    <head>
        <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
    </head>





    <body>
        <header>
            <!-- place navbar here -->
        </header>

     
        <nav class="navbar navbar-expand navbar-light bg-light">
        <ul class="nav navbar-nav">


           

        <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base; ?>index">Principal</a>
            </li>




            <li class="nav-item">
            <a class="nav-link" href="<?php echo $url_base; ?>usuario">Usuarios</a>
            </li>



            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base; ?>Suscripcion">Suscripción</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base; ?>Visita">Visita</a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base; ?>Pagina">Pagina</a>
            </li>



            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base; ?>contacto">Contacto</a>
            </li>


            

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url_base; ?>cerrarConexion">Cerrar sesión</a>
            </li>

          
        </ul>
    </nav>
     




        <main class = "container">
<?php


if(empty($_SERVER['HTTP_REFERER'])) {
    // Si no hay URL de referencia, redirigir al usuario a la página de inicio o a donde quieras
    header('Location: index.php');
    exit();
}


// Incluir archivo de conexión a la base de datos
include("BaseDatos.php");

// Incluir el script de comprobación de inactividad
include("Temporizador.php");



// Verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['username'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header("Location: index.php");
    exit();
}

// Registrar la visita actual en la base de datos
$idUsuario = $_SESSION['username'];
$idPagina = basename($_SERVER['PHP_SELF']);
$fechaVisita = date('Y-m-d');
$horaVisita = date('H:i:s');

$sql = "INSERT INTO visitas (idUsuario, idPagina, fechavisita, horavisita) 
        VALUES ('$idUsuario', '$idPagina', '$fechaVisita', '$horaVisita')";
$conexion->query($sql);

// Consulta para obtener la lista actualizada de visitas
$resultado = $conexion->query("SELECT * FROM `visitas`");
$lista_visitas = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<?php include("templatesss/header.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Visitas</title>
</head>
<body>
    <h1>Registro de Visitas por Usuario</h1>

    <div class="container">
        <br/>
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10%;">Usuario</th>
                                <th scope="col" style="width: 20%;">Página Visitada</th>
                                <th scope="col" style="width: 20%;">Fecha Visita</th>
                                <th scope="col" style="width: 20%;">Hora Visita</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista_visitas as $registro) : ?>
                                <tr>
                                    <td><?php echo $registro['idUsuario']; ?></td>
                                    <td><?php echo $registro['idPagina']; ?></td>
                                    <td><?php echo $registro['fechavisita']; ?></td>
                                    <td><?php echo $registro['horavisita']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

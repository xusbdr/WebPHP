<?php 

include("ComprobacionURL.php");


include("BaseDatos.php");
include("templatesss/header50.php");

// Incluir el script de comprobación de inactividad
include("Temporizador.php");


$fechaNacimiento = isset($_POST['fechaNacimiento']) ? $_POST['fechaNacimiento'] : '';



$nombre = "";
$username = "";
$contrasenya = "";
$sexo = "";

$tipoSuscripcion = ""; 
$edadMinima = 18;



?>

<!-- Estilos personalizados -->
<style>
    body {
        background-image: url('imagenes/fondo4.jpg');
        background-color: #ADD8E6;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        height: 60vh;
        margin: 0;
        padding: 0;
    }
</style>

<br/><br/><br/><br/>

<div class="card">
    
<div class="card-body">
       
<form action="añadirUsuarios.php" method="post" enctype="multipart/form-data">
          

            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre   &nbsp;&nbsp;  <span class="hint">  (Minimo 3 letras)</span></label>
                <input type="text" value="<?php echo $nombre; ?>" class="form-control" name="nombre" id="nombre" placeholder="Nombre" />
                <?php 
                if(isset($_POST['nombre'])) {
                    if(empty($_POST['nombre'])) {
                        echo "<p class='text-danger'>El nombre es obligatorio.</p>";
                    } elseif (!preg_match("/^[A-Za-z]{3,}+$/", $_POST['nombre'])) {
                        echo "<p class='text-danger'>Debe contener minimo 3 letras.</p>";
                    } elseif (strlen($_POST['nombre']) > 10) {
                        echo "<p class='text-danger'>El nombre debe tener minimo 3 letras.</p>";
                    }
                }
                ?>



            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username   &nbsp; <span class="hint">   (debe contener letras y números, mínimo 8 caracteres)</span></label> 
                <input type="text" value="<?php echo $username; ?>" class="form-control" name="username" id="username" placeholder="Username" />
               
               <?php 
                if(isset($_POST['username'])) {
                    if(empty($_POST['username'])) {
                        echo "<p class='text-danger'>El username es obligatorio.</p>";
                    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $_POST['username'])) {
                        echo "<p class='text-danger'>El username debe tener al menos 8 caracteres y contener letras y números.</p>";
                    }
                }
                ?>
            </div>



            

            <div class="mb-3">
                <label for="contrasenya" class="form-label">Contraseña  <span class="hint">   (debe contener al menos 8 caracteres de letras, números y carácter especial)</span></label>  
                <input type="password" class="form-control" name="contrasenya" id="contrasenya" placeholder="Contraseña" value="<?php echo $contrasenya; ?>" />
                <?php 
                if(isset($_POST['contrasenya'])) {
                    if(empty($_POST['contrasenya'])) {
                        echo "<p class='text-danger'>La contraseña es obligatoria.</p>";
                    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $_POST['contrasenya'])) {
                        echo "<p class='text-danger'>La contraseña debe tener al menos 8 caracteres, incluyendo al menos una letra, un número y un carácter especial.</p>";
                    }
                }
                ?>
            </div>



        <div class="mb-3">
            <label for="sexo" class="form-label">Sexo</label>
            <div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexo" id="masculino" value="masculino" <?php if(empty($sexo) || $sexo == 'masculino') echo 'checked'; ?>>
            <label class="form-check-label" for="masculino">Masculino</label>
            </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="sexo" id="femenino" value="femenino" <?php if($sexo == 'femenino') echo 'checked'; ?>>
            <label class="form-check-label" for="femenino">Femenino</label>
            </div>
            </div>
            </div>




            <div class="mb-3">
                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento (dd/mm/aaaa)</label>  
                <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" value="<?php echo $fechaNacimiento; ?>" />
                <?php 
                if(isset($_POST['fechaNacimiento'])) {
                    if(empty($_POST['fechaNacimiento']) || strtotime($_POST['fechaNacimiento']) === false || strtotime($_POST['fechaNacimiento']) >= strtotime(date('Y-m-d')) || strtotime("-$edadMinima years", strtotime(date('Y-m-d'))) < strtotime($_POST['fechaNacimiento'])) {
                        echo "<p class='text-danger'>La fecha de nacimiento debe ser una fecha válida y el usuario debe tener al menos 18 años.</p>";
                    }
                }
                ?>
            </div>

            <div class="mb-3">
                <label for="tipoSuscripcion" class="form-label">Tipo de Suscripción</label>
                <select class="form-select" name="tipoSuscripcion" id="tipoSuscripcion">
                    <option value="basica" <?php if($tipoSuscripcion == "basica") echo "selected"; ?>>Básico</option>
                    <option value="premium" <?php if($tipoSuscripcion == "premium") echo "selected"; ?>>Premium</option>
                    <option value="profesional" <?php if($tipoSuscripcion == "profesional") echo "selected"; ?>>Profesional</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input class="form-control" type="file" name="foto" id="foto">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="btn">Guardar</button>
            </div>






<?php
// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validaciones y procesamiento de datos
    $errores = array();

    // Validar nombre
    if(empty($_POST['nombre']) || !preg_match("/^[A-Za-z]{3,50}$/", $_POST['nombre'])) {
        $errores[] = "El nombre es obligatorio y debe contener letras.";
    }

    // Validar username
    if(empty($_POST['username']) || !preg_match("/^[A-Za-z0-9]{8,}$/", $_POST['username'])) {
        $errores[] = "El username es obligatorio y debe contener letras y números, mínimo 8 caracteres.";
    }

    // Validar contraseña
    if(empty($_POST['contrasenya']) || !preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $_POST['contrasenya'])) {
        $errores[] = "La contraseña es obligatoria y debe tener al menos 8 caracteres,letras,números y un carácter especial.";
    }

    // Validar fecha de nacimiento
    if(empty($_POST['fechaNacimiento']) || strtotime($_POST['fechaNacimiento']) === false || strtotime($_POST['fechaNacimiento']) >= strtotime(date('Y-m-d')) || strtotime("-$edadMinima years", strtotime(date('Y-m-d'))) < strtotime($_POST['fechaNacimiento'])) {
        $errores[] = "La fecha de nacimiento debe ser una fecha válida y el usuario debe tener al menos 18 años.";
    }

    // Si no hay errores, guardar los datos
    if (empty($errores)) {
        $nombre = $_POST['nombre'];
        $username = $_POST['username'];
        $contrasenya = $_POST['contrasenya'];
        $sexo = $_POST['sexo'];
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $tipoSuscripcion = $_POST['tipoSuscripcion'];
        $foto = ''; // Foto vacía

        if(empty($tipoSuscripcion)) {
            echo "Por favor, seleccione un tipo de suscripción.";
            exit;
        }

        // Validar si el usuario tiene al menos 16 años
        $fechaHoy = new DateTime();
        $fechaNac = new DateTime($fechaNacimiento);
        $edad = $fechaHoy->diff($fechaNac)->y;

        if ($edad >= 16) {
            // Insertar usuario sin guardar la foto
            $sqlUsuario = "INSERT INTO usuario (nombre, username, contrasenya, sexo, fechaNacimiento,tipoSuscripcion ,foto) VALUES (?, ?, ?, ?, ?, ?,?)";
            $sentenciaUsuario = $conexion->prepare($sqlUsuario);
            $sentenciaUsuario->bind_param("sssssss", $nombre, $username, $contrasenya, $sexo, $fechaNacimiento,$tipoSuscripcion, $foto);
            $resultadoUsuario = $sentenciaUsuario->execute();

            if ($resultadoUsuario) {
                // Todo ha sido insertado exitosamente
                echo "<script>setTimeout(function(){window.location.href='usuario.php'},8000);</script>";
                echo "<p class='text-success'>Los datos se actualizaron correctamente.</p>";
                exit();
            } else {
                // Hubo un error al insertar el usuario
                echo "<p class='text-danger'>Error al guardar los datos de usuario en la base de datos: " . $conexion->error . "</p>";
            }
        }
    }
}
?>

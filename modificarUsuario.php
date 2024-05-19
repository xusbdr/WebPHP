<?php 
include("BaseDatos.php");
session_start();

// Incluir el script de comprobación de inactividad
include("Temporizador.php");

// Si no hay URL de referencia, redirigir al usuario a la página de inicio o a donde quieras
if(empty($_SERVER['HTTP_REFERER'])) {
    header('Location: index.php');
    exit();
}

$idUsuario = "";
$nombre = "";
$username = "";
$contrasenya = "";
$sexo = "";
$fechaNacimiento = "";
$tipoSuscripcion = ""; 
$edadMinima = 18; // Define la edad mínima

if(isset($_GET['idUsuario'])) { 
    $idUsuario = $_GET['idUsuario'];

    $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE idUsuario = ?");
    $sentencia->bind_param("i", $idUsuario);
    $sentencia->execute();
    $resultado = $sentencia->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $nombre = $usuario["nombre"];
        $username = $usuario["username"];
        $contrasenya = $usuario["contrasenya"];
        $sexo = $usuario["sexo"];
        $fechaNacimiento = $usuario["fechaNacimiento"];
        $tipoSuscripcion = $usuario["tipoSuscripcion"];
        $foto = $usuario["foto"];
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
}
?>

<?php include("templatesss/header50.php"); ?>

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

    h1 {
        font-family: fantasy;
        font-size: 45px;
        color: black;
    }

    .hint {
        font-size: 12px;
        color: gray;
    }
</style>

<br/>
<h1>Modificar Usuario</h1>


<div class="card">
    <div class="card-body">
        <form action="modificarUsuario.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="idUsuario" class="form-label">ID</label>
                <input type="text" value="<?php echo $idUsuario; ?>" class="form-control" readonly name="idUsuario" id="idUsuario" placeholder="ID" />
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre <span class="hint">(Solo letras, mínimo 3)</span></label>
                <input type="text" value="<?php echo $nombre; ?>" class="form-control" name="nombre" id="nombre" placeholder="Nombre" required pattern="[A-Za-z]{3,50}" title="Debe contener solo letras y tener mínimo 3 caracteres" />
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username   &nbsp;  <span class="hint">(debe contener letras y números, mínimo 8 caracteres)</span></label> 
                <input type="text" value="<?php echo $username; ?>" class="form-control" name="username" id="username" placeholder="Username" required pattern="[A-Za-z0-9]{8,}" title="Debe contener letras y números, mínimo 8 caracteres" />
            </div>

            <div class="mb-3">
                <label for="contrasenya" class="form-label">Contraseña   <span class="hint">(debe contener al menos 8 caracteres de letras, números y carácter especial)</span></label>  
                <input type="password" class="form-control" name="contrasenya" id="contrasenya" placeholder="Contraseña" value="<?php echo $contrasenya; ?>" required pattern="(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" title="Debe tener al menos 8 caracteres, letras, números y un carácter especial" />
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sexo" id="masculino" value="masculino" <?php if($sexo == 'masculino') echo 'checked'; ?>>
                        <label class="form-check-label" for="masculino">Masculino</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sexo" id="femenino" value="femenino" <?php if($sexo == 'femenino') echo 'checked'; ?>>
                        <label class="form-check-label" for="femenino">Femenino</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento (dd/mm/aaaa) <span class="hint">(Debe ser mayor de 18 años)</span></label>  
                <input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" value="<?php echo $fechaNacimiento; ?>" required max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>" />
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
                <a href="usuario.php" class="btn btn-secondary">Cancelar</a> 
            </div>
        </form>
    </div>
</div>


<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar campos
    $errores = array();

    // Validar nombre
    if(empty($_POST['nombre'])) {
        $errores[] = "El nombre es obligatorio.";
    } elseif (!preg_match("/^[A-Za-z]{3,50}$/", $_POST['nombre'])) {
        $errores[] = "El nombre debe contener solo letras y tener mínimo 3 caracteres.";
    }

    // Validar username
    if(empty($_POST['username'])) {
        $errores[] = "El username es obligatorio.";
    } elseif (!preg_match("/^[A-Za-z0-9]{8,}$/", $_POST['username'])) {
        $errores[] = "El username debe contener letras y números, mínimo 8 caracteres.";
    }

    // Validar contraseña
    if(empty($_POST['contrasenya'])) {
        $errores[] = "La contraseña es obligatoria.";
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $_POST['contrasenya'])) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres, letras, números y un carácter especial.";
    }

    // Validar fecha de nacimiento
    if(empty($_POST['fechaNacimiento']) || strtotime($_POST['fechaNacimiento']) === false || strtotime($_POST['fechaNacimiento']) >= strtotime(date('Y-m-d')) || strtotime("-$edadMinima years", strtotime(date('Y-m-d'))) < strtotime($_POST['fechaNacimiento'])) {
        $errores[] = "La fecha de nacimiento debe ser una fecha válida y el usuario debe tener al menos 18 años.";
    }

    if (!empty($errores)) {
        foreach($errores as $error) {
            echo "<p class='text-danger'>$error</p>";
        }
    } else {
        // Actualizar los datos

        $idUsuario = $_POST['idUsuario'];
        $nombre = $_POST['nombre'];
        $username = $_POST['username'];
        $contrasenya = $_POST['contrasenya'];
        $sexo = $_POST['sexo'];
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $tipoSuscripcion = $_POST['tipoSuscripcion'];
        $foto = ''; // Foto vacía

        // Actualizar datos en la base de datos
        $sql = "UPDATE usuario SET nombre=?, username=?, contrasenya=?, sexo=?, fechaNacimiento=?, tipoSuscripcion=?, foto=? WHERE idUsuario=?";
        $sentencia = $conexion->prepare($sql);
        $sentencia->bind_param("sssssssi", $nombre, $username, $contrasenya, $sexo, $fechaNacimiento, $tipoSuscripcion, $foto, $idUsuario);

        $resultado = $sentencia->execute();

        if ($resultado) {
            if ($sentencia->affected_rows > 0) {
                echo "<script>setTimeout(function(){window.location.href='usuario.php'},3000);</script>";
                echo "<p class='text-success'>Los datos se actualizaron correctamente.</p>";
                exit();
            } else {
                echo "<p class='text-danger'>No se realizaron cambios en los datos.</p>";
            }
        }
    } 
}
?>



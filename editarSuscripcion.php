<?php 

if(empty($_SERVER['HTTP_REFERER'])) {
    // Si no hay URL de referencia, redirigir al usuario a la página de inicio o a donde quieras
    header('Location: index.php');
    exit();
}




include("BaseDatos.php");

// Incluir el script de comprobación de inactividad
include("Temporizador.php");


// MODIFICAR ----------------------------
if(isset($_GET['txtID'])) { 
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";

    
    $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE idUsuario = ?");
    $sentencia->bind_param("i", $txtID);
    $sentencia->execute();
    $resultado = $sentencia->get_result();
    $registro = $resultado->fetch_assoc();
    $tiposuscripcion = $registro["tipoSuscripcion"];
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $txtID = isset($_POST['txtID']) ? $_POST['txtID'] : "";
    $tiposuscripcion = isset($_POST["tiposuscripcion"]) ? $_POST["tiposuscripcion"] : "";
    $sentencia = $conexion->prepare("UPDATE suscripcion SET tipoSuscripcion=? WHERE idUsuario=?");
    $sentencia->bind_param("si", $tiposuscripcion, $txtID);
    $sentencia->execute();
    header("Location:suscripcion.php");
    exit(); 
}

// --------





?>

<?php include("templatesss/header.php"); ?>






<br/><br/><br/><br/>
<br/><br/>


<div class="card custom-background">

<br/> 
<h1>&nbsp;&nbsp;&nbsp;  Modificar tipo de suscripcion</h1>

<br/>

    <div class="card-body">
        
        <form action="editarsuscripcion.php" method="post" enctype="multipart/form-data">
           
        <div class="mb-3">
            
                <label for="txtID" class="form-label">Número de Socio</label>
                <input type="text" value="<?php echo $txtID; ?>" class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID" />
           
           
                <!-- Campo oculto para enviar el valor de txtID -->
                <input type="hidden" name="txtID" value="<?php echo $txtID; ?>">
           
            </div>

            <div class="mb-3">
                <label for="tiposuscripcion" class="form-label">Tipo de Suscripción</label>
                <select class="form-select" name="tiposuscripcion" id="tiposuscripcion">
                    <?php
                    // Opciones de tipo de suscripción
                    $opciones_suscripcion = array("basica", "premium", "profesional");

                    // Iterar sobre las opciones y generar etiquetas <option>
                    foreach ($opciones_suscripcion as $opcion) {
                        // Verificar si la opción es la seleccionada
                        $selected = ($opcion == $tiposuscripcion) ? "selected" : "";
                        echo "<option value='$opcion' $selected>$opcion</option>";
                    }
                    ?>
                </select>
            </div>

            <br/>
            
            <div class="mb-3">
            <button type="submit" class="btn btn-primary" name="btn" onclick="goBack()">Guardar</button>
            </div>

                  <script>
                    function goBack() {
                    window.history.back();
                 }
                 
</script>


        </form>
    </div>

    
</div>



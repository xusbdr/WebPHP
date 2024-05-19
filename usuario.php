<?php


if(empty($_SERVER['HTTP_REFERER'])) {
    // Si no hay URL de referencia, redirigir al usuario a la página de inicio o a donde quieras
    header('Location: index.php');
    exit();
}



include("BaseDatos.php");

// Incluir el script de comprobación de inactividad
include("Temporizador.php");


// Consulta para obtener la lista de usuarios
$resultado = $conexion->query("SELECT * FROM `usuario`");
$lista_usuarios = $resultado->fetch_all(MYSQLI_ASSOC);





// BORRADO
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $txtID = isset($_POST['txtID']) ? $_POST['txtID'] : "";

    // Confirmación antes de borrar
    if (isset($_POST['confirmacion']) && $_POST['confirmacion'] === 'si') {
        // Preparar la consulta de eliminación de usuario
        $sql_usuario = "DELETE FROM usuario WHERE idUsuario=?";
        $sentencia_usuario = $conexion->prepare($sql_usuario);

        // Verificar si la preparación de la consulta fue exitosa
        if ($sentencia_usuario) {
            // Vincular el parámetro y ejecutar la consulta
            $sentencia_usuario->bind_param("i", $txtID);
            $resultado_usuario = $sentencia_usuario->execute();

            // Verificar si la consulta se ejecutó correctamente
            if ($resultado_usuario) {
                // Consulta para eliminar la suscripción del usuario
                $sql_suscripcion = "DELETE FROM suscripcion WHERE idUsuario=?";
                $sentencia_suscripcion = $conexion->prepare($sql_suscripcion);

                // Verificar si la preparación de la consulta fue exitosa
                if ($sentencia_suscripcion) {
                    // Vincular el parámetro y ejecutar la consulta
                    $sentencia_suscripcion->bind_param("i", $txtID);
                    $resultado_suscripcion = $sentencia_suscripcion->execute();

                    // Verificar si la consulta se ejecutó correctamente
                    if ($resultado_suscripcion) {
                        // Ambas consultas se ejecutaron con éxito
                        header("Location:usuario.php");
                        exit();
                    } else {
                        // Hubo un error al ejecutar la consulta de suscripción
                        echo "Error al ejecutar la consulta de suscripción: " . $sentencia_suscripcion->error;
                    }
                } else {
                    // Error en la preparación de la consulta de suscripción
                    echo "Error al preparar la consulta de suscripción: " . $conexion->error;
                }
            } else {
                // Hubo un error al ejecutar la consulta de usuario
                echo "Error al ejecutar la consulta de usuario: " . $sentencia_usuario->error;
            }
        } else {
            // Error en la preparación de la consulta de usuario
            echo "Error al preparar la consulta de usuario: " . $conexion->error;
        }
    } else {
        // Mostrar ventana emergente de confirmación
        echo '<div id="modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; display: flex; justify-content: center; align-items: center;">
                <div style="background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); text-align: center;">
                    <p>¿Está seguro de que desea borrar este usuario?</p>
                    <form method="post" action="usuario.php">
                        <input type="hidden" name="txtID" value="' . $txtID . '">
                        <input type="hidden" name="confirmacion" value="si">
                        <button type="submit" class="btn btn-danger" name="delete">Sí</button>
                        <button type="button" onclick="cerrarModal()" class="btn btn-secondary">Cancelar</button>
                    </form>
                </div>
              </div>';
    }
}

?>





<?php 
include("templatesss/header.php"); 
include("estiloUsuario.php");
?>





<br/><br/>


<div class="container">
    <h1>Usuarios</h1>
    <br/>
    

    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary" href="añadirUsuarios.php" role="button">Añadir Usuario</a>
        </div>

        <div class="table-responsive table-container">
            <div class="table-responsive">
                <table >
                    <thead>
                        <tr>
                            <th scope="col">NºSocio</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">UserName</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col">Sexo</th>
                            
                            <th scope="col">Fecha de Nacimiento</th>
                            <th scope="col">Tipo de Suscripción</th>
                            
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista_usuarios as $usuario) {?>
                            <tr>
                                <td><?php echo $usuario['idUsuario']; ?></td>
                                <td><?php echo $usuario['nombre']; ?></td>
                                <td><?php echo $usuario['username']; ?></td>
                                <td><?php echo $usuario['contrasenya']; ?></td>
                                <td><?php echo $usuario['sexo']; ?></td>
                                
                                <td><?php echo $usuario['fechaNacimiento']; ?></td>
                                <td><?php echo $usuario['tipoSuscripcion']; ?></td>
                              

                                <td>
    
</td>

               <td>
                                  
                <a class="btn btn-primary" href="modificarUsuario.php?idUsuario=<?php echo $usuario['idUsuario']; ?>" role="button">Modificar</a>
               <form method="post" action="usuario.php">

                &nbsp;&nbsp; 

                <input type="hidden" name="txtID" value="<?php echo $usuario['idUsuario']; ?>">
                <button type="submit" class="btn btn-danger" name="delete">Borrar</button>
                       </form>                           
                                </td>

                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<script>
    function cerrarModal() {
        var modal = document.getElementById('modal');
        modal.style.display = 'none';
    }
</script>

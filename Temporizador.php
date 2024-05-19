<script>
// Establecer el tiempo límite en milisegundos (20 segundos en este caso)
var tiempoLimite = 25000; // 

// Función para redirigir al usuario a index.php
function redireccionarAIndex() {
    window.location.href = 'index.php';
}

// Función para comprobar la inactividad del usuario
function comprobarInactividad() {
    // Obtener el tiempo de la última actividad del sessionStorage
    var tiempoUltimaActividad = sessionStorage.getItem('ultima_actividad');

    // Si no hay registro de última actividad, retornar
    if (!tiempoUltimaActividad) return;

    // Calcular el tiempo transcurrido desde la última actividad
    var tiempoActual = new Date().getTime();
    var tiempoTranscurrido = tiempoActual - parseInt(tiempoUltimaActividad);

    // Si el tiempo transcurrido supera el tiempo límite, redirigir al usuario
    if (tiempoTranscurrido > tiempoLimite) {
        redireccionarAIndex();
    }
}

// Actualizar el registro de última actividad en sessionStorage cuando haya actividad del usuario
function actualizarUltimaActividad() {
    sessionStorage.setItem('ultima_actividad', new Date().getTime());
}

// Agregar event listeners para el evento mousemove y keydown para actualizar la última actividad
document.addEventListener('mousemove', actualizarUltimaActividad);
document.addEventListener('keydown', actualizarUltimaActividad);

// Comenzar la comprobación de inactividad al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    setInterval(comprobarInactividad, 1000); // Verificar cada segundo
    actualizarUltimaActividad(); // Registrar la actividad inicial
});
</script>

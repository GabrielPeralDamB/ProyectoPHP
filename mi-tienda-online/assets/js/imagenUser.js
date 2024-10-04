function confirmarCerrarSesion() {
    // Pregunta al usuario si quiere cerrar sesión
    const confirmar = confirm("¿Deseas cerrar sesión?");
    
    if (confirmar) {
        // Si confirma, redirigir al login
        
        window.location.href = 'checkout.php'; // Cambia esto por la URL de tu página de login
    }
    // Si no confirma, no se hace nada
}
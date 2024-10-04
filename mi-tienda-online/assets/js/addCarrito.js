function comprarProducto(idProducto) {
    fetch('index.php?action=addCarrito&idProducto=' + idProducto)
        .then(response => response.text())
        .then(data => {
            alert(data); // Muestra el mensaje devuelto por el PHP
            // Puedes agregar lógica adicional aquí, como actualizar el carrito visualmente.
        })
        .catch(error => console.error('Error:', error));
}

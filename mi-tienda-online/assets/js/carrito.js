// Simulación de productos en el carrito
const cart = [
    { id: 1, nombre: 'Bezoya', cantidad: 2, precio:  0.85 },
    { id: 2, nombre: 'Agua Fina', cantidad: 3, precio: 1.75},
    { id: 3, nombre: 'Agua Pura de Mar', cantidad: 1, precio: 2.10 },
    { id: 4, nombre: 'Bezoya', cantidad: 2, precio:  0.85 },
    { id: 5, nombre: 'Agua Fina', cantidad: 3, precio: 1.75},
    { id: 6, nombre: 'Agua Pura de Mar', cantidad: 1, precio: 2.10 },
    { id: 7, nombre: 'Bezoya', cantidad: 2, precio:  0.85 },
    { id: 8, nombre: 'Agua Fina', cantidad: 3, precio: 1.75},
    { id: 9, nombre: 'Agua Pura de Mar', cantidad: 1, precio: 2.10 },
    { id: 10, nombre: 'Bezoya', cantidad: 2, precio:  0.85 },
    { id: 11, nombre: 'Agua Fina', cantidad: 3, precio: 1.75},
    { id: 12, nombre: 'Agua Pura de Mar', cantidad: 1, precio: 2.10 }
];

// Elementos del DOM
const cartItemsList = document.getElementById('cart-items-list');
const totalItems = document.getElementById('total-items');
const totalPrice = document.getElementById('total-price');

function updateCart() {
    cartItemsList.innerHTML = '';  // Limpiar la lista antes de volver a agregar productos
    let totalItemCount = 0;
    let totalCost = 0;

    cart.forEach((item, index) => {  // Añadir el índice del item para poder identificarlo
        totalItemCount += item.cantidad;
        totalCost += item.cantidad * item.precio;

        const li = document.createElement('li');
        li.innerHTML = `
            ${item.nombre} (x${item.cantidad}) - ${(item.cantidad * item.precio).toFixed(2)} € 
            <div>
            <button class="edit-button" onclick="editItem(${index})">Editar</button>
            <button class="delete-button" onclick="deleteItem(${index})">Eliminar</button>
            </div>
        `;
        cartItemsList.appendChild(li);
    });

    // Actualizar totales
    totalItems.innerText = totalItemCount;
    totalPrice.innerText = `${totalCost.toFixed(2)} €`;
}

// Función para editar el item
function editItem(index) {
    // Aquí puedes implementar la lógica para editar el item
    // Por ejemplo, mostrar un formulario o una ventana emergente con los detalles del item
    alert(`Editando item: ${cart[index].nombre}`);
}

// Función para eliminar el item
function deleteItem(index) {
    // Aquí puedes implementar la lógica para eliminar el item
    cart.splice(index, 1); // Elimina el item del carrito
    updateCart(); // Vuelve a actualizar el carrito
    alert(`Eliminado item: ${cart[index].nombre}`);
}

// Inicializar el carrito al cargar la página
updateCart();

// Simulación de compra (botón)
document.getElementById('checkout-button').addEventListener('click', () => {
    alert('¡Gracias por tu compra!');
});

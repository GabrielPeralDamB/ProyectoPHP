console.log("Ancho de la ventana: " + window.innerWidth);
console.log("Alto de la ventana: " + window.innerHeight);
document.addEventListener("DOMContentLoaded", () => {
    // Array con los datos de los productos
    const products = [
        {
          nombre: "BEZOYA",
          precio: "0,85€",
          descripcion:  "Agua mineral natural, pura y ligera, perfecta para mantenerte hidratado en cualquier momento.",
          url_imagen: "../assets/images/bezoya.jpg",
          marca: "BEZOYA",
          size: "500ml",
          stock: 100,
          descuento: null
        },
        {
          nombre: "LANJARON",
          precio: "1,50€",
          descripcion:  "Agua mineral de alta montaña, rica en minerales, ideal para un estilo de vida saludable.",
          url_imagen: "../assets/images/lanjaron.webp",
          marca: "LANJARON",
          size: "1L",
          stock: 100,
          descuento: null
        },
        {
          nombre: "AGUA FINA",
          precio: "1,75€",
          descripcion: "Agua pura y cristalina, con un sabor suave que refresca y revitaliza.",
          url_imagen: "../assets/images/aguafina.jpg",
          marca: "AGUA FINA",
          size: "1.5L",
          stock: 100,
          descuento: null
        },
        {
          nombre: "AGUA PURA DE MAR",
          precio: "2,10€",
          descripcion:  "Agua del océano purificada, rica en minerales esenciales para un equilibrio perfecto.",
          url_imagen: "../assets/images/aguapuramar.png",
          marca: "AGUA PURA DE MAR",
          size: "500ml",
          stock: 100,
          descuento: null
        },
        {
          nombre: "AGUA SANA",
          precio: "1,95€",
          descripcion:  "Agua mineral saludable, ideal para una hidratación equilibrada y llena de frescura.",
          url_imagen: "../assets/images/aguasana.jpg",
          marca: "AGUA SANA",
          size: "1.5L",
          stock: 100,
          descuento: null
        },
        {
          nombre: "ARQUILLO AGUA MINI",
          precio: "0,70€",
          descripcion:  "La mejor opción en tamaño mini, perfecta para llevar contigo a todas partes.",
          url_imagen: "../assets/images/arquilloaguamini.jpg",
          marca: "ARQUILLO",
          size: "250ml",
          stock: 100,
          descuento: null
        },
        {
          nombre: "BONA FONT MINI",
          precio: "0,95€",
          descripcion: "Agua mineral en formato compacto, ideal para acompañarte en el día a día.",
          url_imagen: "../assets/images/bonafontmini.webp",
          marca: "BONA FONT",
          size: "250ml",
          stock: 100,
          descuento: null
        },
        {
          nombre: "FONT VELLA",
          precio: "1,25€",
          descripcion: "Agua mineral natural de las fuentes más puras, refrescante y saludable.",
          url_imagen: "../assets/images/fontvella.jpg",
          marca: "FONT VELLA",
          size: "500ml",
          stock: 100,
          descuento: null
        },
        {
          nombre: "LA SERRETA",
          precio: "1,10€",
          descripcion: "Agua mineral natural, perfecta para una hidratación diaria equilibrada.",
          url_imagen: "../assets/images/laserreta.jpg",
          marca: "LA SERRETA",
          size: "1L",
          stock: 100,
          descuento: null
        },
        {
          nombre: "MONDARIZ",
          precio: "1,80€",
          descripcion: "Agua mineral de Galicia, con una pureza excepcional y un sabor fresco y natural.",
          url_imagen: "../assets/images/mondariz.jpg",
          marca: "MONDARIZ",
          size: "500ml",
          stock: 100,
          descuento: null
        },
        {
          nombre: "PACK 6 LA SERRETA",
          precio: "5,50€",
          descripcion: "Pack de 6 botellas de agua mineral La Serreta, ideal para toda la familia.",
          url_imagen: "../assets/images/packlaserreta.webp",
          marca: "LA SERRETA",
          size: "6x500ml",
          stock: 100,
          descuento: null
        },
        {
          nombre: "PACK 6 VILAS",
          precio: "4,75€",
          descripcion: "Pack de 6 botellas de agua Vilas, perfecta para mantenerte hidratado durante toda la semana.",
          url_imagen: "../assets/images/packvilas.jpg",
          marca: "VILAS",
          size: "6x500ml",
          stock: 100,
          descuento: null
        },
        {
          nombre: "VITAL",
          precio: "1,20€",
          descripcion: "Agua mineral pura y vital, ideal para acompañarte en cada momento del día.",
          url_imagen: "../assets/images/vital.png",
          marca: "VITAL",
          size: "500ml",
          stock: 100,
          descuento: null
        }
      ];

    // Seleccionar el main donde se añadirán las secciones
    const main = document.querySelector("main");

    // Función para renderizar productos
    function renderProducts(productsToRender) {
        // Limpiar el contenido anterior
        main.innerHTML = '';

        // Crear secciones dinámicamente basadas en los productos
        productsToRender.forEach((product) => {
          // Crear la sección
          const section = document.createElement("section");
          section.classList.add("item");

          // Crear la imagen
          const img = document.createElement("img");
          img.src = product.url_imagen;
          img.alt = product.nombre;

          // Crear el título h2
          const title = document.createElement("h2");
          title.textContent = product.nombre;

          // Crear el párrafo del precio
          const price = document.createElement("p");
          price.classList.add("price");
          price.textContent = product.precio;

          // Crear el párrafo de la descripción
          const description = document.createElement("p");
          description.classList.add("description");
          description.textContent = product.descripcion;

          // Crear el párrafo del tamaño
          const size = document.createElement("p");
          size.classList.add("size");
          size.textContent = `Tamaño: ${product.size}`;
          

          const stock = document.createElement("p");
          stock.classList.add("stock");
          stock.textContent = `Disponibles: ${product.stock}`;

          // Crear el botón
          const button = document.createElement("button");
          button.classList.add("buy-button");
          button.textContent = "Comprar";

          // Añadir los elementos a la sección
         section.appendChild(size);
          section.appendChild(img);
          section.appendChild(title);
          section.appendChild(price);
          section.appendChild(description);
          section.appendChild(stock);
          
          section.appendChild(button);

          // Añadir la sección al main
          main.appendChild(section);
        });
    }

    // Inicializar la página con todos los productos
    renderProducts(products);

    // Función para filtrar productos (puedes añadir este código si deseas buscar por nombre, marca, etc.)
    function filterProducts() {
      const nameInput = document.getElementById("search-name").value.toLowerCase();
      const brandInput = document.getElementById("search-brand").value.toLowerCase();
      const sizeInput = document.getElementById("search-size").value.toLowerCase();
      const minPrice = parseFloat(document.getElementById("min-price").value) || 0;
      const maxPrice = parseFloat(document.getElementById("max-price").value) || Infinity;

      // Filtrar productos basados en los criterios ingresados
      const filteredProducts = products.filter((product) => {
        const matchesName = product.nombre.toLowerCase().includes(nameInput);
        const matchesSize = product.size.toLowerCase().includes(sizeInput);
        const matchesBrand = product.marca.toLowerCase().includes(brandInput);
         // Limpiar el precio eliminando el símbolo de euro y las comas
    const cleanedPrice = parseFloat(product.precio.replace("€", "").replace(",", "."));

    // Comparar el precio con el rango ingresado por el usuario
    const matchesPrice = cleanedPrice >= minPrice && cleanedPrice <= maxPrice;
        return matchesName && matchesBrand && matchesSize && matchesPrice;
      });

      // Volver a renderizar los productos filtrados
      renderProducts(filteredProducts);
    }

    // Vincular la función de filtro al botón de búsqueda
    /*document.getElementById("search-button").addEventListener("click", filterProducts);*/

    // Opcional: también podemos vincular la búsqueda a los inputs para que filtre en tiempo real
    document.getElementById("search-name").addEventListener("input", filterProducts);
    document.getElementById("search-brand").addEventListener("input", filterProducts);
    document.getElementById("search-size").addEventListener("input", filterProducts);
    document.getElementById("min-price").addEventListener("input", filterProducts);
    document.getElementById("max-price").addEventListener("input", filterProducts);

});



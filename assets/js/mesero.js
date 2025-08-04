const mesaSelect = document.querySelector('#mesaSelect');
const categoriaSelect = document.querySelector('#categoriaSelect');
const buscadorProductos = document.querySelector('#buscadorProductos');
const productosContainer = document.querySelector('#productosContainer');

// Función para cargar las mesas disponibles
async function cargarMesas() {
    try {
        const response = await fetch('../../controllers/mesero/cargarSelectMesas.php');
        const data = await response.text();
        mesaSelect.innerHTML = data;
    } catch (error) {
        console.error('Error al cargar las mesas:', error);
    }
}

async function cargarCategorias() {
    try {
        const response = await fetch('../../controllers/mesero/cargarCategorias.php');
        const data = await response.text();
        document.querySelector('#categoriaSelect').innerHTML = data;
    } catch (error) {
        console.error('Error al cargar las categorías:', error);
    }
}

// funcion para buscar productos desde el input buscador
function BuscadorProductos() {
  buscadorProductos.addEventListener("input", function () {
    const filtro = buscadorProductos.value.toLowerCase();
    const productos = productosContainer.querySelectorAll(".card");

    productos.forEach(card => {
      const nombre = card.querySelector("h5").textContent.toLowerCase();
      card.parentElement.style.display = nombre.includes(filtro) ? "" : "none";
    });
  });
}

// funcion para cargar productos al seleccionar una categoria de productos
function CargarProductos() {
  // Validar que se haya seleccionado una mesa antes de cargar productos
  categoriaSelect.addEventListener("change", async function () {
    if (!mesaSelect.value) {
      // Validación de mesa
      Swal.fire({
        icon: 'warning',
        title: 'Seleccione una mesa',
        text: 'Por favor, seleccione una mesa antes de ver los productos.',
      });
      categoriaSelect.value = '';
      return;
    }

    const idcategorias = categoriaSelect.value;
    if (!idcategorias) {
      productosContainer.innerHTML = "";
      return;
    }

    // Mostrar loading
    productosContainer.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Cargando...</span></div></div>';

    try {
      // 🔥 AQUÍ ES DONDE CARGA LOS PRODUCTOS:
      const response = await fetch("../../controllers/cargar_productos.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "idcategorias=" + encodeURIComponent(idcategorias),
      });

      if (!response.ok) {
        throw new Error('Error en la respuesta del servidor');
      }

      const data = await response.json();

      if (data.success) {
        // ✅ AQUÍ SE INSERTAN LAS CARDS EN EL DOM:
        productosContainer.innerHTML = data.html;
        
        // Configurar validaciones de stock y event listeners para los productos
        await EventosProductos();
      } else {
        productosContainer.innerHTML = '<div class="alert alert-info">No hay productos disponibles en esta categoría.</div>';
      }
    } catch (error) {
      console.error('Error al cargar productos:', error);
      productosContainer.innerHTML = '<div class="alert alert-danger">Error al cargar los productos. Intente nuevamente.</div>';
    }
  });
}

// Función para configurar eventos de los productos cargados
async function EventosProductos() {
  const productCards = document.querySelectorAll('#productosContainer .card');
  
  productCards.forEach(card => {
    const btnAgregar = card.querySelector('.btn-agregar-producto');
    if (btnAgregar) {
      btnAgregar.addEventListener('click', async function() {
        const productoId = this.dataset.productId;
        const productoNombre = this.dataset.productName;
        const productoPrecio = this.dataset.productPrice;
        const productoStock = this.dataset.productStock;
        const productoType = this.dataset.productType;
        
        try {
          console.log('Producto seleccionado:', {
            id: productoId,
            nombre: productoNombre,
            precio: productoPrecio,
            stock: productoStock,
            tipo: productoType
          });
          
        } catch (error) {
          console.error('Error al procesar producto:', error);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo procesar el producto. Intente nuevamente.',
          });
        }
      });
    }
  });
}

document.addEventListener('DOMContentLoaded', async () => {
    try {
        // Cargar datos iniciales de forma paralela
        await Promise.all([
            cargarMesas(),
            cargarCategorias()
        ]);
        
        // Configurar funcionalidades después de cargar los datos
        BuscadorProductos();
        CargarProductos();

    } catch (error) {
        console.error('Error en la inicialización:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de inicialización',
            text: 'Hubo un problema al cargar la aplicación. Recargue la página.',
        });
    }
});
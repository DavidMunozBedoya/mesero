<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tienda de Café</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css" />
  <!-- Respaldo: -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <link rel="stylesheet" href="../../assets/css/estiloMesero.css" />
</head>

<body class="bg-coffee">
  <div class="container py-4">
    <header class="text-center mb-5 d-flex justify-content-between align-items-center">
      <div>
        <h1 class="display-4 text-light fw-bold mb-0">
          <i class="fas fa-mug-hot me-2"></i>Tienda de Café
        </h1>
        <h4 class="text-light opacity-75 mb-0">Sistema de Gestión de Pedidos</h4>
      </div>
      <div class="d-flex align-items-center gap-3">
        <i class="fa-solid fa-user-check"></i>
        <h5 class="text-light mb-0" id="usuarioNombre">Usuario</h5>
        <button id="btnCerrarSesion" class="btn btn-danger" title="Cerrar Sesión">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </div>
    </header>

    <div class="row g-4">
      <!-- Panel de Selección -->
      <div class="col-lg-4">
        <div class="card shadow-lg border-0 rounded-4 bg-light">
          <div class="card-body p-4">
            <!-- Selección de Mesa -->
            <div class="mb-4">
              <h5 class="card-title mb-3">
                <i class="fas fa-chair me-2"></i>Mesa Actual
              </h5>
              <select id="mesaSelect" class="form-select form-select-lg rounded-3">
                <!-- carga dinamica de las mesas -->
              </select>
              <button id="btnGenerarToken" class="btn btn-warning mt-2 w-100">
                <i class="fas fa-key me-2"></i>Generar Token para la Mesa
              </button>
            </div>
            <!-- Categorías -->
            <div class="mb-4">
              <h5 class="card-title mb-3">
                <i class="fas fa-tags me-2"></i>Categoría
              </h5>
              <select id="categoriaSelect" class="form-select form-select-lg rounded-3">
                <!-- carga dinamica de las categorias -->
              </select>
            </div>
          </div>
        </div>
        <!-- Tarjeta de mesas con token activo -->
        <div class="card shadow-lg border-0 rounded-4 bg-light mt-4" id="mesasTokenContainer">
          <div class="card-body p-4">
            <h5 class="card-title mb-3 text-danger">
              <i class="fas fa-key me-2"></i>Mesas con Token Activo
            </h5>
            <ul class="list-group" id="mesasTokenLista">
              <!-- Se cargarán dinámicamente -->
            </ul>
          </div>
        </div>
      </div>

      <!-- Panel de Productos -->
      <div class="col-lg-8">
        <div class="card shadow-lg border-0 rounded-4 bg-light">
          <div class="card-body p-4">
            <h5 class="card-title mb-4">
              <i class="fas fa-coffee me-2"></i>Productos Disponibles
            </h5>
            <div class="mb-3">
              <input type="text" id="buscadorProductos" class="form-control" placeholder="Buscar producto...">
            </div>
            <div class="row g-3" id="productosContainer">
              <!-- Los productos se cargarán dinámicamente -->
            </div>
          </div>
        </div>

        <!-- Pedido Actual -->
        <div class="card shadow-lg border-0 rounded-4 bg-light mt-4">
          <div class="card-body p-4">
            <h5 class="card-title mb-4">
              <i class="fas fa-shopping-cart me-2"></i>Pedido Actual
            </h5>
            <ul class="list-group mb-3" id="pedidoLista">
              <!-- Los items del pedido se cargarán dinámicamente -->
            </ul>
            <button id="btnConfirmarPedido" class="btn btn-success w-100">
              <i class="fas fa-check me-2"></i>Confirmar Pedido
            </button>
            <button id="btnCancelarPedido" class="btn btn-danger w-100 mt-2 d-none">
              <i class="fas fa-times me-2"></i>Cancelar Pedido
            </button>
          </div>
        </div>

        <!-- Pedidos Activos de la Mesa -->
        <div class="card shadow-lg border-0 rounded-4 bg-light mt-4">
          <div class="card-body p-4">
            <h5 class="card-title mb-4">
              <i class="fas fa-list me-2"></i>Pedidos Activos de la Mesa
            </h5>
            <div id="pedidosActivosMesa"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Observación -->
  <div class="modal fade" id="observacionModal" tabindex="-1" aria-labelledby="observacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="observacionModalLabel">Agregar Observaciones</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Producto:</label>
            <p id="productoNombreSeleccionado" class="form-control-static"></p>
          </div>
          <div class="mb-3">
            <label class="form-label">Cantidad:</label>
            <p id="productoCantidadSeleccionada" class="form-control-static"></p>
          </div>
          <div class="mb-3">
            <label class="form-label">Precio:</label>
            <p id="productoPrecioSeleccionado" class="form-control-static"></p>
          </div>
          <div class="mb-3">
            <label for="comentarioInput" class="form-label">Observaciones:</label>
            <textarea class="form-control" id="comentarioInput" rows="3" placeholder="Ingrese observaciones del producto..."></textarea>
          </div>
          <input type="hidden" id="productoSeleccionado">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" id="btnAgregarAlPedido" class="btn btn-primary">Agregar al Pedido</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/mesero.js"></script>
</body>

</html>
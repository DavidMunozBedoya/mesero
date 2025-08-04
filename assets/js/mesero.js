const mesaSelect = document.querySelector('#mesaSelect');
const categoriaSelect = document.querySelector('#categoriaSelect');

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

document.addEventListener('DOMContentLoaded', () => {
    cargarMesas();
    cargarCategorias();
});
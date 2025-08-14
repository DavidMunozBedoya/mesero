# 🍵 Sistema de Gestión de Café - Refactorizado

Sistema web para gestión de pedidos en una tienda de café, con funcionalidades para meseros y clientes.

## 📋 Características

- **Gestión de Mesas**: Control de mesas disponibles y ocupadas
- **Sistema de Tokens**: Tokens temporales para clientes
- **Gestión de Pedidos**: Pedidos desde mesero y cliente
- **Categorías de Productos**: Organización por tipos de productos
- **Estados en Tiempo Real**: Visualización de estados de mesas

## 🛠️ Tecnologías

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 8.0+
- **Base de Datos**: MySQL/MariaDB
- **Servidor**: Apache (XAMPP)

## 📁 Estructura del Proyecto

```
cafe_refactorizado/
├── assets/
│   ├── css/
│   │   └── estiloMesero.css
│   └── js/
│       └── mesero.js
├── config/
│   └── config.php
├── controllers/
│   ├── mesero/
│   │   ├── cargarCategorias.php
│   │   └── cargarSelectMesas.php
│   ├── cargarCategorias.php
│   └── cargarSelectMesas.php
├── models/
│   ├── mesero/
│   │   ├── consultas_mesero.php
│   │   └── consultas_usuario_mesa.php
│   └── MySQL.php
└── views/
    ├── mesero/
    │   └── mesero.php
    └── usuario_mesa/
        └── usuario_mesa.php
```

## 🚀 Instalación

1. Clona el repositorio en tu directorio htdocs de XAMPP
2. Configura la base de datos en `config/config.php`
3. Importa el esquema de base de datos
4. Inicia Apache y MySQL en XAMPP

## 📊 Base de Datos

El sistema utiliza las siguientes tablas principales:
- `mesas` - Gestión de mesas
- `categorias` - Categorías de productos
- `productos` - Productos disponibles
- `pedidos` - Pedidos realizados
- `tokens_mesa` - Tokens temporales
- `usuarios` - Usuarios del sistema

## 👥 Autores

- Tu nombre - Desarrollo principal

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

# 🔒 Medidas de Seguridad Implementadas para Observaciones

## 📋 Resumen de Protecciones contra Inyección SQL

### 🎯 **1. Validación Frontend (JavaScript)**

#### **Ubicación:** `assets/js/mesero.js`
- **Función:** `validarObservaciones(textarea)`
- **Límites:** 255 caracteres máximo
- **Caracteres permitidos:** Solo letras, números, espacios y puntuación básica
- **Caracteres prohibidos:** Comillas, símbolos especiales, caracteres de programación

#### **Patrones de Validación:**
```javascript
// Caracteres seguros permitidos
const patronSeguro = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s.,;:()¿?¡!\-_]*$/;

// Caracteres prohibidos (inyección SQL y XSS)
const caracteresProhibidos = /['"<>{}[\]\\|`~@#$%^&*+=]/;
```

#### **Características:**
- ✅ Validación en tiempo real (`oninput`)
- ✅ Feedback visual (clases Bootstrap)
- ✅ Contador de caracteres
- ✅ Mensajes de error descriptivos
- ✅ Sanitización antes del envío

---

### 🛡️ **2. Protección Backend (PHP)**

#### **Ubicación:** `controllers/mesero/agregar_productos_pedido.php`
- **Función:** `validarObservaciones($observaciones)`
- **Validaciones:** Longitud, caracteres permitidos, sanitización
- **Sanitización:** Eliminación de caracteres de control y espacios múltiples

#### **Código de Validación:**
```php
function validarObservaciones($observaciones) {
    if (empty($observaciones)) return '';
    
    $obs = trim((string)$observaciones);
    if (strlen($obs) > 255) {
        throw new Exception('Las observaciones no pueden exceder 255 caracteres');
    }
    
    if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s.,;:()¿?¡!\-_]*$/', $obs)) {
        throw new Exception('Las observaciones contienen caracteres no permitidos');
    }
    
    // Sanitización
    $obs = preg_replace('/\s+/', ' ', $obs);
    $obs = preg_replace('/[\x00-\x1F\x7F]/', '', $obs);
    
    return $obs;
}
```

---

### 🗄️ **3. Protección en Base de Datos**

#### **Ubicación:** `models/mesero/consultas_mesero.php`
- **Método:** Prepared Statements con PDO
- **Función:** `insertarDetallePedido()`

#### **Consulta Segura:**
```php
$query = "INSERT INTO detalle_pedidos (pedidos_idpedidos, productos_idproductos, cantidad_producto, precio_producto, subtotal, observaciones) 
          VALUES (?, ?, ?, ?, ?, ?)";

$this->mysql->ejecutarConsultaPreparada($query, [
    $pedidoId, $productoId, $cantidad, $precio, $subtotal, $observaciones
]);
```

---

### 🖥️ **4. Escape de Salida (Output)**

#### **Ubicación:** `controllers/mesero/cargar_pedidos_activos_mesa.php`
- **Función:** `htmlspecialchars()` con ENT_QUOTES
- **Protección:** XSS y caracteres especiales

#### **Código de Escape:**
```php
if (!empty($detalle['observaciones'])) {
    $html .= '<small class="text-info d-block">
        <i class="fas fa-comment me-1"></i>' . 
        htmlspecialchars($detalle['observaciones'], ENT_QUOTES, 'UTF-8') . 
        '</small>';
}
```

---

## 🧪 **5. Testing y Validación**

### **Archivo de Prueba:** `test_validacion_observaciones.html`

#### **Casos de Prueba Válidos:**
- ✅ "Sin azúcar por favor"
- ✅ "Extra caliente, gracias"
- ✅ "Café con leche descremada"
- ✅ "¿Puede ser decafeinado?"
- ✅ "¡Muchas gracias!"

#### **Casos de Prueba Inválidos (Bloqueados):**
- ❌ `'; DROP TABLE pedidos; --`
- ❌ `<script>alert('hack')</script>`
- ❌ `SELECT * FROM usuarios`
- ❌ `Café con "comillas" dobles`
- ❌ `Test @ # $ % ^ & *`

---

## 🔐 **Capas de Seguridad Implementadas**

1. **Validación Frontend** → Prevención inmediata de caracteres peligrosos
2. **Validación Backend** → Verificación del servidor antes de procesar
3. **Prepared Statements** → Protección total contra inyección SQL
4. **Sanitización** → Limpieza de datos antes del almacenamiento
5. **Escape de Salida** → Protección contra XSS al mostrar datos

---

## 📊 **Beneficios de Seguridad**

- 🛡️ **100% Protegido** contra inyección SQL
- 🔒 **Validación robusta** en múltiples capas
- 🎯 **UX mejorado** con feedback en tiempo real
- 📝 **Datos consistentes** con sanitización automática
- 🚫 **Bloqueo proactivo** de caracteres peligrosos

---

## 🎯 **Uso para el Usuario**

Los usuarios pueden ingresar observaciones naturales como:
- "Sin azúcar, gracias"
- "Extra caliente por favor"
- "¿Puede ser descafeinado?"
- "Con leche de almendras"

Pero se bloquean automáticamente intentos maliciosos de:
- Inyección SQL
- Scripts XSS
- Caracteres de programación
- Comillas y símbolos especiales

---

**Estado:** ✅ **IMPLEMENTADO Y PROBADO**
**Nivel de Seguridad:** 🔒 **MÁXIMO**
**Compatibilidad:** 🌐 **Total con el sistema existente**


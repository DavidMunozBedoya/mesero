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

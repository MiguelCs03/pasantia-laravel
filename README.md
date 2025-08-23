# Sistema de Gestión - Laravel + Vue.js

Sistema de gestión de clientes y órdenes desarrollado con Laravel 9 y Vue.js 2.

## Requisitos

- PHP 8.0 o superior
- Composer
- Node.js 16 o superior
- MySQL 5.7 o superior

## Instalación

### 1. Clonar el repositorio
```bash
git clone <url-del-repositorio>
cd pasantía
```

### 2. Instalar dependencias de PHP
```bash
composer install
```

### 3. Instalar dependencias de Node.js
```bash
npm install
```

### 4. Configurar el archivo de entorno
```bash
cp .env.example .env
```

Editar el archivo `.env` con la configuración de tu base de datos:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=intecruz
DB_USERNAME=intecruz_user
DB_PASSWORD=tu_password
```

### 5. Generar la clave de la aplicación
```bash
php artisan key:generate
```

### 6. Ejecutar las migraciones
```bash
php artisan migrate
```

### 7. Compilar los assets
```bash
npm run dev
```

## Ejecutar el proyecto

### Servidor de desarrollo
```bash
php artisan serve
```

### Compilar assets en modo desarrollo (con watch)
```bash
npm run watch
```

### Compilar assets para producción
```bash
npm run prod
```

## Acceso

Una vez ejecutado, el proyecto estará disponible en:
- **URL:** http://127.0.0.1:8000
- **Módulos disponibles:**
  - Gestión de Clientes
  - Gestión de Órdenes (Maestro-Detalle)

## Funcionalidades

### Gestión de Clientes
- ✅ Crear, editar, ver y eliminar clientes
- ✅ Validación de teléfono (8 dígitos exactos)
- ✅ Búsqueda por nombre, apellido o email
- ✅ Paginación (10 elementos por página)

### Gestión de Órdenes
- ✅ Crear órdenes con múltiples productos
- ✅ Relación maestro-detalle
- ✅ Cálculo automático de totales
- ✅ Estados: pendiente, completado, cancelado
- ✅ Editar y eliminar órdenes

## Estructura del Proyecto

```
├── app/
│   ├── Http/Controllers/
│   │   ├── ClienteController.php
│   │   └── OrdenController.php
│   └── Models/
│       ├── Cliente.php
│       ├── Orden.php
│       └── OrdenDetalle.php
├── resources/js/src/views/
│   ├── clientes/
│   └── ordenes/
└── routes/
    └── api.php
```

## Tecnologías utilizadas

- **Backend:** Laravel 9, PHP 8+
- **Frontend:** Vue.js 2, Bootstrap Vue
- **Base de datos:** MySQL
- **Herramientas:** Laravel Mix, Axios

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

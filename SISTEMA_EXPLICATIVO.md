# Sistema de Sorteos - Gana Con Kelvin 🍀

Sistema profesional de gestión y venta de tickets para sorteos, desarrollado con **Laravel**, **TailwindCSS** y **Gmail SMTP**.

---

## 🚀 Funcionalidades Principales

### 1. Interfaz de Usuario (Frontend)
- **Diseño Premium**: Interfaz moderna, responsiva y oscura, optimizada para ventas.
- **Barra de Progreso Dinámica**: Muestra el porcentaje real de tickets vendidos en base a la configuración del sorteo.
- **Visualización de Premios**: Secciones elegantes para mostrar el "Premio Mayor", "Premios Invertidos" y "Premios Anticipados".
- **Búsqueda de Tickets**: Los usuarios pueden consultar sus números comprados ingresando su correo electrónico.

### 2. Sistema de Compra y Carrito
- **Paquetes de Tickets**: Opción de elegir paquetes preconfigurados (ej: 50, 100, 200 tickets) con precios especiales.
- **Tickets Individuales**: Permite comprar cualquier cantidad de tickets a un precio base.
- **Etiquetas "EXTRA"**: Los paquetes especiales pueden ser destacados visualmente.
- **Cálculo en Tiempo Real**: El total a pagar se actualiza instantáneamente al cambiar la cantidad o elegir un paquete.

### 3. Generación de Tickets y Lotería
- **Números Aleatorios Únicos**: Generación automática de números de 5 dígitos (ej: `05423`).
- **Lógica de Premios Anticipados**: 
    - El sistema asigna números específicos configurados como "anticipados" de forma proporcional y aleatoria durante la compra.
    - **Aviso de Ganador**: Si un usuario compra un número premiado, el sistema muestra una alerta animada inmediata: *"¡TIENES UN NÚMERO PREMIADO!"*.

### 4. Panel de Administración (`/admin`)
- **Gestión de Sorteos**: Crear, editar, activar/desactivar y eliminar sorteos.
- **Configuración Avanzada**:
    - **Meta de Tickets**: Establecer el total de números disponibles por sorteo.
    - **Editor de Premios**: Añadir títulos y descripciones de premios dinámicamente.
    - **Gestor de Paquetes**: Configurar promociones de tickets por precio.
    - **Control de Anticipados**: Definir qué números exactos tienen premios instantáneos.
- **Seguridad**: Acceso protegido por Login (Usuario y Contraseña).

### 5. Notificaciones y Correo
- **Gmail SMTP**: Envío automático de correos tras cada venta exitosa.
- **Plantilla de Email**: Formato HTML elegante con el detalle del sorteo, monto pagado y los números asignados al cliente.

---

## 🛠️ Detalles Técnicos

- **Framework**: Laravel 12.x
- **Estilos**: TailwindCSS v4.0 (Aesthetics Modernos)
- **Base de Datos**: SQLite (por defecto, configurable a MySQL/PostgreSQL)
- **Autenticación**: Laravel Auth (Session based)

---

## 🔑 Credenciales por Defecto (Admin)

- **URL**: `/login` o botón "Panel Admin" en el footer.
- **Usuario**: `admin@ganaconkelvin.com`
- **Password**: `password123`

---

## 📦 Instalación Rápida

1. Clonar/Copiar el proyecto.
2. Ejecutar `composer install`.
3. Configurar `.env` con tus datos de Gmail (`MAIL_USERNAME` y `MAIL_PASSWORD`).
4. Ejecutar migraciones: `php artisan migrate --seed`.
5. Ejecutar servidor: `php artisan serve`.

---

© 2026 Gana Con Kelvin - Desarrollado para éxito comercial.

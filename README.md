# Filá Mariscales - Sistema de Gestión de Eventos

Sistema web optimizado para la gestión de eventos de la Filá Mariscales de Caballeros Templarios de Elche.

## 🎨 Características del Diseño

- **Tema Templario**: Colores basados en la bandera templaria (rojo y blanco)
- **Tipografía Medieval**: Fuentes Cinzel y Crimson Text para un aspecto histórico
- **Diseño Responsivo**: Adaptado a todos los dispositivos
- **Interfaz Moderna**: Bootstrap 5 con animaciones suaves
- **Navegación Intuitiva**: Menú completo con iconos descriptivos

## 🚀 Características del Sistema

- **Gestión de Usuarios**: Registro, autenticación y perfiles de usuarios
- **Panel de Administración**: Gestión completa de eventos, usuarios y contenido
- **Sistema de Eventos**: Creación, edición y gestión de eventos
- **Galería de Imágenes**: Subida y gestión de imágenes
- **Sistema de Rutas**: Router personalizado con soporte para middleware
- **Arquitectura MVC**: Código organizado y mantenible

## 🎯 Colores Templarios Implementados

### Paleta Principal
- **Rojo Templario**: `#DC143C` (Crimson)
- **Rojo Oscuro**: `#8B0000` (Dark Red)
- **Rojo Claro**: `#FF4444`
- **Blanco Puro**: `#FFFFFF`
- **Blanco Off**: `#F8F9FA`
- **Oro Templario**: `#FFD700` (accent)

### Uso en la Web
- **Fondo principal**: Blanco con patrones sutiles
- **Navbar**: Gradiente rojo templario
- **Botones**: Rojo templario con hover dorado
- **Texto**: Negro sobre fondo blanco para legibilidad
- **Acentos**: Dorado para elementos destacados

## 📋 Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache/Nginx con mod_rewrite habilitado
- Composer (opcional)

## 🛠️ Instalación

1. **Clonar el repositorio**
   ```bash
   git clone [url-del-repositorio]
   cd prueba-php
   ```

2. **Configurar la base de datos**
   - Crear una base de datos MySQL llamada `mariscales_db`
   - Importar el archivo `database/schema.sql`

3. **Configurar el servidor web**
   - Apuntar el DocumentRoot a la carpeta `public/`
   - Asegurar que mod_rewrite esté habilitado

4. **Verificar configuración**
   - Editar `src/config/config.php` si es necesario
   - Ajustar URL_ROOT según tu configuración

## 📁 Estructura del Proyecto

```
prueba-php/
├── public/                 # Punto de entrada público
│   ├── assets/            # CSS, JS e imágenes
│   │   ├── css/
│   │   │   ├── style.css  # Estilos principales templarios
│   │   │   └── admin.css  # Estilos del panel admin
│   │   └── js/
│   │       └── main.js    # JavaScript principal
│   ├── .htaccess          # Configuración Apache
│   └── index.php          # Front controller
├── src/                   # Código fuente
│   ├── config/           # Configuraciones
│   ├── controllers/      # Controladores
│   ├── models/          # Modelos
│   ├── views/           # Vistas
│   ├── helpers/         # Funciones auxiliares
│   └── core/            # Núcleo del sistema
├── routes/              # Definición de rutas
├── database/            # Esquemas de base de datos
└── vendor/              # Dependencias de Composer
```

## 🌐 Uso

### Acceso al Sistema

- **URL Principal**: `http://localhost/prueba-php/public`
- **Panel de Admin**: `http://localhost/prueba-php/public/admin`
- **Credenciales Admin**: `admin@mariscales.com` / `admin123`

### Páginas Principales

1. **Inicio** - Página principal con carrusel y información
2. **Historia** - Historia de la Filá Mariscales
3. **Directiva** - Miembros de la junta directiva
4. **Noticias** - Últimas noticias y actualizaciones
5. **Blog** - Artículos y publicaciones
6. **Calendario** - Eventos y actividades
7. **Galería** - Imágenes de eventos
8. **Música** - Himno y piezas musicales
9. **Libro** - Historia y anécdotas
10. **Descargas** - Documentos y archivos
11. **Tienda** - Artículos oficiales
12. **Patrocinadores** - Colaboradores
13. **Hermanamientos** - Relaciones con otras filás
14. **Socios** - Zona privada de miembros

## 🔧 Optimizaciones Realizadas

### Archivos Eliminados
- ✅ Archivos de prueba temporales
- ✅ Archivos CSS duplicados (medieval.css, animations.css)
- ✅ Estilos inline redundantes
- ✅ Código JavaScript innecesario

### Archivos Optimizados
- ✅ `public/assets/css/style.css` - Colores templarios implementados
- ✅ `src/views/layouts/main.php` - Layout simplificado y limpio
- ✅ `routes/web.php` - Rutas corregidas y optimizadas
- ✅ `public/index.php` - Sistema de rutas implementado
- ✅ `src/config/config.php` - Configuración mejorada

### Mejoras de Rendimiento
- ✅ CSS optimizado con variables CSS
- ✅ JavaScript simplificado y eficiente
- ✅ Configuración de caché mejorada
- ✅ Compresión GZIP habilitada
- ✅ Rutas optimizadas

## 🎨 Diseño y UX

### Tipografía
- **Títulos**: Cinzel (elegante y medieval)
- **Texto**: Crimson Text (legible y clásica)
- **Iconos**: Bootstrap Icons (consistentes)

### Responsive Design
- **Desktop**: Navegación completa con todos los enlaces
- **Tablet**: Menú adaptado con iconos
- **Mobile**: Menú hamburguesa optimizado

### Animaciones
- **AOS Library**: Animaciones de entrada suaves
- **Hover Effects**: Transiciones elegantes
- **Scroll Effects**: Navbar con efecto de scroll

## 🚀 Desarrollo

### Rutas Principales

```php
// Páginas públicas
GET /                    -> Pages@index
GET /historia           -> Pages@historia
GET /libro              -> Pages@libro
GET /galeria            -> Pages@galeria

// Autenticación
GET /login              -> Pages@login
GET /registro           -> Pages@registro

// Admin
GET /admin              -> Admin\AdminController@dashboard
GET /admin/events       -> Admin\EventController@index
GET /admin/users        -> Admin\UserController@index
```

### Tecnologías Utilizadas

- **Backend**: PHP 7.4+, MySQL
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Arquitectura**: MVC (Model-View-Controller)
- **Router**: Sistema de rutas personalizado
- **Autoloading**: PSR-4 con Composer

## 📝 Contribución

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 🆘 Soporte

Para soporte técnico o consultas, contactar con el equipo de desarrollo de la Filá Mariscales.

---

**🎯 Sistema optimizado y listo para producción con tema templario completo!**

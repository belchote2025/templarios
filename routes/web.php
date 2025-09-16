<?php
use App\Controllers\AuthController;
use App\Controllers\Pages;
use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\EventController;
use App\Controllers\Admin\UserController;
use App\Controllers\SupportController;

// Create a new Router instance
$router = new Router();

// Public routes
$router->get('', 'Pages@index');

// Support routes
$router->group('soporte', function($router) {
    $router->get('', 'SupportController@index');
    $router->get('buscar', 'SupportController@searchFaqs');
    
    // Chat API
    $router->group('chat', function($router) {
        $router->get('', 'SupportController@getChatConversation');
        $router->post('enviar', 'SupportController@sendChatMessage');
    });
});

$router->get('historia', 'Pages@historia');
$router->get('directiva', 'Pages@directiva');
$router->get('noticias', 'Pages@noticias');
$router->get('blog', 'Pages@blog');
$router->get('calendario', 'Pages@calendario');
$router->get('galeria', 'Pages@galeria');
$router->get('musica', 'Pages@musica');
$router->get('libro', 'Pages@libro');
$router->get('descargas', 'Pages@descargas');
$router->get('tienda', 'Pages@tienda');
$router->get('patrocinadores', 'Pages@patrocinadores');
$router->get('hermanamientos', 'Pages@hermanamientos');
$router->get('socios', 'Pages@socios');
$router->get('login', 'Pages@login');
$router->post('login', 'Pages@login');
$router->get('logout', 'Pages@logout');
$router->post('logout', 'Pages@logout');
$router->get('dashboard', 'UserController@dashboard');
$router->get('profile', 'Pages@profile');
$router->post('profile/update', 'UserController@updateProfile');
$router->post('profile/change-password', 'UserController@changePassword');
$router->get('registro', 'Pages@registro');
$router->post('registro', 'Pages@registro');
$router->get('contacto', 'Pages@contacto');
$router->get('interactiva', 'Pages@interactiva');

// Auth routes
$router->group('auth', function($router) {
    $router->get('login', 'AuthController@loginForm');
    $router->post('login', 'AuthController@login');
    $router->get('register', 'AuthController@registerForm');
    $router->post('register', 'AuthController@register');
    $router->get('forgot-password', 'AuthController@forgotPasswordForm');
    $router->post('forgot-password', 'AuthController@forgotPassword');
    $router->get('reset-password/{token}', 'AuthController@resetPasswordForm');
    $router->post('reset-password', 'AuthController@resetPassword');
});

// Authenticated user routes
$router->group('', function($router) {
    $router->get('zona-privada', 'Pages@zonaPrivada');
    $router->post('events/{id}/register', 'EventController@register');
    $router->post('events/{id}/cancel', 'EventController@cancelRegistration');
});

// Admin routes
$router->group('admin', function($router) {
    $router->get('', 'Admin\AdminController@dashboard');
    
    // User management
    $router->group('users', function($router) {
        $router->get('', 'Admin\UserController@index');
        $router->get('create', 'Admin\UserController@create');
        $router->post('store', 'Admin\UserController@store');
        $router->get('{id}/edit', 'Admin\UserController@edit');
        $router->post('{id}/update', 'Admin\UserController@update');
        $router->post('{id}/delete', 'Admin\UserController@delete');
        $router->post('{id}/toggle-status', 'Admin\UserController@toggleStatus');
    });
    
    // Admin user management (AdminController methods)
    $router->get('crearUsuario', 'Admin\AdminController@crearUsuario');
    $router->post('crearUsuario', 'Admin\AdminController@crearUsuario');
    $router->get('usuarios', 'Admin\AdminController@usuarios');
    $router->get('editarUsuario/{id}', 'Admin\AdminController@editarUsuarioForm');
    $router->post('editarUsuario/{id}', 'Admin\AdminController@editarUsuario');
    $router->post('desactivarUsuario/{id}', 'Admin\AdminController@desactivarUsuario');
    $router->post('activarUsuario/{id}', 'Admin\AdminController@activarUsuario');
    $router->post('toggleUserStatus/{id}', 'Admin\AdminController@toggleUserStatus');
    $router->post('resetearPassword/{id}', 'Admin\AdminController@resetearPassword');
    $router->post('clearTempPassword/{id}', 'Admin\AdminController@clearTempPassword');
    $router->get('export/dashboard', 'Admin\AdminController@exportDashboard');
    $router->post('eliminarUsuario/{id}', 'Admin\AdminController@eliminarUsuario');
    
    // News management - orden específico para evitar conflictos
    $router->get('nueva-noticia', 'Admin\AdminController@nuevaNoticia');
    $router->post('nueva-noticia', 'Admin\AdminController@nuevaNoticia');
    $router->get('buscar-noticias', 'Admin\AdminController@buscarNoticias');
    $router->get('editar-noticia/{id}', 'Admin\AdminController@editarNoticia');
    $router->post('editar-noticia/{id}', 'Admin\AdminController@editarNoticia');
    $router->get('ver-noticia/{id}', 'Admin\AdminController@verNoticia');
    $router->get('eliminar-noticia/{id}', 'Admin\AdminController@eliminarNoticia');
    $router->get('cambiar-estado-noticia/{id}/{estado}', 'Admin\AdminController@cambiarEstadoNoticia');
    $router->get('noticias/{page}', 'Admin\AdminController@noticias');
    $router->get('noticias', 'Admin\AdminController@noticias');
    
    // Messages management
    $router->get('mensajes', 'Admin\AdminController@mensajes');
    
    // Event management
    $router->group('events', function($router) {
        $router->get('', 'Admin\EventController@index');
        $router->get('create', 'Admin\EventController@create');
        $router->post('store', 'Admin\EventController@store');
        $router->get('{id}/edit', 'Admin\EventController@edit');
        $router->post('{id}/update', 'Admin\EventController@update');
        $router->post('{id}/delete', 'Admin\EventController@delete');
        $router->get('{id}/registrations', 'Admin\EventController@registrations');
        $router->post('{id}/registrations/export', 'Admin\EventController@exportRegistrations');
    });
    
    // Alias para eventos (compatibilidad con enlaces en español)
    $router->get('eventos', 'Admin\EventController@index');
    
    // Gallery management
    $router->get('galeria', 'Admin\AdminController@galeria');
    $router->post('subirMedia', 'Admin\AdminController@subirMedia');
    $router->get('eliminarMedia/{fileName}', 'Admin\AdminController@eliminarMedia');
    $router->post('subirCarousel', 'Admin\AdminController@subirCarousel');
    $router->get('eliminarCarousel/{fileName}', 'Admin\AdminController@eliminarCarousel');
    $router->post('actualizarDescripcionGaleria', 'Admin\AdminController@actualizarDescripcionGaleria');
    $router->post('actualizarDescripcionCarousel', 'Admin\AdminController@actualizarDescripcionCarousel');
    
    // Store management
    $router->get('productos', 'Admin\AdminController@productos');
    $router->get('nuevo-producto', 'Admin\AdminController@nuevoProducto');
    $router->post('nuevo-producto', 'Admin\AdminController@nuevoProducto');
    $router->get('editar-producto/{id}', 'Admin\AdminController@editarProducto');
    $router->post('editar-producto/{id}', 'Admin\AdminController@editarProducto');
    $router->post('eliminar-producto/{id}', 'Admin\AdminController@eliminarProducto');
    
    // Settings
    $router->group('settings', function($router) {
        $router->get('', 'Admin\SettingsController@index');
        $router->post('update', 'Admin\SettingsController@update');
    });
});

// Return the router
return $router;

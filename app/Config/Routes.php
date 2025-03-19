<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');

// Rutas de Autenticación
$routes->get('login', 'Auth::login');
$routes->post('auth/autenticar', 'Auth::autenticar');
$routes->get('registro', 'Auth::registro');
$routes->post('auth/registrar', 'Auth::registrar');
$routes->get('recuperar-password', 'Auth::recuperarPassword');
$routes->post('auth/procesarRecuperacion', 'Auth::procesarRecuperacion');
$routes->get('auth/logout', 'Auth::logout');

// Rutas del Dashboard
$routes->get('dashboard', 'Dashboard::index');

// Rutas de Usuarios
$routes->get('usuarios', 'Usuario::index');
$routes->get('usuarios/nuevo', 'Usuario::nuevo');
$routes->post('usuario/crear', 'Usuario::crear');
$routes->get('usuarios/editar/(:num)', 'Usuario::editar/$1');
$routes->post('usuario/actualizar', 'Usuario::actualizar');
$routes->get('usuarios/eliminar/(:num)', 'Usuario::eliminar/$1');

// Rutas de Perfil
$routes->get('perfil', 'Usuario::perfil');
$routes->post('usuario/guardarPerfil', 'Usuario::guardarPerfil');

// Rutas de Roles
$routes->get('roles', 'Rol::index');
$routes->get('roles/nuevo', 'Rol::nuevo');
$routes->post('rol/crear', 'Rol::crear');
$routes->get('roles/editar/(:num)', 'Rol::editar/$1');
$routes->post('rol/actualizar', 'Rol::actualizar');
$routes->get('roles/eliminar/(:num)', 'Rol::eliminar/$1');
$routes->get('roles/ver/(:num)', 'Rol::ver/$1');

// Rutas de Permisos
$routes->get('permisos', 'Permiso::index');
$routes->get('permisos/nuevo', 'Permiso::nuevo');
$routes->post('permiso/crear', 'Permiso::crear');
$routes->get('permisos/editar/(:num)', 'Permiso::editar/$1');
$routes->post('permiso/actualizar', 'Permiso::actualizar');
$routes->get('permisos/eliminar/(:num)', 'Permiso::eliminar/$1');
$routes->get('permisos/ver/(:num)', 'Permiso::ver/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/* usuarios */
$routes->post('autenticar', 'Usuario::autenticar', ['filter' => 'cors']);
$routes->post('update_usuario_pass', 'Usuario::update_usuario_pass', ['filter' => 'cors']);
$routes->post('update_passwords', 'Usuario::update_passwords', ['filter' => 'cors']);
$routes->post('get_usuario', 'Usuario::get_usuario', ['filter' => 'cors']);
$routes->post('get_ingeniero', 'Usuario::get_ingeniero', ['filter' => 'cors']);
$routes->post('insertar_usuario', 'Usuario::insertar_usuario', ['filter' => 'cors']);
$routes->get('listar_usuarios', 'Usuario::listar_usuarios', ['filter' => 'cors']);
$routes->get('listar_ingenieros', 'Usuario::listar_ingenieros', ['filter' => 'cors']);
$routes->post('insertar_ingeniero', 'Usuario::insertar_ingeniero', ['filter' => 'cors']);
$routes->get('listar_ingenieros_usuario', 'Usuario::listar_ingenieros_usuario', ['filter' => 'cors']);
$routes->get('listar_lista_estudios', 'Usuario::listar_lista_estudios', ['filter' => 'cors']);
$routes->post('insertar_tipo_estudio', 'Usuario::insertar_tipo_estudio', ['filter' => 'cors']);
$routes->post('update_usuario', 'Usuario::update_usuario', ['filter' => 'cors']);
$routes->post('update_ingeniero', 'Usuario::update_ingeniero', ['filter' => 'cors']);
$routes->post('update_tipo_estudio', 'Usuario::update_tipo_estudio', ['filter' => 'cors']);
$routes->post('insertar_estudios_ingeniero', 'Usuario::insertar_estudios_ingeniero', ['filter' => 'cors']);
$routes->post('update_estudios_ingeniero', 'Usuario::update_estudios_ingeniero', ['filter' => 'cors']);
$routes->post('listar_estudios_ingenieros_usuario', 'Usuario::listar_estudios_ingenieros_usuario', ['filter' => 'cors']);
$routes->post('listar_parafiscales_ingeniero', 'Usuario::listar_parafiscales_ingeniero', ['filter' => 'cors']);
$routes->get('listar_tipo_estudio', 'Usuario::listar_tipo_estudio', ['filter' => 'cors']);
$routes->get('listar_perfiles', 'Usuario::listar_perfiles', ['filter' => 'cors']);
$routes->post('get_estuduio_ingeniero', 'Usuario::get_estuduio_ingeniero', ['filter' => 'cors']);
$routes->post('insertar_parafiscales_ingeniero', 'Usuario::insertar_parafiscales_ingeniero', ['filter' => 'cors']);
$routes->post('update_parafiscales_ingeniero', 'Usuario::update_parafiscales_ingeniero', ['filter' => 'cors']);
$routes->post('get_parafiscal_ingeniero', 'Usuario::get_parafiscal_ingeniero', ['filter' => 'cors']);
$routes->post('get_tipo_estudio', 'Usuario::get_tipo_estudio', ['filter' => 'cors']);
$routes->post('archivo_subir', 'Usuario::archivo_subir', ['filter' => 'cors']);
$routes->get('archivo_ingeniero', 'Usuario::archivo_ingeniero', ['filter' => 'cors']);
$routes->get('archivo_ingeniero_parafiscales', 'Usuario::archivo_ingeniero_parafiscales', ['filter' => 'cors']);
$routes->post('ingeniero_usuario', 'Usuario::ingeniero_usuario', ['filter' => 'cors']);
/* usuarios */
/* ----------------------------------------------------------------------------------------------------- */
/* clientes */
$routes->get('listar_clientes', 'Clientes::listar_clientes', ['filter' => 'cors']);
$routes->post('insertar_cliente', 'Clientes::insertar_cliente', ['filter' => 'cors']);
$routes->post('update_cliente', 'Clientes::update_cliente', ['filter' => 'cors']);
$routes->post('get_cliente', 'Clientes::get_cliente', ['filter' => 'cors']);
$routes->post('listar_dependecias_clientes', 'Clientes::listar_dependecias_clientes', ['filter' => 'cors']);
$routes->post('insertar_dependencia_cliente', 'Clientes::insertar_dependencia_cliente', ['filter' => 'cors']);
$routes->post('get_dependencia', 'Clientes::get_dependencia', ['filter' => 'cors']);
$routes->post('update_dependencia', 'Clientes::update_dependencia', ['filter' => 'cors']);
$routes->post('listar_contactos_dependecias_clientes', 'Clientes::listar_contactos_dependecias_clientes', ['filter' => 'cors']);
$routes->post('insertar_contactos_dependencia_cliente', 'Clientes::insertar_contactos_dependencia_cliente', ['filter' => 'cors']);
$routes->post('get_contacto_dependencia', 'Clientes::get_contacto_dependencia', ['filter' => 'cors']);
$routes->post('update_contacto_dependencia', 'Clientes::update_contacto_dependencia', ['filter' => 'cors']);
$routes->post('cargar_archivo_clientes', 'Clientes::cargar_archivo_clientes', ['filter' => 'cors']);
$routes->get('listar_cargas_clientes', 'Clientes::listar_cargas_clientes', ['filter' => 'cors']);
$routes->post('obtener_detalle_insertados_carga', 'Clientes::obtener_detalle_insertados_carga', ['filter' => 'cors']);
$routes->post('obtener_detalle_editados_carga', 'Clientes::obtener_detalle_editados_carga', ['filter' => 'cors']);
$routes->post('obtener_detalle_errores_carga', 'Clientes::obtener_detalle_errores_carga', ['filter' => 'cors']);
$routes->post('get_equipo_cliente_all', 'Clientes::get_equipo_cliente_all', ['filter' => 'cors']);
/* EQUIPOS DEPENDENCIA */
$routes->post('listar_equipos_dependencia', 'Clientes::listar_equipos_dependencia', ['filter' => 'cors']);
$routes->post('insertar_equipo_dependencia', 'Clientes::insertar_equipo_dependencia', ['filter' => 'cors']);
$routes->post('get_equipo_dependencia', 'Clientes::get_equipo_dependencia', ['filter' => 'cors']);
$routes->post('update_equipo_dependencia', 'Clientes::update_equipo_dependencia', ['filter' => 'cors']);
$routes->post('listar_equipos_cliente', 'Clientes::listar_equipos_cliente', ['filter' => 'cors']);
$routes->post('listar_equipos_cliente_nit', 'Clientes::listar_equipos_cliente_nit', ['filter' => 'cors']);
$routes->post('get_odt_equipo', 'Pedido::get_odt_equipo', ['filter' => 'cors']);
/* EQUIPOS DEPENDENCIA */



/* clientes */

/* equipos_materiales */
$routes->get('listar_equipos_materiales', 'Configuraciones::listar_equipos_materiales', ['filter' => 'cors']);
$routes->post('insertar_equipos_materiales', 'Configuraciones::insertar_equipos_materiales', ['filter' => 'cors']);
$routes->post('get_equipos_materiales', 'Configuraciones::get_equipos_materiales', ['filter' => 'cors']);
$routes->post('update_equipos_materiales', 'Configuraciones::update_equipos_materiales', ['filter' => 'cors']);
/* equipos_materiales */

/* REPUESTOS */
$routes->get('listar_repuestos', 'Configuraciones::listar_repuestos', ['filter' => 'cors']);
$routes->post('insertar_repuestos', 'Configuraciones::insertar_repuestos', ['filter' => 'cors']);
$routes->post('get_repuestos', 'Configuraciones::get_repuestos', ['filter' => 'cors']);
$routes->post('update_repuestos', 'Configuraciones::update_repuestos', ['filter' => 'cors']);
/* REPUESTOS */

/* SERVICIOS */
$routes->get('listar_servicios', 'Configuraciones::listar_servicios', ['filter' => 'cors']);
$routes->post('insertar_servicios', 'Configuraciones::insertar_servicios', ['filter' => 'cors']);
$routes->post('get_servicios', 'Configuraciones::get_servicios', ['filter' => 'cors']);
$routes->post('update_servicios', 'Configuraciones::update_servicios', ['filter' => 'cors']);
/* SERVICIOS */

/* FORMULARIOS */
$routes->get('listar_formularios', 'Configuraciones::listar_formularios', ['filter' => 'cors']);
$routes->post('insertar_formularios', 'Configuraciones::insertar_formularios', ['filter' => 'cors']);
$routes->post('get_formularios', 'Configuraciones::get_formularios', ['filter' => 'cors']);
$routes->post('update_formularios', 'Configuraciones::update_formularios', ['filter' => 'cors']);
/* FORMULARIOS */
/* ASIGNACION MATERIALES */
$routes->post('listar_materiales_equipos_servicios', 'Configuraciones::listar_materiales_equipos_servicios', ['filter' => 'cors']);
$routes->post('insertar_materiales_equipos_servicios', 'Configuraciones::insertar_materiales_equipos_servicios', ['filter' => 'cors']);
$routes->post('delete_materiales_equipos_servicios', 'Configuraciones::delete_materiales_equipos_servicios', ['filter' => 'cors']);
/* ASIGNACION MATERIALES */
/* ASIGNACION REPUESTO */
$routes->post('listar_repuestos_servicio', 'Configuraciones::listar_repuestos_servicio', ['filter' => 'cors']);
$routes->post('insertar_repuestos_servicio', 'Configuraciones::insertar_repuestos_servicio', ['filter' => 'cors']);
$routes->post('delete_repuestos_servicio', 'Configuraciones::delete_repuestos_servicio', ['filter' => 'cors']);
/* ASIGNACION REPUESTO */
/* ASIGNACION FORMULARIOS */
$routes->post('listar_formularios_servicio', 'Configuraciones::listar_formularios_servicio', ['filter' => 'cors']);
$routes->post('listar_formularios_servicio_archivo', 'Configuraciones::listar_formularios_servicio_archivo', ['filter' => 'cors']);
$routes->post('insertar_formularios_servicio', 'Configuraciones::insertar_formularios_servicio', ['filter' => 'cors']);
$routes->post('delete_formularios_servicio', 'Configuraciones::delete_formularios_servicio', ['filter' => 'cors']);
/* ASIGNACION FORMULARIOS */

/* MODULOS-EQUIPOS */
$routes->post('listar_modulos_equipo', 'Configuraciones::listar_modulos_equipo', ['filter' => 'cors']);
$routes->post('insertar_modulos_equipo', 'Configuraciones::insertar_modulos_equipo', ['filter' => 'cors']);
$routes->post('get_modulos_equipo', 'Configuraciones::get_modulos_equipo', ['filter' => 'cors']);
$routes->post('update_modulos_equipo', 'Configuraciones::update_modulos_equipo', ['filter' => 'cors']);
/* MODULOS-EQUIPOS */

/* PEDIDOS */
$routes->post('cargar_archivo_pedido', 'Pedido::cargar_archivo_pedido', ['filter' => 'cors']);
$routes->post('cargar_archivo_contrato', 'Pedido::cargar_archivo_contrato', ['filter' => 'cors']);
$routes->get('listar_cargas_pedidos', 'Pedido::listar_cargas_pedidos', ['filter' => 'cors']);
$routes->get('listar_cargas_contratos', 'Pedido::listar_cargas_contratos', ['filter' => 'cors']);
$routes->get('listar_pedidos', 'Pedido::listar_pedidos', ['filter' => 'cors']);
$routes->get('listar_contratos', 'Pedido::listar_contratos', ['filter' => 'cors']);
$routes->post('programar_pedidos', 'Pedido::programar_pedidos', ['filter' => 'cors']);
$routes->post('get_pedido', 'Pedido::get_pedido', ['filter' => 'cors']);
$routes->post('get_contrato', 'Pedido::get_contrato', ['filter' => 'cors']);
$routes->post('get_cliente_nit', 'Clientes::get_cliente_nit', ['filter' => 'cors']);
$routes->post('get_ingenieroS_nivel', 'Pedido::get_ingenieroS_nivel', ['filter' => 'cors']);
$routes->post('get_ultima_ingeniero_odt', 'Pedido::get_ultima_ingeniero_odt', ['filter' => 'cors']);
$routes->post('update_odt', 'Pedido::update_odt', ['filter' => 'cors']);
$routes->post('guardar_imagen_tercero', 'Pedido::guardar_imagen_tercero', ['filter' => 'cors']);
$routes->get('infrome_terceros_pdf', 'Pedido::infrome_terceros_pdf', ['filter' => 'cors']);
$routes->post('guardar_adjunto_externo', 'Pedido::guardar_adjunto_externo', ['filter' => 'cors']);
$routes->get('infrome_externos_pdf', 'Pedido::infrome_externos_pdf', ['filter' => 'cors']);

/* PEDIDOS */

/* ORDENES DE TRABAJO */


$routes->get('listar_odt', 'Pedido::listar_odt', ['filter' => 'cors']);
$routes->get('listar_odt_nueva', 'Pedido::listar_odt_nueva', ['filter' => 'cors']);
$routes->get('listar_odt_terceros', 'Pedido::listar_odt_terceros', ['filter' => 'cors']);
$routes->get('listar_odt_contratos', 'Pedido::listar_odt_contratos', ['filter' => 'cors']);
$routes->get('listar_odt_all', 'Pedido::listar_odt_all', ['filter' => 'cors']);
$routes->post('listar_odt_all_fechas', 'Pedido::listar_odt_all_fechas', ['filter' => 'cors']);
$routes->post('listar_odt_ingenieros', 'Pedido::listar_odt_ingenieros', ['filter' => 'cors']);
$routes->post('listar_odt_ingenieros_nueva', 'Pedido::listar_odt_ingenieros_nueva', ['filter' => 'cors']);
$routes->post('insertar_odt', 'Pedido::insertar_odt', ['filter' => 'cors']);
$routes->post('get_servicio_codigo', 'Configuraciones::get_servicio_codigo', ['filter' => 'cors']);
$routes->post('get_equipo_cliente', 'Clientes::get_equipo_cliente', ['filter' => 'cors']);
$routes->post('get_programacion_ingeniero_hora', 'Clientes::get_programacion_ingeniero_hora', ['filter' => 'cors']);
$routes->post('get_programacion_ingeniero_hora_update', 'Clientes::get_programacion_ingeniero_hora_update', ['filter' => 'cors']);
$routes->post('insertar_repuesto_servicio_odt', 'Configuraciones::insertar_repuesto_servicio_odt', ['filter' => 'cors']);
$routes->post('delete_repuestos_odt', 'Configuraciones::delete_repuestos_odt', ['filter' => 'cors']);
$routes->post('listar_repuestos_odt', 'Pedido::listar_repuestos_odt', ['filter' => 'cors']);
$routes->post('update_observaciones_odt', 'Pedido::update_observaciones_odt', ['filter' => 'cors']);
$routes->post('get_odt_id', 'Pedido::get_odt_id', ['filter' => 'cors']);
$routes->post('insertar_odt_manual', 'Pedido::insertar_odt_manual', ['filter' => 'cors']);
$routes->post('eliminar_odt', 'Pedido::eliminar_odt', ['filter' => 'cors']);
$routes->post('get_odt_equipo_cliente', 'Pedido::get_odt_equipo_cliente', ['filter' => 'cors']);
/* ORDENES DE TRABAJO */


/* PERMISOS */


$routes->get('listar_Perfiles', 'Permisos::listar_Perfiles', ['filter' => 'cors']);
$routes->post('modulos_perfil', 'Permisos::modulos_perfil', ['filter' => 'cors']);
$routes->post('editar_permiso', 'Permisos::editar_permiso', ['filter' => 'cors']);
$routes->post('modulos_perfil_asignar', 'Permisos::modulos_perfil_asignar', ['filter' => 'cors']);
$routes->post('modulos_no_perfil', 'Permisos::modulos_no_perfil', ['filter' => 'cors']);
$routes->post('delete_modulo', 'Permisos::delete_modulo', ['filter' => 'cors']);
$routes->post('insertar_modulo', 'Permisos::insertar_modulo', ['filter' => 'cors']);

/* PERMISOS */



/* LLENADO FORMULARIOS */

$routes->post('update_01_06', 'Formularios::update_01_06', ['filter' => 'cors']);
$routes->post('get_01_06', 'Formularios::get_01_06', ['filter' => 'cors']);
$routes->post('get_04_01', 'Formularios::get_04_01', ['filter' => 'cors']);
$routes->post('get_formulario_01_06', 'Formularios::get_formulario_01_06', ['filter' => 'cors']);
$routes->post('archivo_formulario_01_06', 'Formularios::archivo_formulario_01_06', ['filter' => 'cors']);
$routes->get('obtenerImagen_formulario_01_06', 'Formularios::obtenerImagen_formulario_01_06', ['filter' => 'cors']);
$routes->post('get_01_06_pdf', 'Formularios::get_01_06_pdf', ['filter' => 'cors']);
$routes->get('archivo_formulario_06', 'Formularios::archivo_formulario_06', ['filter' => 'cors']);


$routes->post('get_01_12', 'Formularios::get_01_12', ['filter' => 'cors']);
$routes->post('insertar_formulario_01_12', 'Formularios::insertar_formulario_01_12', ['filter' => 'cors']);
$routes->post('update_01_12', 'Formularios::update_01_12', ['filter' => 'cors']);
$routes->get('obtenerImagen_formulario_01_12', 'Formularios::obtenerImagen_formulario_01_12', ['filter' => 'cors']);
$routes->post('get_01_12_pdf', 'Formularios::get_01_12_pdf', ['filter' => 'cors']);
$routes->get('archivo_formulario_12', 'Formularios::archivo_formulario_12', ['filter' => 'cors']);
$routes->post('update_repuestos_odt_formulario', 'Formularios::update_repuestos_odt_formulario', ['filter' => 'cors']);
$routes->post('update_repuestos_proximos_formulario', 'Formularios::update_repuestos_proximos_formulario', ['filter' => 'cors']);
$routes->post('listar_repuestos_proximos', 'Formularios::listar_repuestos_proximos', ['filter' => 'cors']);
/* LLENADO FORMULARIOS */


/* correo */

$routes->post('envio_correo', 'Pedido::envio_correo', ['filter' => 'cors']);


/* correo */

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
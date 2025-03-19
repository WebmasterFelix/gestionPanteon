<?php

/**
 * Función para verificar si un usuario tiene un permiso específico
 * 
 * @param int $usuario_id ID del usuario
 * @param string $permiso_clave Clave del permiso a verificar
 * @return bool True si tiene el permiso, False en caso contrario
 */
function verificar_permiso($usuario_id, $permiso_clave) 
{
    $db = \Config\Database::connect();
    
    // Primero verificamos si es el usuario admin (ID 1) - este tiene todos los permisos
    if ($usuario_id == 1) {
        return true;
    }
    
    // Consulta para verificar si el usuario tiene el permiso a través de sus roles
    $builder = $db->table('tbl_usuario_roles ur');
    $builder->join('tbl_rol_permisos rp', 'ur.rol_id = rp.rol_id');
    $builder->join('tbl_permisos p', 'rp.permiso_id = p.permiso_id');
    $builder->where('ur.usuario_id', $usuario_id);
    $builder->where('p.permiso_clave', $permiso_clave);
    
    $result = $builder->countAllResults();
    
    return ($result > 0);
}

/**
 * Función para obtener todos los permisos de un usuario
 * 
 * @param int $usuario_id ID del usuario
 * @return array Array con las claves de los permisos
 */
function obtener_permisos_usuario($usuario_id) 
{
    $db = \Config\Database::connect();
    
    // Si es el usuario admin (ID 1), obtenemos todos los permisos
    if ($usuario_id == 1) {
        $builder = $db->table('tbl_permisos');
        $permisos = $builder->select('permiso_clave')->get()->getResultArray();
        
        return array_column($permisos, 'permiso_clave');
    }
    
    // Consulta para obtener los permisos del usuario a través de sus roles
    $builder = $db->table('tbl_usuario_roles ur');
    $builder->join('tbl_rol_permisos rp', 'ur.rol_id = rp.rol_id');
    $builder->join('tbl_permisos p', 'rp.permiso_id = p.permiso_id');
    $builder->where('ur.usuario_id', $usuario_id);
    $builder->select('p.permiso_clave');
    
    $permisos = $builder->get()->getResultArray();
    
    return array_unique(array_column($permisos, 'permiso_clave'));
}

/**
 * Función para obtener los módulos a los que tiene acceso un usuario
 * 
 * @param int $usuario_id ID del usuario
 * @return array Array con los módulos
 */
function obtener_modulos_usuario($usuario_id) 
{
    $db = \Config\Database::connect();
    
    // Si es el usuario admin (ID 1), obtenemos todos los módulos
    if ($usuario_id == 1) {
        $builder = $db->table('tbl_modulos');
        $builder->where('modulo_estado', 'activo');
        $builder->orderBy('modulo_orden', 'ASC');
        
        return $builder->get()->getResultArray();
    }
    
    // Consulta para obtener los módulos a los que tiene acceso el usuario
    $builder = $db->table('tbl_usuario_roles ur');
    $builder->join('tbl_rol_permisos rp', 'ur.rol_id = rp.rol_id');
    $builder->join('tbl_permiso_acciones pa', 'rp.permiso_id = pa.permiso_id');
    $builder->join('tbl_modulo_acciones ma', 'pa.accion_id = ma.accion_id');
    $builder->join('tbl_modulos m', 'ma.modulo_id = m.modulo_id');
    $builder->where('ur.usuario_id', $usuario_id);
    $builder->where('m.modulo_estado', 'activo');
    $builder->groupBy('m.modulo_id');
    $builder->orderBy('m.modulo_orden', 'ASC');
    $builder->select('m.*');
    
    return $builder->get()->getResultArray();
}

/**
 * Función para registrar una actividad en el log
 * 
 * @param int $usuario_id ID del usuario
 * @param string $accion Acción realizada
 * @param string $modulo Módulo donde se realizó la acción
 * @param string $descripcion Descripción de la acción
 * @param array $datos_antiguos Datos antiguos (opcional)
 * @param array $datos_nuevos Datos nuevos (opcional)
 * @return bool True si se registró correctamente
 */
function registrar_actividad($usuario_id, $accion, $modulo, $descripcion, $datos_antiguos = null, $datos_nuevos = null) 
{
    $db = \Config\Database::connect();
    $request = \Config\Services::request();
    
    $data = [
        'usuario_id' => $usuario_id,
        'accion' => $accion,
        'modulo' => $modulo,
        'descripcion' => $descripcion,
        'datos_antiguos' => $datos_antiguos ? json_encode($datos_antiguos) : null,
        'datos_nuevos' => $datos_nuevos ? json_encode($datos_nuevos) : null,
        'ip_address' => $request->getIPAddress(),
        'user_agent' => $request->getUserAgent()->getAgentString()
    ];
    
    $builder = $db->table('tbl_log_actividad');
    return $builder->insert($data);
}

/**
 * Función para generar un filtro de acceso basado en permisos
 * 
 * @param string $permiso_clave Clave del permiso requerido
 * @return \Closure Función de filtro
 */
function filtro_permiso($permiso_clave) 
{
    return function($request, $response, $arguments) use ($permiso_clave) {
        $session = \Config\Services::session();
        
        // Verificar si el usuario está logueado
        if (!$session->get('usuario_id')) {
            return redirect()->to('/login');
        }
        
        // Verificar si tiene el permiso
        if (!verificar_permiso($session->get('usuario_id'), $permiso_clave)) {
            return redirect()->to('/dashboard')->with('error', 'No tiene permisos para acceder a esta sección');
        }
    };
}

/**
 * Función para construir el menú dinámico según los permisos del usuario
 * 
 * @param int $usuario_id ID del usuario
 * @return string HTML del menú
 */
function construir_menu($usuario_id) 
{
    $modulos = obtener_modulos_usuario($usuario_id);
    $html = '';
    
    // Agrupar módulos por padres
    $modulosPadre = [];
    $modulosHijos = [];
    
    foreach ($modulos as $modulo) {
        if ($modulo['modulo_padre_id'] === null) {
            $modulosPadre[$modulo['modulo_id']] = $modulo;
        } else {
            if (!isset($modulosHijos[$modulo['modulo_padre_id']])) {
                $modulosHijos[$modulo['modulo_padre_id']] = [];
            }
            $modulosHijos[$modulo['modulo_padre_id']][] = $modulo;
        }
    }
    
    // Construir el menú
    foreach ($modulosPadre as $moduloPadre) {
        $tieneHijos = isset($modulosHijos[$moduloPadre['modulo_id']]);
        $rutaActual = uri_string();
        $esActivo = ($rutaActual == $moduloPadre['modulo_ruta']);
        $claseActivo = $esActivo ? 'active' : '';
        
        // Si tiene hijos
        if ($tieneHijos) {
            // Verificar si alguno de los hijos está activo
            $algunHijoActivo = false;
            foreach ($modulosHijos[$moduloPadre['modulo_id']] as $hijo) {
                if ($rutaActual == $hijo['modulo_ruta']) {
                    $algunHijoActivo = true;
                    break;
                }
            }
            
            $menuAbierto = $algunHijoActivo ? 'menu-open' : '';
            $claseActivo = $algunHijoActivo ? 'active' : '';
            
            $html .= '<li class="nav-item ' . $menuAbierto . '">';
            $html .= '<a href="#" class="nav-link ' . $claseActivo . '">';
            $html .= '<i class="nav-icon ' . $moduloPadre['modulo_icono'] . '"></i>';
            $html .= '<p>' . $moduloPadre['modulo_nombre'];
            $html .= '<i class="right fas fa-angle-left"></i>';
            $html .= '</p></a>';
            $html .= '<ul class="nav nav-treeview">';
            
            // Añadir los hijos
            foreach ($modulosHijos[$moduloPadre['modulo_id']] as $hijo) {
                $esActivoHijo = ($rutaActual == $hijo['modulo_ruta']) ? 'active' : '';
                $html .= '<li class="nav-item">';
                $html .= '<a href="' . base_url($hijo['modulo_ruta']) . '" class="nav-link ' . $esActivoHijo . '">';
                $html .= '<i class="' . $hijo['modulo_icono'] . ' nav-icon"></i>';
                $html .= '<p>' . $hijo['modulo_nombre'] . '</p>';
                $html .= '</a></li>';
            }
            
            $html .= '</ul></li>';
        } else {
            // Si no tiene hijos
            $html .= '<li class="nav-item">';
            $html .= '<a href="' . base_url($moduloPadre['modulo_ruta']) . '" class="nav-link ' . $claseActivo . '">';
            $html .= '<i class="nav-icon ' . $moduloPadre['modulo_icono'] . '"></i>';
            $html .= '<p>' . $moduloPadre['modulo_nombre'] . '</p>';
            $html .= '</a></li>';
        }
    }
    
    return $html;
}
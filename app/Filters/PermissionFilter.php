<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('permisos');
        $session = session();
        
        // Verificar si el usuario está logueado
        if (!$session->get('usuario_id')) {
            return redirect()->to('/login');
        }
        
        // El primer argumento debe ser la clave del permiso requerido
        if (empty($arguments)) {
            return redirect()->to('/dashboard')->with('error', 'Error de configuración de permisos');
        }
        
        $permiso_requerido = $arguments[0];
        
        // Verificar si tiene el permiso
        if (!verificar_permiso($session->get('usuario_id'), $permiso_requerido)) {
            return redirect()->to('/dashboard')->with('error', 'No tiene permisos para acceder a esta sección');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No hacemos nada después de la solicitud
    }
}
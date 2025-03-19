<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Verificar si el usuario está logueado
        if (!$this->session->get('usuario_id')) {
            return redirect()->to('/login');
        }

        // Obtener estadísticas para el dashboard
        $db = \Config\Database::connect();
        
        // Contar usuarios
        $totalUsuarios = $db->table('tbl_usuarios')->countAllResults();
        $usuariosActivos = $db->table('tbl_usuarios')->where('usuario_estado', 'activo')->countAllResults();
        $usuariosPendientes = $db->table('tbl_usuarios')->where('usuario_estado', 'pendiente')->countAllResults();
        
        // Contar roles
        $totalRoles = $db->table('tbl_roles')->countAllResults();
        
        // Contar permisos
        $totalPermisos = $db->table('tbl_permisos')->countAllResults();
        
        // Contar módulos
        $totalModulos = $db->table('tbl_modulos')->countAllResults();
        
        // Obtener usuarios recientes
        $usuariosRecientes = $db->table('tbl_usuarios')
                               ->select('usuario_id, usuario_nombre, usuario_apellido, usuario_usuario, usuario_estado, usuario_foto, created_at')
                               ->orderBy('created_at', 'DESC')
                               ->limit(5)
                               ->get()
                               ->getResultArray();
                               
        // Obtener actividad reciente
        $actividadReciente = $db->table('tbl_log_actividad a')
                               ->select('a.*, u.usuario_nombre, u.usuario_apellido, u.usuario_foto')
                               ->join('tbl_usuarios u', 'a.usuario_id = u.usuario_id', 'left')
                               ->orderBy('a.created_at', 'DESC')
                               ->limit(10)
                               ->get()
                               ->getResultArray();

        $data = [
            'titulo' => 'Dashboard',
            'vista_contenido' => 'dashboard/index',
            'estadisticas' => [
                'totalUsuarios' => $totalUsuarios,
                'usuariosActivos' => $usuariosActivos,
                'usuariosPendientes' => $usuariosPendientes,
                'totalRoles' => $totalRoles,
                'totalPermisos' => $totalPermisos,
                'totalModulos' => $totalModulos
            ],
            'usuariosRecientes' => $usuariosRecientes,
            'actividadReciente' => $actividadReciente
        ];

        return view('plantillas/admin_template', $data);
    }
}
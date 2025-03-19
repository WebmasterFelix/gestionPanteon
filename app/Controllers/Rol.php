<?php

namespace App\Controllers;

use App\Models\RolModel;
use App\Models\PermisoModel;
use CodeIgniter\HTTP\ResponseInterface;

class Rol extends BaseController
{
    protected $rolModel;
    protected $permisoModel;

    public function __construct()
    {
        $this->rolModel = new RolModel();
        $this->permisoModel = new PermisoModel();
    }

    public function index()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('roles_admin');
        if ($result !== true) {
            return $result;
        }

        $data = [
            'roles' => $this->rolModel->findAll(),
            'titulo' => 'Gestión de Roles',
            'vista_contenido' => 'roles/lista_roles'
        ];

        return view('plantillas/admin_template', $data);
    }

    public function nuevo()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('roles_admin');
        if ($result !== true) {
            return $result;
        }

        // Obtener todos los permisos disponibles
        $permisos = $this->permisoModel->findAll();

        $data = [
            'titulo' => 'Crear Nuevo Rol',
            'vista_contenido' => 'roles/crear_rol',
            'permisos' => $permisos
        ];

        return view('plantillas/admin_template', $data);
    }

    public function crear()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('roles_admin');
        if ($result !== true) {
            return $result;
        }

        // Validar datos del formulario
        $rules = [
            'rol_nombre' => 'required|min_length[3]|max_length[100]|is_unique[tbl_roles.rol_nombre]',
            'rol_descripcion' => 'permit_empty|max_length[255]'
        ];
        
        if (!$this->validate($rules)) {
            // Si la validación falla, redirigir con errores
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Preparar datos para inserción
        $data = [
            'rol_nombre' => $this->request->getPost('rol_nombre'),
            'rol_descripcion' => $this->request->getPost('rol_descripcion')
        ];

        try {
            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();
            
            // Insertar rol
            $this->rolModel->insert($data);
            $rol_id = $db->insertID();
            
            // Obtener los permisos seleccionados
            $permisos = $this->request->getPost('permisos');
            
            // Si se seleccionaron permisos, asignarlos
            if (!empty($permisos)) {
                $this->rolModel->asignarPermisos($rol_id, $permisos);
            }
            
            // Confirmar transacción
            $db->transCommit();
            
            // Registrar actividad
            helper('permisos');
            registrar_actividad(
                $this->session->get('usuario_id'),
                'crear',
                'Roles',
                'Creación de rol: ' . $data['rol_nombre'],
                null,
                $data
            );
            
            return redirect()->to('/roles')->with('mensaje', 'Rol creado correctamente');
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            $db->transRollback();
            
            return redirect()->back()->withInput()->with('error', 'Error al crear el rol: ' . $e->getMessage());
        }
    }

    public function editar($id = null)
    {
        // Verificar permiso
        $result = $this->verificarPermiso('roles_admin');
        if ($result !== true) {
            return $result;
        }

        // Verificar que el rol existe
        $rol = $this->rolModel->find($id);
        if (empty($rol)) {
            return redirect()->to('/roles')->with('error', 'Rol no encontrado');
        }

        // Obtener todos los permisos disponibles
        $permisos = $this->permisoModel->findAll();
        
        // Obtener los permisos asignados al rol
        $permisosAsignados = $this->rolModel->obtenerPermisosRol($id);
        $permisosIds = array_column($permisosAsignados, 'permiso_id');

        $data = [
            'rol' => $rol,
            'permisos' => $permisos,
            'permisosAsignados' => $permisosIds,
            'titulo' => 'Editar Rol',
            'vista_contenido' => 'roles/editar_rol'
        ];

        return view('plantillas/admin_template', $data);
    }

    public function actualizar()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('roles_admin');
        if ($result !== true) {
            return $result;
        }

        $id = $this->request->getPost('rol_id');
        
        // Verificar que el rol existe
        $rol = $this->rolModel->find($id);
        if (empty($rol)) {
            return redirect()->to('/roles')->with('error', 'Rol no encontrado');
        }

        // Validar datos del formulario
        $rules = [
            'rol_nombre' => 'required|min_length[3]|max_length[100]|is_unique[tbl_roles.rol_nombre,rol_id,' . $id . ']',
            'rol_descripcion' => 'permit_empty|max_length[255]'
        ];
        
        if (!$this->validate($rules)) {
            // Si la validación falla, redirigir con errores
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Preparar datos para actualización
        $data = [
            'rol_nombre' => $this->request->getPost('rol_nombre'),
            'rol_descripcion' => $this->request->getPost('rol_descripcion')
        ];

        try {
            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();
            
            // Actualizar rol
            $this->rolModel->update($id, $data);
            
            // Obtener los permisos seleccionados
            $permisos = $this->request->getPost('permisos');
            
            // Actualizar permisos
            $this->rolModel->asignarPermisos($id, $permisos);
            
            // Confirmar transacción
            $db->transCommit();
            
            // Registrar actividad
            helper('permisos');
            registrar_actividad(
                $this->session->get('usuario_id'),
                'actualizar',
                'Roles',
                'Actualización de rol: ' . $data['rol_nombre'],
                $rol,
                $data
            );
            
            return redirect()->to('/roles')->with('mensaje', 'Rol actualizado correctamente');
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            $db->transRollback();
            
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el rol: ' . $e->getMessage());
        }
    }

    public function eliminar($id = null)
    {
        // Verificar permiso
        $result = $this->verificarPermiso('roles_admin');
        if ($result !== true) {
            return $result;
        }

        // Verificar que el rol existe
        $rol = $this->rolModel->find($id);
        if (empty($rol)) {
            return redirect()->to('/roles')->with('error', 'Rol no encontrado');
        }

        // No permitir eliminar roles críticos (IDs 1, 2, 3 que son los predeterminados)
        if (in_array($id, [1, 2, 3])) {
            return redirect()->to('/roles')->with('error', 'No se pueden eliminar roles predeterminados del sistema');
        }

        try {
            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();
            
            // Eliminar asignaciones de permisos al rol
            $db->table('tbl_rol_permisos')->where('rol_id', $id)->delete();
            
            // Eliminar asignaciones de usuarios al rol
            $db->table('tbl_usuario_roles')->where('rol_id', $id)->delete();
            
            // Eliminar el rol
            $this->rolModel->delete($id);
            
            // Confirmar transacción
            $db->transCommit();
            
            // Registrar actividad
            helper('permisos');
            registrar_actividad(
                $this->session->get('usuario_id'),
                'eliminar',
                'Roles',
                'Eliminación de rol: ' . $rol['rol_nombre'],
                $rol,
                null
            );
            
            return redirect()->to('/roles')->with('mensaje', 'Rol eliminado correctamente');
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            $db->transRollback();
            
            return redirect()->to('/roles')->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }
    }

    public function ver($id = null)
    {
        // Verificar permiso
        $result = $this->verificarPermiso('roles_admin');
        if ($result !== true) {
            return $result;
        }

        // Verificar que el rol existe
        $rol = $this->rolModel->find($id);
        if (empty($rol)) {
            return redirect()->to('/roles')->with('error', 'Rol no encontrado');
        }

        // Obtener los permisos asignados al rol
        $permisosAsignados = $this->rolModel->obtenerPermisosRol($id);
        
        // Obtener los usuarios asignados al rol
        $usuariosAsignados = $this->rolModel->obtenerUsuariosRol($id);

        $data = [
            'rol' => $rol,
            'permisos' => $permisosAsignados,
            'usuarios' => $usuariosAsignados,
            'titulo' => 'Detalles del Rol',
            'vista_contenido' => 'roles/ver_rol'
        ];

        return view('plantillas/admin_template', $data);
    }
}
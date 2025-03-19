<?php

namespace App\Controllers;

use App\Models\PermisoModel;
use CodeIgniter\HTTP\ResponseInterface;

class Permiso extends BaseController
{
    protected $permisoModel;

    public function __construct()
    {
        $this->permisoModel = new PermisoModel();
    }

    public function index()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('permisos_admin');
        if ($result !== true) {
            return $result;
        }

        $data = [
            'permisos' => $this->permisoModel->findAll(),
            'titulo' => 'Gestión de Permisos',
            'vista_contenido' => 'permisos/lista_permisos'
        ];

        return view('plantillas/admin_template', $data);
    }

    public function nuevo()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('permisos_admin');
        if ($result !== true) {
            return $result;
        }

        // Obtener todas las acciones de módulos disponibles
        $db = \Config\Database::connect();
        $acciones = $db->table('tbl_modulo_acciones ma')
                      ->select('ma.accion_id, ma.accion_nombre, ma.accion_descripcion, ma.accion_clave, m.modulo_nombre')
                      ->join('tbl_modulos m', 'ma.modulo_id = m.modulo_id')
                      ->get()
                      ->getResultArray();

        $data = [
            'titulo' => 'Crear Nuevo Permiso',
            'vista_contenido' => 'permisos/crear_permiso',
            'acciones' => $acciones
        ];

        return view('plantillas/admin_template', $data);
    }

    public function crear()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('permisos_admin');
        if ($result !== true) {
            return $result;
        }

        // Validar datos del formulario
        $rules = [
            'permiso_nombre' => 'required|min_length[3]|max_length[100]',
            'permiso_descripcion' => 'permit_empty|max_length[255]',
            'permiso_clave' => 'required|min_length[3]|max_length[100]|is_unique[tbl_permisos.permiso_clave]',
        ];
        
        if (!$this->validate($rules)) {
            // Si la validación falla, redirigir con errores
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Preparar datos para inserción
        $data = [
            'permiso_nombre' => $this->request->getPost('permiso_nombre'),
            'permiso_descripcion' => $this->request->getPost('permiso_descripcion'),
            'permiso_clave' => $this->request->getPost('permiso_clave')
        ];

        try {
            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();
            
            // Insertar permiso
            $this->permisoModel->insert($data);
            $permiso_id = $db->insertID();
            
            // Obtener las acciones seleccionadas
            $acciones = $this->request->getPost('acciones');
            
            // Si se seleccionaron acciones, asignarlas
            if (!empty($acciones)) {
                $this->permisoModel->asignarAcciones($permiso_id, $acciones);
            }
            
            // Confirmar transacción
            $db->transCommit();
            
            // Registrar actividad
            helper('permisos');
            registrar_actividad(
                $this->session->get('usuario_id'),
                'crear',
                'Permisos',
                'Creación de permiso: ' . $data['permiso_nombre'],
                null,
                $data
            );
            
            return redirect()->to('/permisos')->with('mensaje', 'Permiso creado correctamente');
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            $db->transRollback();
            
            return redirect()->back()->withInput()->with('error', 'Error al crear el permiso: ' . $e->getMessage());
        }
    }

    public function editar($id = null)
    {
        // Verificar permiso
        $result = $this->verificarPermiso('permisos_admin');
        if ($result !== true) {
            return $result;
        }

        // Verificar que el permiso existe
        $permiso = $this->permisoModel->find($id);
        if (empty($permiso)) {
            return redirect()->to('/permisos')->with('error', 'Permiso no encontrado');
        }

        // Obtener todas las acciones de módulos disponibles
        $db = \Config\Database::connect();
        $acciones = $db->table('tbl_modulo_acciones ma')
                      ->select('ma.accion_id, ma.accion_nombre, ma.accion_descripcion, ma.accion_clave, m.modulo_nombre')
                      ->join('tbl_modulos m', 'ma.modulo_id = m.modulo_id')
                      ->get()
                      ->getResultArray();
        
        // Obtener las acciones asignadas al permiso
        $accionesAsignadas = $this->permisoModel->obtenerAccionesPermiso($id);
        $accionesIds = array_column($accionesAsignadas, 'accion_id');

        $data = [
            'permiso' => $permiso,
            'acciones' => $acciones,
            'accionesAsignadas' => $accionesIds,
            'titulo' => 'Editar Permiso',
            'vista_contenido' => 'permisos/editar_permiso'
        ];

        return view('plantillas/admin_template', $data);
    }

    public function actualizar()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('permisos_admin');
        if ($result !== true) {
            return $result;
        }

        $id = $this->request->getPost('permiso_id');
        
        // Verificar que el permiso existe
        $permiso = $this->permisoModel->find($id);
        if (empty($permiso)) {
            return redirect()->to('/permisos')->with('error', 'Permiso no encontrado');
        }

        // Validar datos del formulario
        $rules = [
            'permiso_nombre' => 'required|min_length[3]|max_length[100]',
            'permiso_descripcion' => 'permit_empty|max_length[255]',
            'permiso_clave' => 'required|min_length[3]|max_length[100]|is_unique[tbl_permisos.permiso_clave,permiso_id,' . $id . ']',
        ];
        
        if (!$this->validate($rules)) {
            // Si la validación falla, redirigir con errores
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Preparar datos para actualización
        $data = [
            'permiso_nombre' => $this->request->getPost('permiso_nombre'),
            'permiso_descripcion' => $this->request->getPost('permiso_descripcion'),
            'permiso_clave' => $this->request->getPost('permiso_clave')
        ];

        try {
            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();
            
            // Actualizar permiso
            $this->permisoModel->update($id, $data);
            
            // Obtener las acciones seleccionadas
            $acciones = $this->request->getPost('acciones');
            
            // Actualizar acciones
            $this->permisoModel->asignarAcciones($id, $acciones);
            
            // Confirmar transacción
            $db->transCommit();
            
            // Registrar actividad
            helper('permisos');
            registrar_actividad(
                $this->session->get('usuario_id'),
                'actualizar',
                'Permisos',
                'Actualización de permiso: ' . $data['permiso_nombre'],
                $permiso,
                $data
            );
            
            return redirect()->to('/permisos')->with('mensaje', 'Permiso actualizado correctamente');
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            $db->transRollback();
            
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el permiso: ' . $e->getMessage());
        }
    }

    public function eliminar($id = null)
    {
        // Verificar permiso
        $result = $this->verificarPermiso('permisos_admin');
        if ($result !== true) {
            return $result;
        }

        // Verificar que el permiso existe
        $permiso = $this->permisoModel->find($id);
        if (empty($permiso)) {
            return redirect()->to('/permisos')->with('error', 'Permiso no encontrado');
        }

        // No permitir eliminar permisos críticos (los que tienen IDs del 1 al 7, que son los predeterminados)
        if ($id <= 7) {
            return redirect()->to('/permisos')->with('error', 'No se pueden eliminar permisos predeterminados del sistema');
        }

        try {
            // Iniciar transacción
            $db = \Config\Database::connect();
            $db->transBegin();
            
            // Eliminar asignaciones de acciones al permiso
            $db->table('tbl_permiso_acciones')->where('permiso_id', $id)->delete();
            
            // Eliminar asignaciones de roles al permiso
            $db->table('tbl_rol_permisos')->where('permiso_id', $id)->delete();
            
            // Eliminar el permiso
            $this->permisoModel->delete($id);
            
            // Confirmar transacción
            $db->transCommit();
            
            // Registrar actividad
            helper('permisos');
            registrar_actividad(
                $this->session->get('usuario_id'),
                'eliminar',
                'Permisos',
                'Eliminación de permiso: ' . $permiso['permiso_nombre'],
                $permiso,
                null
            );
            
            return redirect()->to('/permisos')->with('mensaje', 'Permiso eliminado correctamente');
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            $db->transRollback();
            
            return redirect()->to('/permisos')->with('error', 'Error al eliminar el permiso: ' . $e->getMessage());
        }
    }

    public function ver($id = null)
    {
        // Verificar permiso
        $result = $this->verificarPermiso('permisos_admin');
        if ($result !== true) {
            return $result;
        }

        // Verificar que el permiso existe
        $permiso = $this->permisoModel->find($id);
        if (empty($permiso)) {
            return redirect()->to('/permisos')->with('error', 'Permiso no encontrado');
        }

        // Obtener las acciones asignadas al permiso
        $accionesAsignadas = $this->permisoModel->obtenerAccionesPermiso($id);
        
        // Obtener los roles que tienen este permiso
        $rolesAsignados = $this->permisoModel->obtenerRolesPermiso($id);

        $data = [
            'permiso' => $permiso,
            'acciones' => $accionesAsignadas,
            'roles' => $rolesAsignados,
            'titulo' => 'Detalles del Permiso',
            'vista_contenido' => 'permisos/ver_permiso'
        ];

        return view('plantillas/admin_template', $data);
    }
}
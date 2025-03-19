<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table            = 'tbl_roles';
    protected $primaryKey       = 'rol_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'rol_nombre', 
        'rol_descripcion'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'rol_nombre'     => 'required|min_length[3]|max_length[100]|is_unique[tbl_roles.rol_nombre,rol_id,{rol_id}]',
        'rol_descripcion' => 'permit_empty|max_length[255]'
    ];
    
    protected $validationMessages = [
        'rol_nombre' => [
            'required'    => 'El nombre del rol es obligatorio',
            'min_length'  => 'El nombre del rol debe tener al menos 3 caracteres',
            'is_unique'   => 'Este nombre de rol ya está en uso',
        ]
    ];

    protected $skipValidation = false;
    
    /**
     * Obtiene los permisos asignados a un rol
     */
    public function obtenerPermisosRol($rol_id)
    {
        $db = \Config\Database::connect();
        return $db->table('tbl_rol_permisos rp')
                  ->select('p.permiso_id, p.permiso_nombre, p.permiso_descripcion, p.permiso_clave')
                  ->join('tbl_permisos p', 'rp.permiso_id = p.permiso_id')
                  ->where('rp.rol_id', $rol_id)
                  ->get()
                  ->getResultArray();
    }
    
    /**
     * Obtiene los usuarios asignados a un rol
     */
    public function obtenerUsuariosRol($rol_id)
    {
        $db = \Config\Database::connect();
        return $db->table('tbl_usuario_roles ur')
                  ->select('u.usuario_id, u.usuario_nombre, u.usuario_apellido, u.usuario_usuario, u.usuario_estado, u.usuario_foto')
                  ->join('tbl_usuarios u', 'ur.usuario_id = u.usuario_id')
                  ->where('ur.rol_id', $rol_id)
                  ->get()
                  ->getResultArray();
    }
    
    /**
     * Asigna permisos a un rol
     */
    public function asignarPermisos($rol_id, $permisos)
    {
        $db = \Config\Database::connect();
        
        // Eliminar permisos actuales
        $db->table('tbl_rol_permisos')->where('rol_id', $rol_id)->delete();
        
        // Si hay permisos para asignar
        if (!empty($permisos)) {
            $data = [];
            foreach ($permisos as $permiso_id) {
                $data[] = [
                    'rol_id' => $rol_id,
                    'permiso_id' => $permiso_id
                ];
            }
            
            // Insertar nuevos permisos
            return $db->table('tbl_rol_permisos')->insertBatch($data);
        }
        
        return true;
    }
}
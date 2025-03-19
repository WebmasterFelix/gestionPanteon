<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisoModel extends Model
{
    protected $table            = 'tbl_permisos';
    protected $primaryKey       = 'permiso_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'permiso_nombre', 
        'permiso_descripcion',
        'permiso_clave'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'permiso_nombre'        => 'required|min_length[3]|max_length[100]',
        'permiso_descripcion'   => 'permit_empty|max_length[255]',
        'permiso_clave'         => 'required|min_length[3]|max_length[100]|is_unique[tbl_permisos.permiso_clave,permiso_id,{permiso_id}]',
    ];
    
    protected $validationMessages = [
        'permiso_nombre' => [
            'required'    => 'El nombre del permiso es obligatorio',
            'min_length'  => 'El nombre del permiso debe tener al menos 3 caracteres',
        ],
        'permiso_clave' => [
            'required'    => 'La clave del permiso es obligatoria',
            'min_length'  => 'La clave del permiso debe tener al menos 3 caracteres',
            'is_unique'   => 'Esta clave de permiso ya está en uso',
        ]
    ];

    protected $skipValidation = false;
    
    /**
     * Obtiene los roles a los que está asignado un permiso
     */
    public function obtenerRolesPermiso($permiso_id)
    {
        $db = \Config\Database::connect();
        return $db->table('tbl_rol_permisos rp')
                  ->select('r.rol_id, r.rol_nombre, r.rol_descripcion')
                  ->join('tbl_roles r', 'rp.rol_id = r.rol_id')
                  ->where('rp.permiso_id', $permiso_id)
                  ->get()
                  ->getResultArray();
    }
    
    /**
     * Obtiene las acciones de módulos asociadas a un permiso
     */
    public function obtenerAccionesPermiso($permiso_id)
    {
        $db = \Config\Database::connect();
        return $db->table('tbl_permiso_acciones pa')
                  ->select('ma.accion_id, ma.modulo_id, ma.accion_nombre, ma.accion_descripcion, ma.accion_clave, m.modulo_nombre')
                  ->join('tbl_modulo_acciones ma', 'pa.accion_id = ma.accion_id')
                  ->join('tbl_modulos m', 'ma.modulo_id = m.modulo_id')
                  ->where('pa.permiso_id', $permiso_id)
                  ->get()
                  ->getResultArray();
    }
    
    /**
     * Asigna acciones de módulos a un permiso
     */
    public function asignarAcciones($permiso_id, $acciones)
    {
        $db = \Config\Database::connect();
        
        // Eliminar acciones actuales
        $db->table('tbl_permiso_acciones')->where('permiso_id', $permiso_id)->delete();
        
        // Si hay acciones para asignar
        if (!empty($acciones)) {
            $data = [];
            foreach ($acciones as $accion_id) {
                $data[] = [
                    'permiso_id' => $permiso_id,
                    'accion_id' => $accion_id
                ];
            }
            
            // Insertar nuevas acciones
            return $db->table('tbl_permiso_acciones')->insertBatch($data);
        }
        
        return true;
    }
}
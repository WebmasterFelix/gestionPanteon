<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'tbl_usuarios';
    protected $primaryKey       = 'usuario_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'usuario_nombre', 
        'usuario_apellido',
        'usuario_password_hash',
        'usuario_usuario',
        'usuario_estado',
        'usuario_foto'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'usuario_nombre'       => 'required|min_length[3]|max_length[100]',
        'usuario_apellido'     => 'required|min_length[3]|max_length[100]',
        'usuario_usuario'      => 'required|min_length[3]|max_length[64]|is_unique[tbl_usuarios.usuario_usuario,usuario_id,{usuario_id}]',
        'usuario_password'     => 'required|min_length[8]',
        'usuario_estado'       => 'required|in_list[activo,inactivo,pendiente]',
    ];
    
    protected $validationMessages = [
        'usuario_nombre' => [
            'required'    => 'El nombre es obligatorio',
            'min_length'  => 'El nombre debe tener al menos 3 caracteres',
        ],
        'usuario_apellido' => [
            'required'    => 'El apellido es obligatorio',
            'min_length'  => 'El apellido debe tener al menos 3 caracteres',
        ],
        'usuario_usuario' => [
            'required'    => 'El nombre de usuario es obligatorio',
            'min_length'  => 'El nombre de usuario debe tener al menos 3 caracteres',
            'is_unique'   => 'Este nombre de usuario ya está en uso',
        ],
        'usuario_password_hash' => [
            'required'    => 'La contraseña es obligatoria',
            'min_length'  => 'La contraseña debe tener al menos 8 caracteres',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Hash password before insert/update
     */
    protected function hashPassword(array $data)
    {
        // Para inserciones y actualizaciones normales
        if (isset($data['data']['usuario_password'])) {
            $data['data']['usuario_password_hash'] = password_hash(
                $data['data']['usuario_password'], 
                PASSWORD_DEFAULT
            );
            unset($data['data']['usuario_password']);
        }
        
        // Para cuando se usa el método save() directamente
        if (isset($data['usuario_password'])) {
            $data['usuario_password_hash'] = password_hash(
                $data['usuario_password'], 
                PASSWORD_DEFAULT
            );
            unset($data['usuario_password']);
        }

        return $data;
    }

    /**
     * Called before insert
     */
    protected function beforeInsert(array $data)
    {
        // Depuración
        log_message('debug', 'beforeInsert - Datos recibidos: ' . print_r($data, true));
        
        // Ya no necesitamos hashear la contraseña aquí, lo hacemos en el controlador
        // pero dejamos el código por si acaso
        if (isset($data['data']['usuario_password']) && !isset($data['data']['usuario_password_hash'])) {
            $data['data']['usuario_password_hash'] = password_hash(
                $data['data']['usuario_password'], 
                PASSWORD_DEFAULT
            );
            unset($data['data']['usuario_password']);
            log_message('debug', 'beforeInsert - Password hasheado');
        }
        
        log_message('debug', 'beforeInsert - Datos procesados: ' . print_r($data, true));
        return $data;
    }

    /**
     * Called before update
     */
    protected function beforeUpdate(array $data)
    {
        // Depuración
        log_message('debug', 'beforeUpdate - Datos recibidos: ' . print_r($data, true));
        
        // Ya no necesitamos hashear la contraseña aquí, lo hacemos en el controlador
        // pero dejamos el código por si acaso
        if (isset($data['data']['usuario_password']) && !isset($data['data']['usuario_password_hash'])) {
            $data['data']['usuario_password_hash'] = password_hash(
                $data['data']['usuario_password'], 
                PASSWORD_DEFAULT
            );
            unset($data['data']['usuario_password']);
            log_message('debug', 'beforeUpdate - Password hasheado');
        }
        
        log_message('debug', 'beforeUpdate - Datos procesados: ' . print_r($data, true));
        return $data;
    }
    
    /**
     * Verifica las credenciales del usuario para el login
     */
    public function verificarCredenciales($usuario, $password)
    {
        $user = $this->where('usuario_usuario', $usuario)
                     ->where('usuario_estado', 'activo')
                     ->first();
                     
        if (!$user) {
            return false;
        }
        
        return password_verify($password, $user['usuario_password_hash']) ? $user : false;
    }
    
    /**
     * Obtiene los datos de un usuario para mostrar en perfil
     */
    public function obtenerPerfil($id)
    {
        return $this->select('usuario_id, usuario_nombre, usuario_apellido, usuario_usuario, usuario_estado, usuario_foto, created_at')
                    ->where('usuario_id', $id)
                    ->first();
    }
}
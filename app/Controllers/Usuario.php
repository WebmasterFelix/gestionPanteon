<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class Usuario extends BaseController
{
    protected $usuarioModel;
    protected $session;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('usuarios_ver');
        if ($result !== true) {
            return $result;
        }

        $data = [
            'usuarios' => $this->usuarioModel->findAll(),
            'titulo' => 'Gestión de Usuarios',
            'vista_contenido' => 'usuarios/lista_usuarios'
        ];

        return view('plantillas/admin_template', $data);
    }

    public function nuevo()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('usuarios_crear');
        if ($result !== true) {
            return $result;
        }

        // Obtener todos los roles para el formulario
        $db = \Config\Database::connect();
        $roles = $db->table('tbl_roles')->get()->getResultArray();

        $data = [
            'titulo' => 'Crear Nuevo Usuario',
            'vista_contenido' => 'usuarios/crear_usuario',
            'roles' => $roles
        ];

        return view('plantillas/admin_template', $data);
    }

    public function crear()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('usuarios_crear');
        if ($result !== true) {
            return $result;
        }

        $rules = $this->usuarioModel->getValidationRules();
        
        // Para creación, la contraseña es obligatoria
        if (!$this->validate($rules)) {
            log_message('error', 'Validación fallida: ' . print_r($this->validator->getErrors(), true));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($this->validator->hasError('usuario_usuario')) {
            log_message('error', 'Error específico en usuario_usuario: ' . $this->validator->getError('usuario_usuario'));
            return redirect()->back()->withInput()->with('error', $this->validator->getError('usuario_usuario'));
        }

        // Procesar imagen de perfil si se subió
        $foto = $this->request->getFile('usuario_foto');
        $fotoPath = 'assets/images/perfil/user2-160x160.jpg'; // Valor por defecto

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $nuevoNombre = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/assets/images/perfil', $nuevoNombre);
            $fotoPath = 'assets/images/perfil/' . $nuevoNombre;
        }

        $data = [
            'usuario_nombre' => $this->request->getPost('usuario_nombre'),
            'usuario_apellido' => $this->request->getPost('usuario_apellido'),
            'usuario_usuario' => $this->request->getPost('usuario_usuario'),
            'usuario_password' => $this->request->getPost('usuario_password'),
            'usuario_estado' => $this->request->getPost('usuario_estado'),
            'usuario_foto' => $fotoPath
        ];

        try {
            // Depuración - imprimir datos antes de la inserción
            log_message('debug', 'Datos a insertar: ' . print_r($data, true));
            
            // Guardamos una copia de la contraseña original para la validación
            $password_original = $data['usuario_password'];
            
            // Realizar la validación manualmente
            $rules = [
                'usuario_nombre'    => 'required|min_length[3]|max_length[100]',
                'usuario_apellido'  => 'required|min_length[3]|max_length[100]',
                'usuario_usuario'   => 'required|min_length[3]|max_length[64]|is_unique[tbl_usuarios.usuario_usuario,usuario_id,{usuario_id}]',
                'usuario_estado'    => 'required|in_list[activo,inactivo,pendiente]',
            ];
            
            if (!$this->validate($rules)) {
                log_message('error', 'Validación fallida: ' . print_r($this->validator->getErrors(), true));
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            
            // Asegurarse de que los datos son correctos
            // Convertimos usuario_password a usuario_password_hash manualmente
            $data['usuario_password_hash'] = password_hash($data['usuario_password'], PASSWORD_DEFAULT);
            unset($data['usuario_password']); // Eliminamos el campo original
            log_message('debug', 'Password hasheado manualmente. Datos actualizados: ' . print_r($data, true));
            
            // Obtener los roles seleccionados
            $roles_seleccionados = $this->request->getPost('roles');
            
            // Insertamos directamente en la base de datos para evitar problemas de validación
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_usuarios');
            $result = $builder->insert($data);
            
            if (!$result) {
                log_message('error', 'No se pudo insertar el usuario en la BD: ' . $db->error()['message']);
                return redirect()->back()->withInput()->with('error', 'Error al insertar en la base de datos: ' . $db->error()['message']);
            }
            
            $usuario_id = $db->insertID();
            log_message('debug', 'Usuario insertado correctamente con ID: ' . $usuario_id);
            
            // Insertar roles del usuario
            if (!empty($roles_seleccionados)) {
                $rolesData = [];
                foreach ($roles_seleccionados as $rol_id) {
                    $rolesData[] = [
                        'usuario_id' => $usuario_id,
                        'rol_id' => $rol_id
                    ];
                }
                
                if (!empty($rolesData)) {
                    $builderRoles = $db->table('tbl_usuario_roles');
                    $builderRoles->insertBatch($rolesData);
                }
            }
            
            // Registrar acción en el log de actividad
            helper('permisos');
            registrar_actividad(
                $this->session->get('usuario_id'),
                'crear',
                'Usuarios',
                'Creación de usuario: ' . $data['usuario_nombre'] . ' ' . $data['usuario_apellido'],
                null,
                $data
            );
            
            return redirect()->to('/usuarios')->with('mensaje', 'Usuario creado correctamente con ID: ' . $usuario_id);
        } catch (\Exception $e) {
            // Depuración - imprimir el error
            log_message('error', 'Error al crear usuario: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            
            return redirect()->back()->withInput()->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    public function editar($id = null)
    {
        // Verificar permiso
        $result = $this->verificarPermiso('usuarios_editar');
        if ($result !== true) {
            return $result;
        }

        $usuario = $this->usuarioModel->find($id);
        if (empty($usuario)) {
            return redirect()->to('/usuarios')->with('error', 'Usuario no encontrado');
        }

        // Obtener todos los roles para el formulario
        $db = \Config\Database::connect();
        $roles = $db->table('tbl_roles')->get()->getResultArray();
        
        // Obtener los roles asignados al usuario
        $rolesUsuario = $db->table('tbl_usuario_roles')
                         ->where('usuario_id', $id)
                         ->get()
                         ->getResultArray();
        
        // Transformar el array para facilitar la verificación en la vista
        $rolesAsignados = array_column($rolesUsuario, 'rol_id');

        $data = [
            'usuario' => $usuario,
            'titulo' => 'Editar Usuario',
            'vista_contenido' => 'usuarios/editar_usuario',
            'roles' => $roles,
            'rolesAsignados' => $rolesAsignados
        ];

        return view('plantillas/admin_template', $data);
    }

    public function actualizar()
    {
        // Verificar permiso
        $result = $this->verificarPermiso('usuarios_editar');
        if ($result !== true) {
            return $result;
        }

        $id = $this->request->getPost('usuario_id');
        
        // Realizar la validación manualmente con el placeholder usuario_id correctamente configurado
        $rules = [
            'usuario_nombre'    => 'required|min_length[3]|max_length[100]',
            'usuario_apellido'  => 'required|min_length[3]|max_length[100]',
            'usuario_usuario'   => 'required|min_length[3]|max_length[64]|is_unique[tbl_usuarios.usuario_usuario,usuario_id,'.$id.']',
            'usuario_estado'    => 'required|in_list[activo,inactivo,pendiente]',
        ];
        
        // Si se proporciona contraseña, validarla
        if (!empty($this->request->getPost('usuario_password'))) {
            $rules['usuario_password'] = 'min_length[8]';
        }
        
        if (!$this->validate($rules)) {
            log_message('error', 'Validación fallida en actualizar: ' . print_r($this->validator->getErrors(), true));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Obtener el usuario actual para la foto
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            return redirect()->to('/usuarios')->with('error', 'Usuario no encontrado');
        }
        
        $fotoPath = $usuario['usuario_foto'];

        // Procesar imagen de perfil si se subió
        $foto = $this->request->getFile('usuario_foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $nuevoNombre = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/assets/images/perfil', $nuevoNombre);
            $fotoPath = 'assets/images/perfil/' . $nuevoNombre;
            
            // Eliminar foto anterior si no es la default
            if ($usuario['usuario_foto'] != 'assets/images/perfil/user2-160x160.jpg' && file_exists(ROOTPATH . 'public/' . $usuario['usuario_foto'])) {
                unlink(ROOTPATH . 'public/' . $usuario['usuario_foto']);
            }
        }

        $data = [
            'usuario_nombre' => $this->request->getPost('usuario_nombre'),
            'usuario_apellido' => $this->request->getPost('usuario_apellido'),
            'usuario_usuario' => $this->request->getPost('usuario_usuario'),
            'usuario_estado' => $this->request->getPost('usuario_estado'),
            'usuario_foto' => $fotoPath
        ];

        // Añadir contraseña solo si se proporcionó
        if (!empty($this->request->getPost('usuario_password'))) {
            $data['usuario_password_hash'] = password_hash($this->request->getPost('usuario_password'), PASSWORD_DEFAULT);
        }

        try {
            // Usar el Query Builder directamente como lo hicimos en el método crear
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_usuarios');
            $result = $builder->update($data, ['usuario_id' => $id]);
            
            if (!$result) {
                log_message('error', 'No se pudo actualizar el usuario en la BD: ' . $db->error()['message']);
                return redirect()->back()->withInput()->with('error', 'Error al actualizar en la base de datos: ' . $db->error()['message']);
            }
            
            // Actualizar roles del usuario
            $roles_seleccionados = $this->request->getPost('roles');
            
            // Eliminar roles actuales
            $builderRoles = $db->table('tbl_usuario_roles');
            $builderRoles->where('usuario_id', $id)->delete();
            
            // Insertar nuevos roles seleccionados
            if (!empty($roles_seleccionados)) {
                $rolesData = [];
                foreach ($roles_seleccionados as $rol_id) {
                    $rolesData[] = [
                        'usuario_id' => $id,
                        'rol_id' => $rol_id
                    ];
                }
                
                if (!empty($rolesData)) {
                    $builderRoles->insertBatch($rolesData);
                }
            }
            
            // Registrar acción en el log de actividad
            helper('permisos');
            registrar_actividad(
                $this->session->get('usuario_id'),
                'actualizar',
                'Usuarios',
                'Actualización de usuario ID: ' . $id,
                $usuario,
                $data
            );
            
            return redirect()->to('/usuarios')->with('mensaje', 'Usuario actualizado correctamente');
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar usuario: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function eliminar($id = null)
    {
        // Verificar permiso
        $result = $this->verificarPermiso('usuarios_eliminar');
        if ($result !== true) {
            return $result;
        }

        $usuario = $this->usuarioModel->find($id);
        if (empty($usuario)) {
            return redirect()->to('/usuarios')->with('error', 'Usuario no encontrado');
        }

        // Validar que no se está eliminando al propio usuario logeado
        if ($id == $this->session->get('usuario_id')) {
            return redirect()->to('/usuarios')->with('error', 'No puede eliminar su propio usuario');
        }

        // Eliminar foto si no es la default
        if ($usuario['usuario_foto'] != 'assets/images/perfil/user2-160x160.jpg' && file_exists(ROOTPATH . 'public/' . $usuario['usuario_foto'])) {
            unlink(ROOTPATH . 'public/' . $usuario['usuario_foto']);
        }

        $this->usuarioModel->delete($id);
        return redirect()->to('/usuarios')->with('mensaje', 'Usuario eliminado correctamente');
    }

    public function perfil()
    {
        if (!$this->session->get('usuario_id')) {
            return redirect()->to('/login');
        }

        $id = $this->session->get('usuario_id');
        $usuario = $this->usuarioModel->obtenerPerfil($id);

        $data = [
            'usuario' => $usuario,
            'titulo' => 'Mi Perfil',
            'vista_contenido' => 'usuarios/perfil'
        ];

        return view('plantillas/admin_template', $data);
    }

    public function guardarPerfil()
    {
        if (!$this->session->get('usuario_id')) {
            return redirect()->to('/login');
        }

        $id = $this->session->get('usuario_id');
        $accion = $this->request->getPost('accion');
        
        // Obtener el usuario actual
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            return redirect()->to('/dashboard')->with('error', 'Usuario no encontrado');
        }
        
        // Determinar qué acción realizar según el valor del campo 'accion'
        if ($accion === 'cambiar_password') {
            // Validación para cambio de contraseña
            $rules = [
                'actual_password' => 'required',
                'nuevo_password' => 'required|min_length[8]',
                'confirmar_password' => 'required|matches[nuevo_password]'
            ];
            
            if (!$this->validate($rules)) {
                return redirect()->to('/perfil#password')->withInput()->with('errors', $this->validator->getErrors());
            }
            
            // Verificar que la contraseña actual sea correcta
            if (!password_verify($this->request->getPost('actual_password'), $usuario['usuario_password_hash'])) {
                return redirect()->to('/perfil#password')->withInput()->with('error', 'La contraseña actual es incorrecta');
            }
            
            // Actualizar solo la contraseña
            $data = [
                'usuario_password_hash' => password_hash($this->request->getPost('nuevo_password'), PASSWORD_DEFAULT)
            ];
            
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_usuarios');
            $result = $builder->update($data, ['usuario_id' => $id]);
            
            if (!$result) {
                log_message('error', 'No se pudo actualizar la contraseña: ' . $db->error()['message']);
                return redirect()->to('/perfil#password')->with('error', 'Error al actualizar la contraseña: ' . $db->error()['message']);
            }
            
            // Registrar actividad
            helper('permisos');
            registrar_actividad(
                $id,
                'actualizar',
                'Perfil',
                'Cambio de contraseña',
                null,
                null
            );
            
            return redirect()->to('/perfil#password')->with('mensaje', 'Contraseña actualizada correctamente');
        } else {
            // Validación para actualización de perfil general
            $rules = [
                'usuario_nombre' => 'required|min_length[3]|max_length[100]',
                'usuario_apellido' => 'required|min_length[3]|max_length[100]',
            ];
            
            if (!$this->validate($rules)) {
                return redirect()->to('/perfil')->withInput()->with('errors', $this->validator->getErrors());
            }
            
            $fotoPath = $usuario['usuario_foto'];
            
            // Procesar imagen de perfil si se subió
            $foto = $this->request->getFile('usuario_foto');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                $nuevoNombre = $foto->getRandomName();
                $foto->move(ROOTPATH . 'public/assets/images/perfil', $nuevoNombre);
                $fotoPath = 'assets/images/perfil/' . $nuevoNombre;
                
                // Eliminar foto anterior si no es la default
                if ($usuario['usuario_foto'] != 'assets/images/perfil/user2-160x160.jpg' && file_exists(ROOTPATH . 'public/' . $usuario['usuario_foto'])) {
                    unlink(ROOTPATH . 'public/' . $usuario['usuario_foto']);
                }
            }
            
            $data = [
                'usuario_nombre' => $this->request->getPost('usuario_nombre'),
                'usuario_apellido' => $this->request->getPost('usuario_apellido'),
                'usuario_foto' => $fotoPath
            ];
            
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_usuarios');
            $result = $builder->update($data, ['usuario_id' => $id]);
            
            if (!$result) {
                log_message('error', 'No se pudo actualizar el perfil: ' . $db->error()['message']);
                return redirect()->to('/perfil')->with('error', 'Error al actualizar el perfil: ' . $db->error()['message']);
            }
            
            // Actualizar información de sesión
            $this->session->set('usuario_nombre', $data['usuario_nombre']);
            $this->session->set('usuario_apellido', $data['usuario_apellido']);
            $this->session->set('usuario_foto', $fotoPath);
            
            // Registrar actividad
            helper('permisos');
            registrar_actividad(
                $id,
                'actualizar',
                'Perfil',
                'Actualización de datos personales',
                $usuario,
                $data
            );
            
            return redirect()->to('/perfil')->with('mensaje', 'Perfil actualizado correctamente');
        }
    }
}
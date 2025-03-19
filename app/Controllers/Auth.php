<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
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
        // Si ya está logueado, redirigir al dashboard
        if ($this->session->get('usuario_id')) {
            return redirect()->to('/dashboard');
        }
        
        return $this->login();
    }

    public function login()
    {
        // Si ya está logueado, redirigir al dashboard
        if ($this->session->get('usuario_id')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function autenticar()
    {
        $usuario = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');
        
        // Validaciones básicas
        if (empty($usuario) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Debe proporcionar usuario y contraseña');
        }
        
        // Verificar credenciales
        $user = $this->usuarioModel->verificarCredenciales($usuario, $password);
        
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Usuario o contraseña incorrectos');
        }
        
        // Crear sesión
        $userData = [
            'usuario_id' => $user['usuario_id'],
            'usuario_nombre' => $user['usuario_nombre'],
            'usuario_apellido' => $user['usuario_apellido'],
            'usuario_usuario' => $user['usuario_usuario'],
            'usuario_foto' => $user['usuario_foto'],
            'isLoggedIn' => true
        ];
        
        $this->session->set($userData);
        
        return redirect()->to('/dashboard');
    }

    public function registro()
    {
        // Si ya está logueado, redirigir al dashboard
        if ($this->session->get('usuario_id')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/registro');
    }

    public function registrar()
    {
        $rules = [
            'usuario_nombre' => 'required|min_length[3]|max_length[100]',
            'usuario_apellido' => 'required|min_length[3]|max_length[100]',
            'usuario_usuario' => 'required|min_length[3]|max_length[64]|is_unique[tbl_usuarios.usuario_usuario]',
            'usuario_password' => 'required|min_length[8]',
            'confirmar_password' => 'required|matches[usuario_password]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'usuario_nombre' => $this->request->getPost('usuario_nombre'),
            'usuario_apellido' => $this->request->getPost('usuario_apellido'),
            'usuario_usuario' => $this->request->getPost('usuario_usuario'),
            'usuario_password' => $this->request->getPost('usuario_password'),
            'usuario_estado' => 'pendiente', // Por defecto, pendiente de aprobación
            'usuario_foto' => 'assets/images/perfil/user2-160x160.jpg'
        ];
        
        try {
            $this->usuarioModel->insert($data);
            return redirect()->to('/login')->with('mensaje', 'Registro exitoso. Por favor, espere la aprobación del administrador para poder acceder.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al registrar: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }

    public function recuperarPassword()
    {
        return view('auth/recuperar_password');
    }

    public function procesarRecuperacion()
    {
        $usuario = $this->request->getPost('usuario');
        
        if (empty($usuario)) {
            return redirect()->back()->withInput()->with('error', 'Debe proporcionar un nombre de usuario');
        }
        
        $user = $this->usuarioModel->where('usuario_usuario', $usuario)
                                  ->where('usuario_estado', 'activo')
                                  ->first();
                                  
        if (!$user) {
            // Por seguridad, no revelamos si el usuario existe o no
            return redirect()->back()->with('mensaje', 'Si el usuario existe, se ha enviado un correo con instrucciones para restablecer la contraseña');
        }
        
        // En un sistema real, aquí enviaríamos un correo con un token de recuperación
        // Para este ejemplo, simplemente mostraremos una página de confirmación
        
        return redirect()->to('/login')->with('mensaje', 'Se han enviado instrucciones para restablecer la contraseña');
    }
}
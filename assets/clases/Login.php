<?php
class Login{
    private $db_connection = null;
    public $errors = array();
    public $messages = array();
	
	public function __construct(){
        session_start();
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    private function dologinWithPostData(){
        if (empty($_POST['user_usuario'])) {
            $this->errors[] = "El campo de correo electrónico estaba vacío.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "El campo de contraseña estaba vacío.";
        } elseif (!empty($_POST['user_usuario']) && !empty($_POST['user_password'])) {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            if (!$this->db_connection->connect_errno) {
                $user_name = $this->db_connection->real_escape_string($_POST['user_usuario']);
                $sql = "SELECT usuario_id, usuario_nombre, usuario_apellido, usuario_password_hash, usuario_usuario, is_admin 
                        FROM tc_usuarios
                        WHERE usuario_usuario = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);
                if ($result_of_login_check->num_rows == 1) {
                    $result_row = $result_of_login_check->fetch_object();
                    if (password_verify($_POST['user_password'], $result_row->usuario_password_hash)) {
                        $_SESSION['user_id'] = $result_row->usuario_id;
						$_SESSION['user_nombre'] = $result_row->usuario_nombre;
						$_SESSION['user_apellido'] = $result_row->usuario_apellido;
                        $_SESSION['user_usuario'] = $result_row->usuario_usuario;
                        $_SESSION['is_admin'] = $result_row->is_admin;
						$_SESSION['user_active_dif'] = 1;
                    } else {
                        $this->errors[] = "Usuario y/o contraseña no coinciden.";
                    }
                } else {
                    $this->errors[] = "Usuario y/o contraseña no coinciden.";
                }
            } else {
                $this->errors[] = "Problema de conexión de base de datos.";
            }
        }
    }

    public function doLogout(){
        $_SESSION = array();
        session_destroy();
        $this->messages[] = "Has sido desconectado.";
    }

    public function isUserLoggedIn(){
        if (isset($_SESSION['user_active_dif']) AND $_SESSION['user_active_dif'] == 1) {
            return true;
        }
        return false;
    }
}
?>
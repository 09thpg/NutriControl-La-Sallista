<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Usuario.php';
require_once APP_PATH . '/services/EmailService.php';

class AuthController extends Controller
{
    private Usuario $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function index(): void
    {
        $this->view('auth/login');
    }

    public function login(): void
    {
        if (!$this->isPost()) {
            $this->redirect();
        }

        $usuario = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($usuario === '' || $password === '') {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            $this->redirect();
        }

        $datos = $this->usuario->login($usuario, $password);

        if (!$datos) {
            $_SESSION['error'] = 'Usuario o contraseña incorrectos.';
            $this->redirect();
        }

        session_regenerate_id(true);

        $_SESSION['usuario'] = [
            'id' => (int) $datos['id'],
            'nombre' => $datos['nombre'],
            'apellido' => $datos['apellido'],
            'grado' => $datos['grado'] ?? '',
            'documento' => $datos['documento'] ?? '',
            'usuario' => $datos['usuario'],
            'correo' => $datos['correo'],
            'avatar' => $datos['avatar'] ?? 'avatar1.png',
            'rol' => $datos['rol'] ?? 'Supervisor'
        ];

        $this->redirect('dashboard');
    }

    public function registro(): void
    {
        $this->view('auth/registro');
    }

    public function registrar(): void
    {
        if (!$this->isPost()) {
            $this->redirect('auth/registro');
        }

       $datos = [
    'nombre' => trim($_POST['nombre'] ?? ''),
    'apellido' => trim($_POST['apellido'] ?? ''),
    'grado' => '',
    'documento' => trim($_POST['documento'] ?? ''),
    'correo' => trim($_POST['correo'] ?? ''),
    'usuario' => trim($_POST['usuario'] ?? ''),
    'password' => $_POST['password'] ?? '',
    'confirmar_password' => $_POST['confirmar_password'] ?? '',
    'avatar' => 'avatar1.png',
    'rol' => 'Supervisor'
];

        if (
            $datos['nombre'] === '' ||
            $datos['apellido'] === '' ||
            $datos['documento'] === '' ||
            $datos['correo'] === '' ||
            $datos['usuario'] === '' ||
            $datos['password'] === '' ||
            $datos['confirmar_password'] === ''
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            $this->redirect('auth/registro');
        }

        if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'El correo electrónico no es válido.';
            $this->redirect('auth/registro');
        }

        if ($datos['password'] !== $datos['confirmar_password']) {
            $_SESSION['error'] = 'Las contraseñas no coinciden.';
            $this->redirect('auth/registro');
        }

        if (strlen($datos['password']) < 6) {
            $_SESSION['error'] = 'La contraseña debe tener mínimo 6 caracteres.';
            $this->redirect('auth/registro');
        }

        if ($this->usuario->existeDocumento($datos['documento'])) {
            $_SESSION['error'] = 'El documento ya está registrado.';
            $this->redirect('auth/registro');
        }

        if ($this->usuario->existeUsuario($datos['usuario'])) {
            $_SESSION['error'] = 'El usuario ya existe.';
            $this->redirect('auth/registro');
        }

        if ($this->usuario->existeCorreo($datos['correo'])) {
            $_SESSION['error'] = 'El correo ya está registrado.';
            $this->redirect('auth/registro');
        }

        $avatarSeleccionado = trim($_POST['avatar'] ?? '');

        $avataresPermitidos = [
            'avatar1.png',
            'avatar2.png',
            'avatar3.png',
            'avatar4.png',
            'avatar5.png',
            'avatar6.png'
        ];

        if (
            $avatarSeleccionado !== '' &&
            in_array($avatarSeleccionado, $avataresPermitidos, true)
        ) {
            $datos['avatar'] = $avatarSeleccionado;
        }

        $fotoGuardada = null;

        if (
            isset($_FILES['foto_perfil']) &&
            $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE
        ) {
            $foto = $_FILES['foto_perfil'];

            if ($foto['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = 'No se pudo subir la foto de perfil.';
                $this->redirect('auth/registro');
            }

            if ($foto['size'] > 2 * 1024 * 1024) {
                $_SESSION['error'] = 'La foto no puede superar los 2 MB.';
                $this->redirect('auth/registro');
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $tipo = $finfo->file($foto['tmp_name']);

            $tiposPermitidos = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp'
            ];

            if (!isset($tiposPermitidos[$tipo])) {
                $_SESSION['error'] = 'La foto debe ser JPG, PNG o WEBP.';
                $this->redirect('auth/registro');
            }

            $carpeta = PUBLIC_PATH . '/img/avatars/usuarios/';

            if (!is_dir($carpeta)) {
                if (!mkdir($carpeta, 0755, true)) {
                    $_SESSION['error'] = 'No se pudo crear la carpeta para guardar la foto.';
                    $this->redirect('auth/registro');
                }
            }

            $nombreArchivo = bin2hex(random_bytes(16))
                . '.'
                . $tiposPermitidos[$tipo];

            $rutaDestino = $carpeta . $nombreArchivo;

            if (!move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
                $_SESSION['error'] = 'No se pudo guardar la foto de perfil.';
                $this->redirect('auth/registro');
            }

            $fotoGuardada = $rutaDestino;

            $datos['avatar'] = 'usuarios/' . $nombreArchivo;
        }

        try {

            $registro = $this->usuario->registrar($datos);

            if (!$registro) {

                if (
                    $fotoGuardada !== null &&
                    file_exists($fotoGuardada)
                ) {
                    unlink($fotoGuardada);
                }

                $_SESSION['error'] = 'No fue posible crear la cuenta.';
                $this->redirect('auth/registro');
            }

            EmailService::enviarRegistro(
                $datos['correo'],
                $datos['nombre'],
                $datos['usuario']
            );

            $_SESSION['success'] = 'Cuenta creada correctamente. Se envió un correo de confirmación.';

            $this->redirect();

        } catch (PDOException $e) {

            if (
                $fotoGuardada !== null &&
                file_exists($fotoGuardada)
            ) {
                unlink($fotoGuardada);
            }

            $_SESSION['error'] = 'No fue posible crear la cuenta. Verifica que el documento, correo y usuario no estén registrados.';

            $this->redirect('auth/registro');
        }
    }

    public function recuperar(): void
    {
        $this->view('auth/recuperar');
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {

            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        $this->redirect();
    }
}
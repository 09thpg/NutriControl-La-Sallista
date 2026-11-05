<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Usuario.php';

class PerfilController extends Controller
{
    private Usuario $usuarioModel;

    public function __construct()
    {
        if (!isset($_SESSION['usuario'])) {
            $this->redirect();
        }

        $this->usuarioModel = new Usuario();
    }

    public function index(): void
    {
        $id = (int) $_SESSION['usuario']['id'];

        $usuario = $this->usuarioModel->obtenerPorId($id);

        if (!$usuario) {
            $_SESSION['error'] = 'No se pudo encontrar tu perfil.';
            $this->redirect('dashboard');
        }

        $this->view('perfil/index', [
            'usuario' => $usuario
        ]);
    }

    public function actualizar(): void
    {
        if (!$this->isPost()) {
            $this->redirect('perfil');
        }

        $id = (int) $_SESSION['usuario']['id'];

        $usuarioActual = $this->usuarioModel->obtenerPorId($id);

        if (!$usuarioActual) {
            $_SESSION['error'] = 'No se pudo encontrar tu perfil.';
            $this->redirect('dashboard');
        }

        $datos = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido' => trim($_POST['apellido'] ?? ''),
            'documento' => trim($_POST['documento'] ?? ''),
            'correo' => trim($_POST['correo'] ?? ''),
            'usuario' => trim($_POST['usuario'] ?? '')
        ];

        if (
            $datos['nombre'] === '' ||
            $datos['apellido'] === '' ||
            $datos['documento'] === '' ||
            $datos['correo'] === '' ||
            $datos['usuario'] === ''
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            $this->redirect('perfil');
        }

        if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'El correo electrónico no es válido.';
            $this->redirect('perfil');
        }

        if ($this->usuarioModel->existeDocumentoOtro(
            $datos['documento'],
            $id
        )) {
            $_SESSION['error'] = 'El documento ya pertenece a otro usuario.';
            $this->redirect('perfil');
        }

        if ($this->usuarioModel->existeUsuarioOtro(
            $datos['usuario'],
            $id
        )) {
            $_SESSION['error'] = 'El nombre de usuario ya pertenece a otra cuenta.';
            $this->redirect('perfil');
        }

        if ($this->usuarioModel->existeCorreoOtro(
            $datos['correo'],
            $id
        )) {
            $_SESSION['error'] = 'El correo ya pertenece a otra cuenta.';
            $this->redirect('perfil');
        }

        $avatar = $usuarioActual['avatar'] ?? 'avatar1.png';

        $avatarSeleccionado = trim($_POST['avatar'] ?? '');

        $avataresPermitidos = [
            'avatar1.png',
            'avatar2.png',
            'avatar3.png',
            'avatar4.png',
            'avatar5.png',
            'avatar6.png',
        ];

        if (
            $avatarSeleccionado !== '' &&
            in_array($avatarSeleccionado, $avataresPermitidos, true)
        ) {
            $avatar = $avatarSeleccionado;
        }

        $fotoNueva = false;

        if (
            isset($_FILES['foto_perfil']) &&
            $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE
        ) {
            $foto = $_FILES['foto_perfil'];

            if ($foto['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = 'No se pudo subir la foto.';
                $this->redirect('perfil');
            }

            if ($foto['size'] > 2 * 1024 * 1024) {
                $_SESSION['error'] = 'La foto no puede superar los 2 MB.';
                $this->redirect('perfil');
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
                $this->redirect('perfil');
            }

            $carpeta = PUBLIC_PATH . '/img/avatars/usuarios/';

            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0755, true);
            }

            $nombreArchivo = bin2hex(random_bytes(16))
                . '.'
                . $tiposPermitidos[$tipo];

            $rutaDestino = $carpeta . $nombreArchivo;

            if (!move_uploaded_file(
                $foto['tmp_name'],
                $rutaDestino
            )) {
                $_SESSION['error'] = 'No se pudo guardar la nueva foto.';
                $this->redirect('perfil');
            }

            $avatar = 'usuarios/' . $nombreArchivo;
            $fotoNueva = true;
        }

        $datos['avatar'] = $avatar;

        $passwordActual = $_POST['password_actual'] ?? '';
        $passwordNueva = $_POST['password_nueva'] ?? '';
        $confirmarPassword = $_POST['confirmar_password'] ?? '';

        if (
            $passwordActual !== '' ||
            $passwordNueva !== '' ||
            $confirmarPassword !== ''
        ) {
            if ($passwordActual === '') {
                $_SESSION['error'] = 'Debes escribir tu contraseña actual.';
                $this->redirect('perfil');
            }

            if (!password_verify(
                $passwordActual,
                $usuarioActual['password']
            )) {
                $_SESSION['error'] = 'La contraseña actual es incorrecta.';
                $this->redirect('perfil');
            }

            if ($passwordNueva === '') {
                $_SESSION['error'] = 'Debes escribir una nueva contraseña.';
                $this->redirect('perfil');
            }

            if (strlen($passwordNueva) < 6) {
                $_SESSION['error'] = 'La nueva contraseña debe tener mínimo 6 caracteres.';
                $this->redirect('perfil');
            }

            if ($passwordNueva !== $confirmarPassword) {
                $_SESSION['error'] = 'Las nuevas contraseñas no coinciden.';
                $this->redirect('perfil');
            }

            $datos['password'] = password_hash(
                $passwordNueva,
                PASSWORD_DEFAULT
            );
        }

        try {

            $actualizado = $this->usuarioModel->actualizarPerfil(
                $id,
                $datos
            );

            if (!$actualizado) {

                if (
                    $fotoNueva &&
                    str_starts_with($avatar, 'usuarios/')
                ) {
                    $archivoNuevo = PUBLIC_PATH
                        . '/img/avatars/'
                        . $avatar;

                    if (file_exists($archivoNuevo)) {
                        unlink($archivoNuevo);
                    }
                }

                $_SESSION['error'] = 'No fue posible actualizar tu perfil.';
                $this->redirect('perfil');
            }

            if (
                $fotoNueva &&
                isset($usuarioActual['avatar']) &&
                str_starts_with(
                    $usuarioActual['avatar'],
                    'usuarios/'
                )
            ) {
                $fotoAnterior = PUBLIC_PATH
                    . '/img/avatars/'
                    . $usuarioActual['avatar'];

                if (
                    file_exists($fotoAnterior) &&
                    $fotoAnterior !== $rutaDestino
                ) {
                    unlink($fotoAnterior);
                }
            }

            $_SESSION['usuario']['nombre'] = $datos['nombre'];
            $_SESSION['usuario']['apellido'] = $datos['apellido'];
            $_SESSION['usuario']['usuario'] = $datos['usuario'];
            $_SESSION['usuario']['correo'] = $datos['correo'];
            $_SESSION['usuario']['avatar'] = $datos['avatar'];

            $_SESSION['success'] = 'Tu perfil fue actualizado correctamente.';

            $this->redirect('perfil');

        } catch (PDOException $e) {

            if (
                $fotoNueva &&
                str_starts_with($avatar, 'usuarios/')
            ) {
                $archivoNuevo = PUBLIC_PATH
                    . '/img/avatars/'
                    . $avatar;

                if (file_exists($archivoNuevo)) {
                    unlink($archivoNuevo);
                }
            }

            $_SESSION['error'] = 'Ocurrió un error al actualizar tu perfil.';
            $this->redirect('perfil');
        }
    }
}
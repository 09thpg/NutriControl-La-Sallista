<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Usuario.php';

class EstudiantesController extends Controller
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
        $gradoSeleccionado = trim($_GET['grado'] ?? '');

        $gradosPermitidos = [
            '6A',
            '6B',
            '6C',
            '7A',
            '7B',
            '7C',
            '8A',
            '8B',
            '8C',
            '9A',
            '9B',
            '9C',
            '10A',
            '10B',
            '10C',
            '11A',
            '11B',
            '11C'
        ];

        if (
            $gradoSeleccionado !== '' &&
            in_array($gradoSeleccionado, $gradosPermitidos, true)
        ) {
            $estudiantes = $this->usuarioModel
                ->listarEstudiantesPorGrado($gradoSeleccionado);
        } else {
            $gradoSeleccionado = '';

            $estudiantes = $this->usuarioModel
                ->listarEstudiantes();
        }

        $this->view('estudiantes/listar', [
            'estudiantes' => $estudiantes,
            'gradoSeleccionado' => $gradoSeleccionado,
            'grados' => $gradosPermitidos,
            'usuario' => $_SESSION['usuario'],
            'esAdministrador' => $this->esAdministrador()
        ]);
    }

    public function ver(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = 'Estudiante no encontrado.';
            $this->redirect('estudiantes');
        }

        $estudiante = $this->usuarioModel->obtenerPorId($id);

        if (
            !$estudiante ||
            strtolower(trim($estudiante['rol'] ?? '')) !== 'estudiante'
        ) {
            $_SESSION['error'] = 'El estudiante no existe.';
            $this->redirect('estudiantes');
        }

        $this->view('estudiantes/ver', [
            'estudiante' => $estudiante,
            'usuario' => $_SESSION['usuario']
        ]);
    }

    public function editar(): void
    {
        $this->requiereAdministrador('estudiantes');

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = 'Estudiante no encontrado.';
            $this->redirect('estudiantes');
        }

        $estudiante = $this->usuarioModel->obtenerPorId($id);

        if (
            !$estudiante ||
            strtolower(trim($estudiante['rol'] ?? '')) !== 'estudiante'
        ) {
            $_SESSION['error'] = 'El estudiante no existe.';
            $this->redirect('estudiantes');
        }

        $grados = [
            '6A',
            '6B',
            '6C',
            '7A',
            '7B',
            '7C',
            '8A',
            '8B',
            '8C',
            '9A',
            '9B',
            '9C',
            '10A',
            '10B',
            '10C',
            '11A',
            '11B',
            '11C'
        ];

        $this->view('estudiantes/editar', [
            'estudiante' => $estudiante,
            'grados' => $grados,
            'usuario' => $_SESSION['usuario']
        ]);
    }

    public function actualizar(): void
    {
        $this->requiereAdministrador('estudiantes');

        if (!$this->isPost()) {
            $this->redirect('estudiantes');
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = 'Estudiante no encontrado.';
            $this->redirect('estudiantes');
        }

        $estudiante = $this->usuarioModel->obtenerPorId($id);

        if (
            !$estudiante ||
            strtolower(trim($estudiante['rol'] ?? '')) !== 'estudiante'
        ) {
            $_SESSION['error'] = 'El estudiante no existe.';
            $this->redirect('estudiantes');
        }

        $datos = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido' => trim($_POST['apellido'] ?? ''),
            'grado' => trim($_POST['grado'] ?? ''),
            'documento' => trim($_POST['documento'] ?? ''),
            'correo' => trim($_POST['correo'] ?? ''),
            'usuario' => trim($_POST['usuario'] ?? ''),
            'avatar' => $estudiante['avatar'] ?? 'avatar1.png'
        ];

        $password = $_POST['password'] ?? '';
        $confirmarPassword = $_POST['confirmar_password'] ?? '';

        if (
            $datos['nombre'] === '' ||
            $datos['apellido'] === '' ||
            $datos['grado'] === '' ||
            $datos['documento'] === '' ||
            $datos['correo'] === '' ||
            $datos['usuario'] === ''
        ) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            $this->redirect('estudiantes/editar?id=' . $id);
        }

        if (!filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'El correo electrónico no es válido.';
            $this->redirect('estudiantes/editar?id=' . $id);
        }

        $gradosPermitidos = [
            '6A',
            '6B',
            '6C',
            '7A',
            '7B',
            '7C',
            '8A',
            '8B',
            '8C',
            '9A',
            '9B',
            '9C',
            '10A',
            '10B',
            '10C',
            '11A',
            '11B',
            '11C'
        ];

        if (!in_array($datos['grado'], $gradosPermitidos, true)) {
            $_SESSION['error'] = 'El grado seleccionado no es válido.';
            $this->redirect('estudiantes/editar?id=' . $id);
        }

        if ($this->usuarioModel->existeDocumentoOtro($datos['documento'], $id)) {
            $_SESSION['error'] = 'El documento ya está registrado por otro usuario.';
            $this->redirect('estudiantes/editar?id=' . $id);
        }

        if ($this->usuarioModel->existeUsuarioOtro($datos['usuario'], $id)) {
            $_SESSION['error'] = 'El nombre de usuario ya está registrado.';
            $this->redirect('estudiantes/editar?id=' . $id);
        }

        if ($this->usuarioModel->existeCorreoOtro($datos['correo'], $id)) {
            $_SESSION['error'] = 'El correo ya está registrado por otro usuario.';
            $this->redirect('estudiantes/editar?id=' . $id);
        }

        if ($password !== '') {

            if ($password !== $confirmarPassword) {
                $_SESSION['error'] = 'Las contraseñas no coinciden.';
                $this->redirect('estudiantes/editar?id=' . $id);
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = 'La contraseña debe tener mínimo 6 caracteres.';
                $this->redirect('estudiantes/editar?id=' . $id);
            }

            $datos['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }

        if (
            isset($_FILES['foto_perfil']) &&
            $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE
        ) {
            $foto = $_FILES['foto_perfil'];

            if ($foto['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = 'No se pudo subir la foto de perfil.';
                $this->redirect('estudiantes/editar?id=' . $id);
            }

            if ($foto['size'] > 2 * 1024 * 1024) {
                $_SESSION['error'] = 'La foto no puede superar los 2 MB.';
                $this->redirect('estudiantes/editar?id=' . $id);
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
                $this->redirect('estudiantes/editar?id=' . $id);
            }

            $carpeta = PUBLIC_PATH . '/img/avatars/usuarios/';

            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0755, true);
            }

            $nombreArchivo =
                bin2hex(random_bytes(16)) .
                '.' .
                $tiposPermitidos[$tipo];

            $rutaDestino = $carpeta . $nombreArchivo;

            if (!move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
                $_SESSION['error'] = 'No se pudo guardar la foto de perfil.';
                $this->redirect('estudiantes/editar?id=' . $id);
            }

            $datos['avatar'] = 'usuarios/' . $nombreArchivo;
        }

        try {

            $actualizado = $this->usuarioModel->actualizarPerfil(
                $id,
                $datos
            );

            if (!$actualizado) {
                $_SESSION['error'] = 'No fue posible actualizar el estudiante.';
                $this->redirect('estudiantes/editar?id=' . $id);
            }

            if (
                isset($_SESSION['usuario']['id']) &&
                (int) $_SESSION['usuario']['id'] === $id
            ) {
                $_SESSION['usuario']['nombre'] = $datos['nombre'];
                $_SESSION['usuario']['apellido'] = $datos['apellido'];
                $_SESSION['usuario']['usuario'] = $datos['usuario'];
                $_SESSION['usuario']['correo'] = $datos['correo'];
                $_SESSION['usuario']['avatar'] = $datos['avatar'];
                $_SESSION['usuario']['grado'] = $datos['grado'];
            }

            $_SESSION['success'] = 'Estudiante actualizado correctamente.';

            $this->redirect(
                'estudiantes/ver?id=' . $id
            );

        } catch (PDOException $e) {

            $_SESSION['error'] =
                'No fue posible actualizar el estudiante.';

            $this->redirect(
                'estudiantes/editar?id=' . $id
            );
        }
    }
}
<?php

require_once APP_PATH . '/core/Controller.php';
require_once MODEL_PATH . '/Usuario.php';

class UsuariosController extends Controller
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
        $this->listar();
    }

    public function listar(): void
    {
        $usuarios = $this->usuarioModel->listar();

        $this->view('usuarios/listar', [
            'usuarios' => $usuarios,
            'esAdministrador' => $this->esAdministrador(),
            'esSuperAdministrador' => $this->esSuperAdministrador()
        ]);
    }

    public function crear(): void
    {
        $this->requiereAdministrador('usuarios');

        $this->view('usuarios/crear', [
            'esSuperAdministrador' => $this->esSuperAdministrador()
        ]);
    }

    public function guardar(): void
    {
        $this->requiereAdministrador('usuarios');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('usuarios');
            return;
        }

        $datos = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido' => trim($_POST['apellido'] ?? ''),
            'grado' => trim($_POST['grado'] ?? ''),
            'documento' => trim($_POST['documento'] ?? ''),
            'correo' => trim($_POST['correo'] ?? ''),
            'usuario' => trim($_POST['usuario'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'avatar' => $_POST['avatar'] ?? 'avatar1.png',
            'rol' => 'Supervisor'
        ];

        // Solo el Super Administrador puede asignar roles.
        if ($this->esSuperAdministrador()) {
            $rolSolicitado = trim($_POST['rol'] ?? 'Supervisor');
            $rolesPermitidos = [
                'Supervisor',
                'Administrador',
                'Super Administrador'
            ];

            if (in_array($rolSolicitado, $rolesPermitidos, true)) {
                $datos['rol'] = $rolSolicitado;
            }
        }

        $avataresPermitidos = [
            'avatar1.png',
            'avatar2.png',
            'avatar3.png',
            'avatar4.png',
            'avatar5.png',
            'avatar6.png'
        ];

        if (!in_array($datos['avatar'], $avataresPermitidos, true)) {
            $datos['avatar'] = 'avatar1.png';
        }

        if ($this->usuarioModel->existeUsuario($datos['usuario'])) {

            $_SESSION['error'] = 'El usuario ya existe.';

            $this->redirect('usuarios/crear');

            return;
        }

        if ($this->usuarioModel->existeCorreo($datos['correo'])) {

            $_SESSION['error'] = 'El correo ya está registrado.';

            $this->redirect('usuarios/crear');

            return;
        }

        if ($this->usuarioModel->registrar($datos)) {

            $_SESSION['success'] = 'Usuario registrado correctamente.';

        } else {

            $_SESSION['error'] = 'No fue posible registrar el usuario.';
        }

        $this->redirect('usuarios');
    }

    public function detalle(int $id): void
    {
        $usuario = $this->usuarioModel->obtenerPorId($id);

        if (!$usuario) {

            $this->redirect('usuarios');

            return;
        }

        $this->view('usuarios/detalle', [
            'usuario' => $usuario
        ]);
    }

    public function editar(int $id): void
    {
        $this->requiereAdministrador('usuarios');

        $usuario = $this->usuarioModel->obtenerPorId($id);

        if (!$usuario) {

            $this->redirect('usuarios');

            return;
        }

        $this->view('usuarios/editar', [
            'usuario' => $usuario,
            'esSuperAdministrador' => $this->esSuperAdministrador(),
            'puedeCambiarRol' => $this->esSuperAdministrador() && $id !== (int) $_SESSION['usuario']['id']
        ]);
    }

    public function actualizar(int $id): void
    {
        $this->requiereAdministrador('usuarios');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $this->redirect('usuarios');

            return;
        }

        $usuarioActualizado = $this->usuarioModel->obtenerPorId($id);

        if (!$usuarioActualizado) {
            $_SESSION['error'] = 'El usuario no existe.';
            $this->redirect('usuarios');
            return;
        }

        $datos = [
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido' => trim($_POST['apellido'] ?? ''),
            'documento' => trim($_POST['documento'] ?? ''),
            'correo' => trim($_POST['correo'] ?? ''),
            'usuario' => trim($_POST['usuario'] ?? ''),
            // El avatar de otro usuario no se puede modificar desde Editar Usuario.
            // Se conserva exactamente el avatar que ya tiene la cuenta.
            'avatar' => $usuarioActualizado['avatar'] ?? 'avatar1.png'
        ];

        $actualizado = $this->usuarioModel->actualizar($id, $datos);

        // El rol solo puede ser modificado por un Super Administrador y nunca
        // sobre su propia cuenta.
        if ($actualizado && $this->esSuperAdministrador() && $id !== (int) $_SESSION['usuario']['id']) {
            $rol = trim($_POST['rol'] ?? $usuarioActualizado['rol']);
            $rolesPermitidos = [
                'Supervisor',
                'Administrador',
                'Super Administrador'
            ];

            if (in_array($rol, $rolesPermitidos, true)) {
                $actualizado = $this->usuarioModel->actualizarRol($id, $rol);
            }
        }

        if ($actualizado) {
            $_SESSION['success'] = 'Usuario actualizado correctamente.';
        } else {
            $_SESSION['error'] = 'No fue posible actualizar el usuario.';
        }

        $this->redirect('usuarios');
    }

    public function eliminar(int $id): void
    {
        $this->requiereSuperAdministrador('usuarios');

        if ($this->usuarioModel->eliminar($id)) {

            $_SESSION['success'] = 'Usuario eliminado correctamente.';

        } else {

            $_SESSION['error'] = 'No fue posible eliminar el usuario.';
        }

        $this->redirect('usuarios');
    }
}
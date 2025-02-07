<?php

class Autenticacion
{
    private ?Usuario $usuario = null;

    public function iniciarSesion(string $email, string $password): bool
    {
        $usuario = (new Usuario)->porEmail($email);

        // Verifica si el usuario existe y si la contraseña es correcta
        if (!$usuario || !password_verify($password, $usuario->getPassword())) {
            return false;
        }

        $_SESSION['id'] = $usuario->getUsuarioId();
        return true;
    }

    public function cerrarSesion(): void
    {
        // Elimina la sesión y destruye la sesión actual
        unset($_SESSION['id']);
        session_destroy();
    }

    public function estaAutenticado(): bool
    {
        return isset($_SESSION['id']);
    }

    public function getUsuario(): ?Usuario
    {
        if (!$this->estaAutenticado()) return null;

        if ($this->usuario === null) {
            $this->usuario = (new Usuario)->porId($_SESSION['id']);
        }

        return $this->usuario;
    }

    public function obtenerUsuarioId(): ?int
    {
        $usuario = $this->getUsuario();
        return $usuario ? $usuario->getUsuarioId() : null;
    }
}

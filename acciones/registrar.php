<?php
session_start();
require_once __DIR__ . '/../bootstrap/autoload.php';
$errores = [];
$dataVieja = $_POST;

// Validar campos del formulario
if (empty($dataVieja['email'])) {
    $errores['email'] = "El correo electrónico es obligatorio.";
}

if (empty($dataVieja['password'])) {
    $errores['password'] = "La contraseña es obligatoria.";
}

// Si hay errores, guardar datos antiguos y redirigir de vuelta al formulario
if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    $_SESSION['data-vieja'] = $dataVieja;
    header('Location: ../index.php?seccion=registro'); // Redirige al formulario
    exit;
}

// Verificar si el usuario ya existe
$usuario = new Usuario();
$usuarioExistente = $usuario->porEmail($dataVieja['email']);

if ($usuarioExistente) {
    $errores['email'] = "El correo electrónico ya está registrado.";
    $_SESSION['errores'] = $errores;
    $_SESSION['data-vieja'] = $dataVieja;
    header('Location: ../index.php?seccion=registro'); // Redirige al formulario
    exit;
}

// Procesar la inserción del nuevo usuario
$hashedPassword = password_hash($dataVieja['password'], PASSWORD_DEFAULT);
$db = (new Conexion)->obtenerConexion();
$query = "INSERT INTO usuarios (rol_fk, email, password, alias) VALUES (?, ?, ?, ?)";
$stmt = $db->prepare($query);

$rol_fk = 2; // Ejemplo de rol por defecto

if ($stmt->execute([$rol_fk, $dataVieja['email'], $hashedPassword, $dataVieja['alias']])) {
    $_SESSION['mensaje'] = "Usuario registrado exitosamente.";
} else {
    $_SESSION['errores']['general'] = "Error al registrar el usuario.";
}

header('Location: ../index.php'); // Redirige al formulario
exit;


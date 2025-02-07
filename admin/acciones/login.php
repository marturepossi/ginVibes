<?php
require_once __DIR__ . '/../../bootstrap/autoload.php';
session_start();

$email      = $_POST['email'];
$password   = $_POST['password'];

$auth = new Autenticacion;

if($auth->iniciarSesion($email, $password)) {
    $_SESSION['feedback-mensaje'] = "Sesión iniciada con éxito. ¡Hola de nuevo!";
    $_SESSION['feedback-tipo'] = "success";

    header("Location: ../index.php?seccion=dashboard");
    exit;
} else {
    $_SESSION['feedback-mensaje'] = "Las credenciales ingresadas no coinciden con nuestros registros.";
    $_SESSION['feedback-tipo'] = "error";
    $_SESSION['data-vieja'] = $_POST;

    header("Location: ../index.php?seccion=iniciar-sesion");
    exit;
}
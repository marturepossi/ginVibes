<?php
// Asegúrate de que se inicia la sesión antes de interactuar con $_SESSION
require_once __DIR__ . '/../bootstrap/autoload.php'; // Ajusta la ruta según tu estructura
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Verifica si los datos del formulario están establecidos
if (empty($_POST['email']) || empty($_POST['password'])) {
    $_SESSION['feedback-mensaje'] = "Por favor, complete todos los campos.";
    $_SESSION['feedback-tipo'] = "error";
    header("Location: ../index.php?seccion=inicio-sesion");
    exit;
}

$auth = new Autenticacion();


if ($auth->iniciarSesion($email, $password)) {
    $_SESSION['feedback-mensaje'] = "Sesión iniciada con éxito. ¡Hola de nuevo!";
    $_SESSION['feedback-tipo'] = "success";
    header("Location: ../index.php"); 
    exit;
} else {
    $_SESSION['feedback-mensaje'] = "Las credenciales ingresadas no coinciden con nuestros registros.";
    $_SESSION['feedback-tipo'] = "error";
    $_SESSION['data-vieja'] = $_POST; // Mantiene datos viejos
    header("Location: ../index.php?seccion=inicio-sesion");
    exit;
}
?>

<?php
require_once __DIR__ . '/../../bootstrap/autoload.php';

session_start();

$auth = new Autenticacion;
$auth->cerrarSesion();

$_SESSION['feedback-mensaje'] = "Sesión cerrada con éxito. ¡Te esperamos pronto de nuevo!";
$_SESSION['feedback-tipo'] = "success";

header("Location: ../index.php?seccion=iniciar-sesion");
exit;
<?php

$nombre = $_POST['nombre'];
$consulta = $_POST['consulta'];

echo "Enviado email...";

header('Location: ../index.php?seccion=consulta-exitosa');

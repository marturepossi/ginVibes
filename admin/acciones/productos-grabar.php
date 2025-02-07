<?php
require_once __DIR__ . '/../../bootstrap/autoload.php';
session_start();

// Verifica que el usuario esté autenticado
$auth = new Autenticacion;
if (!$auth->estaAutenticado()) {
    $_SESSION['feedback-mensaje'] = "No se puede realizar esta acción sin haber iniciado sesión.";
    $_SESSION['feedback-tipo'] = "error";
    header("Location: ../index.php?seccion=iniciar-sesion");
    exit;
}

// Captura de los datos del formulario
$nombre                     = $_POST['nombre'];
$detalle                    = $_POST['detalle'];
$descripcion                = $_POST['descripcion'];
$estado_producto_fk         = $_POST['estado_producto_fk'];
$imagen_descripcion         = $_POST['imagen_descripcion'];
$etiquetas_fk               = $_POST['etiqueta_fk'] ?? [];
$imagen                     = $_FILES['imagen'];
$precio                     = $_POST['precio'];

$errores = [];

// Validación de campos
if (empty($nombre)) {
    $errores['nombre'] = "El título debe tener un valor.";
} else if (strlen($nombre) < 3) {
    $errores['nombre'] = "El título debe tener al menos 3 caracteres.";
}

if (empty($detalle)) {
    $errores['detalle'] = "Debe tener un detalle.";
}

if (empty($descripcion)) {
    $errores['descripcion'] = "La descripción debe tener un valor.";
}

if (count($errores) > 0) {
    $_SESSION['feedback-mensaje'] = "Algunos de los datos del formulario no cumplen con lo requerido. Por favor, corregí los errores y probá de nuevo.";
    $_SESSION['feedback-tipo'] = "error";
    $_SESSION['errores'] = $errores;
    $_SESSION['data-vieja'] = $_POST;
    header('Location: ../index.php?seccion=productos-nuevo');
    exit;
}

// Manejo del archivo de imagen
$nombreImagen = null;
if (!empty($imagen['tmp_name']) && $imagen['error'] === UPLOAD_ERR_OK) {
    $nombreImagen = date('Ymd_His_') . basename($imagen['name']);
    
    // Verifica el tamaño y tipo del archivo si es necesario
    if ($imagen['size'] > 0 && in_array(mime_content_type($imagen['tmp_name']), ['image/jpeg', 'image/png', 'image/gif'])) {
        if (!move_uploaded_file($imagen['tmp_name'], __DIR__ . '/../../imgs/' . $nombreImagen)) {
            $_SESSION['feedback-mensaje'] = "Error al subir la imagen.";
            $_SESSION['feedback-tipo'] = "error";
            $_SESSION['data-vieja'] = $_POST;
            header('Location: ../index.php?seccion=productos-nuevo');
            exit;
        }
    } else {
        $_SESSION['feedback-mensaje'] = "El archivo subido no es una imagen válida o es demasiado grande.";
        $_SESSION['feedback-tipo'] = "error";
        $_SESSION['data-vieja'] = $_POST;
        header('Location: ../index.php?seccion=productos-nuevo');
        exit;
    }
}

try {
    // Graba el producto en la base de datos
    (new Producto)->crear([
        'usuario_fk' => 1, // TODO: Ajustar según usuario autenticado
        'fecha_publicacion' => date('Y-m-d H:i:s'),
        'estado_producto_fk' => $estado_producto_fk,
        'nombre' => $nombre,
        'detalle' => $detalle,
        'descripcion' => $descripcion,
        'imagen' => $nombreImagen,
        'imagen_descripcion' => $imagen_descripcion,
        'etiquetas_fk' => $etiquetas_fk,
        'precio' => $precio,
    ]);
    $_SESSION['feedback-mensaje'] = "El producto se publicó con éxito.";
    $_SESSION['feedback-tipo'] = "success";
    header('Location: ../index.php?seccion=productos');
    exit;
} catch (Exception $e) {
    $_SESSION['feedback-mensaje'] = "Ocurrió un error inesperado al tratar de agregar el producto. Detalles: " . $e->getMessage();
    $_SESSION['feedback-tipo'] = "error";
    $_SESSION['data-vieja'] = $_POST;
    header('Location: ../index.php?seccion=productos-nuevo');
    exit;
}

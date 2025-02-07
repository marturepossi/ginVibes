<section id="inicio" class=" container my-5">
    <?php

    $nombre = $_GET['nombre'];
    $apellido = $_GET['apellido'];
    $email = $_GET['email'];
    $telefono = $_GET['telefono'];
    echo "<div>
    <h3>¡Hola " . $nombre . "! </h3> 
    <br> Gracias por tu participación en nuestro sorteo de la botella de Gin Edición Nocturna.</br>

    <br> Hemos recibido la siguiente información: </br>
                
    <br> <strong> Nombre completo:</strong> " . $nombre . " " . $apellido ."</br>
    <br> <strong> Mail: </strong> " . $email ."</br>
    <br> <strong>Telefono: </strong>" . $telefono ."</br>
    <br>Tu participación ha sido registrada correctamente. Te mantendremos informado sobre el resultado del sorteo, que se anunciará el 03/07/2024.</br>

    <br>¡Mucha suerte y gracias por unirte a nosotros en esta experiencia nocturna llena de sabor!</br>
    <br>  </br>
    </div>"

    ?>
    
    <div class="mt-10">
        <strong>
        <a href="index.php?seccion=home" class="btn btn-primary">Volver al inicio</a>
        </strong>
    </div>
        
</section>
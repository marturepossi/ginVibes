<section class="container">
    <h1 class="mb-1">Ingresar al Panel de Administración</h1>
    <form action="acciones/login.php" method="post">
        <div class="form-fila">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="form-fila">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        <button type="submit" class="button">Ingresar</button>
        <div class="mb-1"><a href="../index.php?seccion=home" >Volver a la vista prinicipal</a></div>
    </form>
</section>

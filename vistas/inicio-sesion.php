<section class="container-fluid my-5">
    <h1 class="mb-1">Iniciar Sesion</h1>

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
        <div class="mb-1"><a href="index.php?seccion=registro" >No tengo cuenta. Registrarme.</a></div>
    </form>
</section>
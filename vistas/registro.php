<?php
$errores = $_SESSION['errores'] ?? [];
unset($_SESSION['errores']);
$dataVieja = $_SESSION['data-vieja'] ?? [];
unset($_SESSION['data-vieja']);
?>


    <section class="container">
        <h1 class="mb-1">Registrarme!</h1>
        <form action="acciones/registrar.php" method="post" enctype="multipart/form-data">
            <div class="form-fila">
                <label for="email">Mail:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="<?= $dataVieja['email'] ?? ''; ?>"
                    aria-describedby="help-email error-email"
                >
                <div id="error-email">
                    <?php if (isset($errores['email'])): ?>
                        <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['email']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-fila">
                <label for="password">Contraseña:</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    value="<?= $dataVieja['password'] ?? ''; ?>"
                    aria-describedby="help-password error-password"
                >
                <div id="error-password">
                    <?php if (isset($errores['password'])): ?>
                        <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['password']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-fila">
                <label for="alias">Nombre de usuario:</label>
                <textarea
                    id="alias"
                    name="alias"
                    class="form-control"
                    aria-describedby="error-alias"
                ><?= $dataVieja['alias'] ?? ''; ?></textarea>
                <div id="error-alias">
                    <?php if (isset($errores['alias'])): ?>
                        <div class="msg-error"><span class="visually-hidden">Error: </span><?= $errores['alias']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <button type="submit" class="button">Registrar</button>
        </form>
    </section>


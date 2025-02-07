<?php
$usuarios = (new Usuario)->obtenerTodosUsuarios();
?>

    <section class="container">
            <h1>Listado de Usuarios</h1>
            <?php if ($usuarios): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Alias</th>
                            <th>Pedidos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= $usuario->getUsuarioId(); ?></td>
                                <td><?= $usuario->getEmail(); ?></td>
                                <td><?= $usuario->getAlias(); ?></td>
                                <td><a href="index.php?seccion=pedidos-usuario&usuario_id=<?= $usuario->getUsuarioId(); ?>">Ver pedidos</a></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay usuarios registrados.</p>
            <?php endif; ?>
        </section>
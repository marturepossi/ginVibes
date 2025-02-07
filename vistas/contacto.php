
<section id="productos" class="container-fluid my-5">
    <div class="container my-5 mt-1 ">
        <div class="row">
            <div class="col-md-12 col-xl-4 d-flex justify-content-md-center">
                <figure class="img-fluid">
                    <picture>
                        <source class="rounded" media="(max-width: 767px)" srcset="imgs/mbotellasProductos.png">
                        <source class="rounded" media="(min-width: 768px)" srcset="imgs/tbotellasProductos.png">
                        <source class="rounded" media="(min-width: 1200px)" srcset="imgs/botellasProductos.png">
                        <img src="imgs/mbotellasProductos.png" class="d-block w-100 rounded" alt="Botellas de Gin Vibes">
                    </picture>
                </figure>
            </div>
            <div class="col-md-12 col-xl-8">
                <h2 class="text-left">Sorteo de Botella de Gin Edición Nocturna!</h2>
                <p>¡Gracias por participar en nuestro emocionante sorteo! Por favor, completa la siguiente información para tener la oportunidad de ganar una botella de nuestro exclusivo gin edición nocturna:</p>
                <form class="row g-3" action="index.php?seccion=respuesta-mail" method="get">
                    <input type="hidden" name="seccion" value="respuesta-mail">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">
                    </div>
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">Apellido: </label>
                        <input type="text" class="form-control" name="apellido" id="apellido" placeholder="Apellido">
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="nombre@mail.com">
                    </div>
                    <div class="col-12">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="tel" class="form-control" name="telefono" id="telefono" placeholder="Numero de telefono o celular">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn button">ENVIAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
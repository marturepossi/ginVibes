<?php

class Producto
{
    protected int $producto_id;
    protected int $usuario_fk;
    protected int $estado_producto_fk;
    protected string $fecha_publicacion;
    protected string $nombre;
    protected string $detalle;
    protected string $descripcion;
    protected ?string $imagen = null;
    protected ?string $imagen_descripcion = null;
    protected int $precio;
    protected string $estado_producto_nombre;
    protected EstadoProducto $estado_producto;

    protected array $etiquetas = [];

    public function asignarDatos(array $data): void 
    {
        $this->producto_id = $data['producto_id'];
        $this->usuario_fk = $data['usuario_fk'];
        $this->estado_producto_fk = $data['estado_producto_fk'];
        $this->fecha_publicacion = $data['fecha_publicacion'];
        $this->nombre = $data['nombre'];
        $this->detalle = $data['detalle'];
        $this->descripcion = $data['descripcion'];
        $this->imagen = $data['imagen'];
        $this->imagen_descripcion = $data['imagen_descripcion'];
        $this->precio = $data['precio'];

    }

    public function todas(): array
    {
        $db = (new Conexion)->obtenerConexion();

        $consulta = "SELECT 
                        n.*, 
                        ep.nombre AS 'estado_producto_nombre' 
                    FROM 
                        productos n
                    INNER JOIN
                        estados_producto	ep
                    ON n.estado_producto_fk = ep.estado_producto_id
                    ORDER BY n.fecha_publicacion DESC";
        $stmt = $db->prepare($consulta);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);

        return $stmt->fetchAll();
    }


    public function todasV2(): array
    {
        $db = (new Conexion)->obtenerConexion();
        $consulta = "SELECT 
                        n.*, 
                        ep.nombre AS 'estado_producto_nombre', 
                        GROUP_CONCAT(e.etiqueta_id SEPARATOR ' | ') AS 'etiquetas_id',
                        GROUP_CONCAT(e.nombre SEPARATOR ' | ') AS 'etiquetas_nombre'
                    FROM 
                        productos n
                    INNER JOIN
                        estados_producto	ep
                        ON n.estado_producto_fk = ep.estado_producto_id
                    LEFT JOIN productos_tienen_etiquetas nte
                        ON n.producto_id = nte.producto_fk
                    LEFT JOIN etiquetas e
                        ON e.etiqueta_id = nte.etiqueta_fk
                    GROUP BY n.producto_id
                    ORDER BY n.fecha_publicacion DESC;";
        $stmt = $db->prepare($consulta);
        $stmt->execute();
        $productosArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $productos = [];

        foreach($productosArray as $productoData) {
            $producto = new self;
            $producto->asignarDatos($productoData);
            $estadoProducto = new EstadoProducto;
            $estadoProducto->setEstadoProductoId($productoData['estado_producto_fk']);
            $estadoProducto->setNombre($productoData['estado_producto_nombre']);
            $producto->setEstadoProducto($estadoProducto);

            if($productoData['etiquetas_id'] != null) {
                $etiquetasId = explode(' | ', $productoData['etiquetas_id']);
                $etiquetasNombre = explode(' | ', $productoData['etiquetas_nombre']);
                
                $etiquetas = [];
                foreach($etiquetasId as $etiquetaKey => $etiquetaValue) {
                    $etiqueta = new Etiqueta;
                    $etiqueta->setEtiquetaId((int) $etiquetasId[$etiquetaKey]);
                    $etiqueta->setNombre($etiquetasNombre[$etiquetaKey]);

                    $etiquetas[] = $etiqueta;
                }
                $producto->setEtiquetas($etiquetas);
            }

            $productos[] = $producto;
        }

        return $productos;
    }

    public function porId(int $id, bool $conRelaciones = false): ?self
    {
       
        $db = (new Conexion)->obtenerConexion();
        $consulta = "SELECT * FROM productos
                    WHERE producto_id = ?";
        $stmt = $db->prepare($consulta);
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $producto = $stmt->fetch();

        if(!$producto) {
            return null;
        }

        if($conRelaciones) {
            $producto->cargarRelaciones();
        }

        return $producto;
    }

    public function cargarRelaciones(): void
    {
        $db = (new Conexion)->obtenerConexion();
        $consulta = "SELECT e.* FROM etiquetas e
                    INNER JOIN productos_tienen_etiquetas nte
                        ON e.etiqueta_id = nte.etiqueta_fk
                    WHERE nte.producto_fk = ?";
        $stmt = $db->prepare($consulta);
        $stmt->execute([$this->producto_id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Etiqueta::class);
        $this->setEtiquetas($stmt->fetchAll());
    }

    public function crear(array $data)
    {
        $db = (new Conexion)->obtenerConexion();
        $consulta = "INSERT INTO productos (usuario_fk, estado_producto_fk, nombre, detalle, descripcion, imagen, imagen_descripcion, fecha_publicacion,precio)
                    VALUES (:usuario_fk, :estado_producto_fk, :nombre, :detalle, :descripcion, :imagen, :imagen_descripcion, :fecha_publicacion, :precio)";
        $stmt = $db->prepare($consulta);
        $stmt->execute([
            'usuario_fk'            => $data['usuario_fk'],
            'estado_producto_fk' => $data['estado_producto_fk'],
            'nombre'                => $data['nombre'],
            'detalle'              => $data['detalle'],
            'descripcion'                => $data['descripcion'],
            'imagen'                => $data['imagen'],
            'imagen_descripcion'    => $data['imagen_descripcion'],
            'fecha_publicacion'     => $data['fecha_publicacion'],
            'precio'                => $data['precio'],
        ]);

        $productoId = $db->lastInsertId();
        $this->agregarEtiquetas($productoId, $data['etiquetas_fk']);
    }

    public function agregarEtiquetas(int $productoId, array $etiquetasFk)
    {

        if(count($etiquetasFk) > 0) {
            $paresInsercion = [];
            $valoresInsercion = [];

            foreach($etiquetasFk as $etiquetaFk) {
                $paresInsercion[] = "(?, ?)";
                $valoresInsercion[] = $productoId;
                $valoresInsercion[] = $etiquetaFk;
            }

            $db = (new Conexion)->obtenerConexion();
            $consulta = "INSERT INTO productos_tienen_etiquetas (producto_fk, etiqueta_fk)
                        VALUES " . implode(', ', $paresInsercion);
            $stmt = $db->prepare($consulta);
            $stmt->execute($valoresInsercion);
        }
    }

    public function quitarEtiquetas(int $productoId): void
    {
        $db = (new Conexion)->obtenerConexion();
        $consulta = "DELETE FROM productos_tienen_etiquetas
                    WHERE producto_fk = ?";
        $stmt = $db->prepare($consulta);
        $stmt->execute([$productoId]);
    }

    public function editar(int $pk, array $data): void
    {
        $db = (new Conexion)->obtenerConexion();
        $consulta = "UPDATE productos
                    SET estado_producto_fk   = :estado_producto_fk,
                        nombre                  = :nombre,
                        detalle                 = :detalle,
                        descripcion             = :descripcion,
                        imagen                  = :imagen,
                        imagen_descripcion      = :imagen_descripcion,
                        precio                  = :precio
                    WHERE producto_id = :producto_id";
        $stmt = $db->prepare($consulta);
        $stmt->execute([
            'estado_producto_fk' => $data['estado_producto_fk'],
            'nombre'                => $data['nombre'],
            'detalle'               => $data['detalle'],
            'descripcion'           => $data['descripcion'],
            'imagen'                => $data['imagen'],
            'imagen_descripcion'    => $data['imagen_descripcion'],
            'precio'                => $data['precio'],
            'producto_id'           => $pk, // Este no sale de $data, sino del parámetro especial para la PK.
        ]);
        $this->quitarEtiquetas($pk);
        $this->agregarEtiquetas($pk, $data['etiquetas_fk']);
    }

    public function eliminar(int $pk): bool
    {
        $this->quitarEtiquetas($pk);

        $db = (new Conexion)->obtenerConexion();
        $consulta = "DELETE FROM productos
                    WHERE producto_id = ?";
        $stmt = $db->prepare($consulta);
        $stmt->execute([$pk]);
        return true;
    }

    public function getProductoId(): int
    {
        return $this->producto_id;
    }

    public function setProductoId(int $producto_id): void
    {
        $this->producto_id = $producto_id;
    }

    public function getUsuarioFk()
    {
        return $this->usuario_fk;
    }
 
    public function setUsuarioFk($usuario_fk)
    {
        $this->usuario_fk = $usuario_fk;
    }

    public function getEstadoProductoFk()
    {
        return $this->estado_producto_fk;
    }

    public function setEstadoProductoFk($estado_producto_fk)
    {
        $this->estado_producto_fk = $estado_producto_fk;
    }

    public function getFechaPublicacion()
    {
        return $this->fecha_publicacion;
    }


    public function setFechaPublicacion($fecha_publicacion)
    {
        $this->fecha_publicacion = $fecha_publicacion;
    }

 
    public function getNombre(): string
    {
        return $this->nombre;
    }

 
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    
    public function getDetalle(): string
    {
        return $this->detalle;
    }

    
    public function setDetalle(string $detalle): void
    {
        $this->detalle = $detalle;
    }

    
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

     
    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    
    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    
    public function setImagen(?string $imagen): void
    {
        $this->imagen = $imagen;
    }

    
    public function getImagenDescripcion(): ?string
    {
        return $this->imagen_descripcion;
    }

    
    public function setImagenDescripcion(?string $imagen_descripcion): void
    {
        $this->imagen_descripcion = $imagen_descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    
    public function getEstadoProducto(): EstadoProducto
    {
        return $this->estado_producto;
    }

    
    public function setEstadoProducto(EstadoProducto $estadoProducto)
    {
        $this->estado_producto = $estadoProducto;
    }

    
    public function getEtiquetas(): array
    {
        return $this->etiquetas;
    }


    public function setEtiquetas(array $etiquetas)
    {
        $this->etiquetas = $etiquetas;
    }
}
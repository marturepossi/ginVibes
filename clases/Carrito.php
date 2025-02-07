<?php

class Carrito
{
    protected int $carrito_id;
    protected int $usuario_fk;
    protected int $producto_fk;
    protected int $cantidad;
   
    public static function cargarCarrito(int $usuarioId): array
{
    $db = (new Conexion)->obtenerConexion();
    // Junto por producto y sumo las cantidades
    $consulta = "
        SELECT c.producto_fk, p.nombre AS producto_nombre, p.precio AS producto_precio, 
               SUM(c.cantidad) AS cantidad_total
        FROM carrito c
        JOIN productos p ON c.producto_fk = p.producto_id
        WHERE c.usuario_fk = ?
        GROUP BY c.producto_fk, p.nombre, p.precio";
    $stmt = $db->prepare($consulta);
    $stmt->execute([$usuarioId]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
}


    public static function agregarItem(int $usuarioId, int $productoId, int $cantidad): void
    {
        $db = (new Conexion)->obtenerConexion();
        $consulta = "INSERT INTO carrito (usuario_fk, producto_fk, cantidad) VALUES (?, ?, ?)";
        $stmt = $db->prepare($consulta);
        $stmt->execute([$usuarioId, $productoId, $cantidad]);
    }

    public function getCarritoId(): int
    {
        return $this->carrito_id;
    }

    
    public function setCarritoId(int $carrito_id): void
    {
        $this->carrito_id = $carrito_id;
    }

    
    public function getUsuarioFk(): int
    {
        return $this->usuario_fk;
    }

    
    public function setUsuarioFk(int $usuario_fk): void
    {
        $this->usuario_fk = $usuario_fk;
    }

    
    public function getProductoFk(): int
    {
        return $this->producto_fk;
    }

    
    public function setProductoFk(int $producto_fk): void
    {
        $this->producto_fk = $producto_fk;
    }

    
    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    
    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    
    public function getFechaAgregado(): string
    {
        return $this->fecha_agregado;
    }

    
    public function setFechaAgregado(string $fecha_agregado): void
    {
        $this->fecha_agregado = $fecha_agregado;
    }
}

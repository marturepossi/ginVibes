<?php

class DetallePedido
{
    protected int $detalle_id;
    protected int $pedido_fk;
    protected int $producto_fk;
    protected string $nombre;
    protected int $cantidad;
    protected float $precio;

    //Detalles por ID de pedido
    public function porPedidoId(int $pedidoId): array
    {
        $db = (new Conexion)->obtenerConexion();

        $consulta = "SELECT * FROM pedido_detalles WHERE pedido_fk = ?";
        $stmt = $db->prepare($consulta);
        $stmt->execute([$pedidoId]);
        $detallesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $detalles = [];
        foreach ($detallesArray as $detalleData) {
            $detalle = new self;
            $detalle->setDetalleId($detalleData['detalle_id']);
            $detalle->setPedidoFk($detalleData['pedido_fk']);
            $detalle->setProductoFk($detalleData['producto_fk']);
            $detalle->setNombre($detalleData['nombre']);
            $detalle->setCantidad($detalleData['cantidad']);
            $detalle->setPrecio($detalleData['precio']);
            $detalles[] = $detalle;
        }

        return $detalles;
    }

    public function getDetalleId(): int
    {
        return $this->detalle_id;
    }

    public function setDetalleId(int $detalle_id): void
    {
        $this->detalle_id = $detalle_id;
    }

    public function getPedidoFk(): int
    {
        return $this->pedido_fk;
    }

    public function setPedidoFk(int $pedido_fk): void
    {
        $this->pedido_fk = $pedido_fk;
    }

    public function getProductoFk(): int
    {
        return $this->producto_fk;
    }

    public function setProductoFk(int $producto_fk): void
    {
        $this->producto_fk = $producto_fk;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }
}


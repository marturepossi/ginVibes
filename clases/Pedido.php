<?php

class Pedido
{
    protected int $pedido_id;
    protected int $usuario_fk;
    protected float $total;
    protected string $fecha;

    // Pedidos por usuario
    public function obtenerPedidosPorUsuario(int $usuarioId): array
    {
        $db = (new Conexion)->obtenerConexion();

        $consulta = "SELECT pedido_id, usuario_fk, total, fecha FROM pedidos WHERE usuario_fk = ?";
        $stmt = $db->prepare($consulta);
        $stmt->execute([$usuarioId]);
        $pedidosArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pedidos = [];
        foreach ($pedidosArray as $pedidoData) {
            $pedido = new self;
            $pedido->setPedidoId($pedidoData['pedido_id']);
            $pedido->setUsuarioFk($pedidoData['usuario_fk']);
            $pedido->setTotal($pedidoData['total']);
            $pedido->setFecha($pedidoData['fecha']);
            $pedidos[] = $pedido;
        }

        return $pedidos;
    }

    // Pedido por ID
    public function porId(int $id): ?self
    {
        $db = (new Conexion)->obtenerConexion();

        $consulta = "SELECT * FROM pedidos WHERE pedido_id = ?";
        $stmt = $db->prepare($consulta);
        $stmt->execute([$id]);
        $pedidoData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$pedidoData) return null;

        $pedido = new self;
        $pedido->setPedidoId($pedidoData['pedido_id']);
        $pedido->setUsuarioFk($pedidoData['usuario_fk']);
        $pedido->setTotal($pedidoData['total']);
        $pedido->setFecha($pedidoData['fecha']);

        return $pedido;
    }

    public function getPedidoId(): int
    {
        return $this->pedido_id;
    }

    public function setPedidoId(int $pedido_id): void
    {
        $this->pedido_id = $pedido_id;
    }

    public function getUsuarioFk(): int
    {
        return $this->usuario_fk;
    }

    public function setUsuarioFk(int $usuario_fk): void
    {
        $this->usuario_fk = $usuario_fk;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }
}

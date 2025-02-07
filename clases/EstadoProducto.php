<?php

class EstadoProducto
{
    protected int $estado_producto_id;
    protected string $nombre;

    
    public function todos(): array
    {
        $db = (new Conexion)->obtenerConexion();
        $consulta = "SELECT * FROM estados_producto";
        $stmt = $db->prepare($consulta);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetchAll();
    }

    
    public function getEstadoProductoId()
    {
        return $this->estado_producto_id;
    }

    
    public function setEstadoProductoId($estado_producto_id)
    {
        $this->estado_producto_id = $estado_producto_id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
}
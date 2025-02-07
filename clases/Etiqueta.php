<?php

class Etiqueta
{
    protected int $etiqueta_id;
    protected string $nombre;

    public function todas(): array
    {
        $db = (new Conexion)->obtenerConexion();
        $consulta = "SELECT * FROM etiquetas";
        $stmt = $db->prepare($consulta);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);

        return $stmt->fetchAll();
    }

    public function getEtiquetaId(): int
    {
        return $this->etiqueta_id;
    }

    
    public function setEtiquetaId(int $etiqueta_id): void
    {
        $this->etiqueta_id = $etiqueta_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
}
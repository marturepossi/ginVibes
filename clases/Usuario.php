<?php

class Usuario
{
    protected int $usuario_id;
    protected int $rol_fk;
    protected string $email;
    protected string $password;
    protected ?string $alias = null;

    public function porId(int $id): ?self
    {
        $db = (new Conexion)->obtenerConexion();

        $query = "SELECT * FROM usuarios WHERE usuario_id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $usuario = $stmt->fetch();

        if(!$usuario) return null;

        return $usuario;
    }

    public function porEmail(string $email): ?self
    {
        $db = (new Conexion)->obtenerConexion();

        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $usuario = $stmt->fetch();

        if(!$usuario) {
            return null;
        }

        return $usuario;
    }

    public function obtenerTodosUsuarios(): array
    {
        $db = (new Conexion)->obtenerConexion();

        $consulta = "SELECT usuario_id, email, alias FROM usuarios";

        try {
            $stmt = $db->prepare($consulta);
            $stmt->execute();
            $usuariosArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $usuarios = [];
            foreach($usuariosArray as $usuarioData) {
                $usuario = new self;
                $usuario->setUsuarioId($usuarioData['usuario_id']);
                $usuario->setEmail($usuarioData['email']);
                $usuario->setAlias($usuarioData['alias']);
                $usuarios[] = $usuario;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }

        return $usuarios;
    }

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(int $usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    public function getRolFk(): int
    {
        return $this->rol_fk;
    }

    public function setRolFk(int $rol_fk): void
    {
        $this->rol_fk = $rol_fk;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): void
    {
        $this->alias = $alias;
    }
}

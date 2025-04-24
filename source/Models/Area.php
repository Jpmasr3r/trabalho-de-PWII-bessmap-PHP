<?php

namespace Source\Models;

use PDOException;
use Source\Core\Connect;
use Source\Core\Model;

class Area extends Model
{
    private $id;
    private $team_id;
    private $name;
    private $description;
    private $weathered;
    private $locate; // Nova propriedade
    private $message;

    public function __construct(
        int $id = null,
        int $team_id = null,
        string $name = null,
        string $description = null,
        bool $weathered = false,
        string $locate = null, // Nova propriedade
    ) {
        $this->id = $id;
        $this->team_id = $team_id;
        $this->name = $name;
        $this->description = $description;
        $this->weathered = $weathered;
        $this->locate = $locate; // Atribuição da nova propriedade
        $this->entity = "areas";
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamId(): ?int
    {
        return $this->team_id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getWeathered(): ?bool
    {
        return $this->weathered;
    }

    public function getLocate(): ?string // Novo getter
    {
        return $this->locate;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setTeamId(?int $team_id): void
    {
        $this->team_id = $team_id;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setWeathered(?bool $weathered): void
    {
        $this->weathered = $weathered;
    }

    public function setLocate(?string $locate): void // Novo setter
    {
        $this->locate = $locate;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function insert(): ?int
    {
        $conn = Connect::getInstance();

        $query = "SELECT * FROM areas WHERE name = :name AND team_id = :team_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":team_id", $this->team_id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $this->message = "Área já cadastrada!";
            return false;
        }

        $query = "INSERT INTO areas (name, description, weathered, locate, team_id) 
        VALUES (:name, :description, null, :locate, :team_id)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":locate", $this->locate); // Bind da nova propriedade
        $stmt->bindParam(":team_id", $this->team_id);

        try {
            $stmt->execute();
            $this->setId($conn->lastInsertId());
            return $conn->lastInsertId();
        } catch (PDOException) {
            $this->message = "Por favor, informe todos os campos!";
            return false;
        }
    }

    public function update(): bool
    {
        $conn = Connect::getInstance();

        $query = "SELECT * FROM areas WHERE name = :name AND team_id = :team_id AND id != :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":team_id", $this->team_id);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $this->message = "Área já cadastrada!";
            return false;
        }

        $query = "UPDATE areas SET 
        name = :name, 
        description = :description, 
        weathered = :weathered, 
        locate = :locate,
        team_id = :team_id 
        WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":weathered", $this->weathered);
        $stmt->bindParam(":locate", $this->locate);
        $stmt->bindParam(":team_id", $this->team_id);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Área atualizada com sucesso!";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao atualizar: {$exception->getMessage()}";
            return false;
        }
    }

    public function delete(): ?bool
    {
        try {
            $conn = Connect::getInstance();

            $query = "DELETE FROM boxes WHERE area_id = {$this->id}";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            $query = "DELETE FROM areas WHERE id = {$this->id}";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            $this->message = "Área deletada com sucesso!";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao deletar: {$exception->getMessage()}";
            return false;
        }
    }
}
<?php

namespace Source\Models;

use PDOException;
use Source\Core\Connect;
use Source\Core\Model;

class Vehicle extends Model
{
    private $id;
    private $model;
    private $availability;
    private $team_id;
    private $message;

    public function __construct(
        int $id = null,
        string $model = null,
        bool $availability = null,
        int $team_id = null
    ) {
        $this->id = $id;
        $this->model = $model;
        $this->availability = $availability;
        $this->team_id = $team_id;
        $this->entity = "vehicles";
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function getAvailability(): ?bool
    {
        return $this->availability;
    }

    public function getTeamId(): ?int
    {
        return $this->team_id;
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

    public function setModel(?string $model): void
    {
        $this->model = $model;
    }

    public function setAvailability(?bool $availability): void
    {
        $this->availability = $availability;
    }

    public function setTeamId(?int $team_id): void
    {
        $this->team_id = $team_id;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    // Método de Inserção
    public function insert(): ?int
    {
        $conn = Connect::getInstance();

        $query = "INSERT INTO vehicles (model, availability, team_id) 
        VALUES (:model, :availability, :team_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":model", $this->model);
        $stmt->bindParam(":availability", $this->availability, \PDO::PARAM_BOOL);
        $stmt->bindParam(":team_id", $this->team_id);

        try {
            $stmt->execute();
            $this->setId($conn->lastInsertId());
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            $this->message = "Erro ao inserir: {$e->getMessage()}";
            return null;
        }
    }

    // Método de Atualização
    public function update(): bool
    {
        $conn = Connect::getInstance();

        $query = "UPDATE vehicles SET 
        model = :model, 
        availability = :availability, 
        team_id = :team_id 
        WHERE id = :id";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":model", $this->model);
        $stmt->bindParam(":availability", $this->availability, \PDO::PARAM_BOOL);
        $stmt->bindParam(":team_id", $this->team_id);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Veículo atualizado com sucesso!";
            return true;
        } catch (PDOException $e) {
            $this->message = "Erro ao atualizar: {$e->getMessage()}";
            return false;
        }
    }

    // Método de Exclusão
    public function delete(): bool
    {
        $conn = Connect::getInstance();
        $query = "DELETE FROM vehicles WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Veículo deletado com sucesso!";
            return true;
        } catch (PDOException $e) {
            $this->message = "Erro ao deletar: {$e->getMessage()}";
            return false;
        }
    }
}

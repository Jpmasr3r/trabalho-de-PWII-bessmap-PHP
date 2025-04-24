<?php

namespace Source\Models;

use PDOException;
use Source\Core\Connect;
use Source\Core\Model;

class Boxe extends Model
{
    private $id;
    private $area_id;
    private $identifier;
    private $collect_status;
    private $message;

    public function __construct(
        int $id = null,
        int $area_id = null,
        string $identifier = null,
        bool $collect_status = null
    ) {
        $this->id = $id;
        $this->area_id = $area_id;
        $this->identifier = $identifier;
        $this->collect_status = $collect_status;
        $this->entity = "boxes";
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAreaId(): ?int
    {
        return $this->area_id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function getCollectStatus(): ?bool
    {
        return $this->collect_status;
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

    public function setAreaId(?int $area_id): void
    {
        $this->area_id = $area_id;
    }

    public function setIdentifier(?string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function setCollectStatus(?bool $collect_status): void
    {
        $this->collect_status = $collect_status;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    // Método de Inserção
    public function insert(): ?int
    {
        $conn = Connect::getInstance();

        $query = "SELECT * FROM boxes WHERE identifier = :identifier AND area_id = :area_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":identifier", $this->identifier);
        $stmt->bindParam(":area_id", $this->area_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $this->message = "Caixa já cadastrada nesta área!";
            return null;
        }

        $query = "INSERT INTO 
        boxes (area_id, identifier, collect_status) 
        VALUES (:area_id, :identifier, false)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":area_id", $this->area_id);
        $stmt->bindParam(":identifier", $this->identifier);

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

        $query = "SELECT * FROM boxes WHERE identifier = :identifier AND area_id = :area_id AND id != :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":identifier", $this->identifier);
        $stmt->bindParam(":area_id", $this->area_id);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $this->message = "Caixa já cadastrada nesta área!";
            return false;
        }

        $query = "UPDATE boxes SET 
        area_id = :area_id, 
        identifier = :identifier, 
        collect_status = :collect_status 
        WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":area_id", $this->area_id);
        $stmt->bindParam(":identifier", $this->identifier);
        $stmt->bindParam(":collect_status", $this->collect_status);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Caixa atualizada com sucesso!";
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
        $query = "DELETE FROM boxes WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Caixa deletada com sucesso!";
            return true;
        } catch (PDOException $e) {
            $this->message = "Erro ao deletar: {$e->getMessage()}";
            return false;
        }
    }
}

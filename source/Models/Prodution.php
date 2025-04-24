<?php

namespace Source\Models;

use PDOException;
use Source\Core\Connect;
use Source\Core\Model;

class Prodution extends Model
{
    private $id;
    private $date;
    private $amount;
    private $area_id;
    private $team_id;
    private $message;

    public function __construct(
        int $id = null,
        string $date = null,
        float $amount = null,
        int $area_id = null,
        int $team_id = null
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->amount = $amount;
        $this->area_id = $area_id;
        $this->team_id = $team_id;
        $this->entity = "produtions";
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getAreaId(): ?int
    {
        return $this->area_id;
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

    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    public function setAreaId(?int $area_id): void
    {
        $this->area_id = $area_id;
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

        $query = "INSERT INTO 
        produtions (date, amount, area_id, team_id) 
        VALUES (:date, :amount, :area_id, :team_id)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":area_id", $this->area_id);
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

    // Método de Exclusão
    public function delete(): bool
    {
        $conn = Connect::getInstance();
        $query = "DELETE FROM produtions WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Produção deletada com sucesso!";
            return true;
        } catch (PDOException $e) {
            $this->message = "Erro ao deletar: {$e->getMessage()}";
            return false;
        }
    }
}

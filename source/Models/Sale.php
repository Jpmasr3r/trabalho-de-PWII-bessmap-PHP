<?php

namespace Source\Models;

use PDOException;
use Source\Core\Connect;
use Source\Core\Model;

class Sale extends Model
{
    private $id;
    private $date;
    private $amount;
    private $profit;
    private $buyer;
    private $produtions_id;
    private $team_id;
    private $message;

    public function __construct(
        int $id = null,
        string $date = null,
        float $amount = null,
        float $profit = null,
        string $buyer = null,
        int $produtions_id = null,
        int $team_id = null
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->amount = $amount;
        $this->profit = $profit;
        $this->buyer = $buyer;
        $this->produtions_id = $produtions_id;
        $this->team_id = $team_id;
        $this->entity = "sales";
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

    public function getProfit(): ?float
    {
        return $this->profit;
    }

    public function getBuyer(): ?string
    {
        return $this->buyer;
    }

    public function getProdutionsId(): ?int
    {
        return $this->produtions_id;
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

    public function setProfit(?float $profit): void
    {
        $this->profit = $profit;
    }

    public function setBuyer(?string $buyer): void
    {
        $this->buyer = $buyer;
    }

    public function setProdutionsId(?int $produtions_id): void
    {
        $this->produtions_id = $produtions_id;
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
        sales (date, amount, profit, buyer, produtions_id, team_id) 
        VALUES (:date, :amount, :profit, :buyer, :produtions_id, :team_id)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":profit", $this->profit);
        $stmt->bindParam(":buyer", $this->buyer);
        $stmt->bindParam(":produtions_id", $this->produtions_id);
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

        $query = "UPDATE sales SET 
        date = :date, 
        amount = :amount, 
        profit = :profit, 
        buyer = :buyer, 
        produtions_id = :produtions_id, 
        team_id = :team_id 
        WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":profit", $this->profit);
        $stmt->bindParam(":buyer", $this->buyer);
        $stmt->bindParam(":produtions_id", $this->produtions_id);
        $stmt->bindParam(":team_id", $this->team_id);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Venda atualizada com sucesso!";
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
        $query = "DELETE FROM sales WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Venda deletada com sucesso!";
            return true;
        } catch (PDOException $e) {
            $this->message = "Erro ao deletar: {$e->getMessage()}";
            return false;
        }
    }
}

<?php

namespace Source\Models;

use PDOException;
use Source\Core\Connect;
use Source\Core\Model;

class Faq extends Model
{
    private $id;
    private $ask;
    private $answer;
    private $message;

    public function __construct(
        int $id = null,
        string $ask = null,
        string $answer = null,
    ) {
        $this->id = $id;
        $this->ask = $ask;
        $this->answer = $answer;
        $this->entity = "faqs";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAsk(): ?string
    {
        return $this->ask;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setAsk($ask) : void {
        $this->ask = $ask;
    }

    public function setAnswer($answer) : void {
        $this->answer = $answer;
    }

    public function insert(): ?int
    {

        $conn = Connect::getInstance();

        $query = "SELECT * FROM faqs WHERE ask LIKE :ask";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":ask", $this->ask);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $this->message = "Pergunta já cadastrada";
            return false;
        }

        $query = "INSERT INTO faqs (ask,answer) VALUES (:ask,:answer)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":ask", $this->ask);
        $stmt->bindParam(":answer", $this->answer);

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

        $query = "SELECT * FROM faqs WHERE ask LIKE :ask AND id != :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":ask", $this->ask);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $this->message = "Pergunta já cadastrada";
            return false;
        }

        $query = "UPDATE faqs SET ask = :ask, answer = :answer WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":ask", $this->ask);
        $stmt->bindParam(":answer", $this->answer);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Pergunta atualizada com sucesso atualizada com sucesso!";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao atualizar: {$exception->getMessage()}";
            return false;
        }
    }

    public function delete(): ?bool {
        $conn = Connect::getInstance();
        $query = "delete from faqs where id = {$this->id}";
        $stmt = $conn->prepare($query);
        try {
            $stmt->execute();
            $this->message = "Pergunta deletada com sucesso";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao deletar: {$exception->getMessage()}";
            return false;
        }
    }

}

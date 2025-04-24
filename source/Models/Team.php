<?php

namespace Source\Models;

use PDOException;
use Source\Core\Connect;
use Source\Core\Model;

class Team extends Model
{
    private $id;
    private $name;
    private $numberMembers;
    private $message;

    public function __construct(
        int $id = null,
        string $name = null,
        int $numberMembers = 0,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->numberMembers = $numberMembers;
        $this->entity = "teams";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getNumberMembers(): ?int
    {
        return $this->numberMembers;
    }

    public function setNumberMembers(?int $numberMembers): void
    {
        $this->numberMembers = $numberMembers;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function insert(): ?int
    {

        $conn = Connect::getInstance();

        $query = "SELECT * FROM teams WHERE name LIKE :name";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $this->message = "Equipe já cadastrado!";
            return false;
        }

        $query = "INSERT INTO teams (name,number_members) VALUES (:name,:number_members)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":number_members", $this->numberMembers);

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

        $query = "SELECT * FROM teams WHERE name LIKE :name AND id != :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $this->message = "Equipe já cadastrado!";
            return false;
        }

        $query = "UPDATE teams SET name = :name, number_members = :number_members WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":number_members", $this->numberMembers);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Equipe atualizada com sucesso!";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao atualizar: {$exception->getMessage()}";
            return false;
        }
    }

    public function delete(): ?bool {
        $conn = Connect::getInstance();
        $query = "delete from teams where id = {$this->id}";
        $stmt = $conn->prepare($query);
        try {
            $stmt->execute();
            $this->message = "Equipe deletada com sucesso";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao deletar: {$exception->getMessage()}";
            return false;
        }
    }

}

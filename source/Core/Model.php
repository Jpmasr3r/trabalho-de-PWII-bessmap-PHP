<?php

namespace Source\Core;

use PDO;
use PDOException;

abstract class Model
{

    protected $entity;

    private $message;
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function selectAll (): ?array
    {
        $conn = Connect::getInstance();
        $query = "SELECT * FROM {$this->entity}";
        return $conn->query($query)->fetchAll();
    }

    public function selectById(int $id): ?array
{
    $conn = Connect::getInstance();
    $query = "SELECT * FROM {$this->entity} WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function selectBy(string $key, string $value,string $itens = "*",string $type = "="): ?array
{
    $conn = Connect::getInstance();
    $query = "SELECT {$itens} FROM {$this->entity} WHERE {$key} {$type} :value";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':value', $value, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function insert(): ?int
    {
        $values = get_object_vars($this);// pegar os valores dos atributos e inserir em um arra
        array_shift($values);
        array_shift($values);

        foreach ($values as $key => $value){
            echo "{$value} => {$key} <br>";
            $values[$key] = is_null($value) ? "NULL" : "'{$value}'";
        }

        $valuesString = implode(",", $values);

        $conn = Connect::getInstance();
        $query = "INSERT INTO {$this->entity} VALUES ({$valuesString})";

        try {
            $result = $conn->query($query);
            $this->message = "Registro inserido com sucesso!";
            return $result ? $conn->lastInsertId() : null;
        } catch (PDOException $exception) {
            $this->message = "Erro ao inserir: {$exception->getMessage()}";
            return false;
        }

    }


}
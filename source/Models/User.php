<?php

namespace Source\Models;

use PDOException;
use Source\Core\Connect;
use Source\Core\Model;

class User extends Model
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $teamId;
    private $teamLeader;
    private $message;
    private $image;

    public function __construct(
        int $id = null,
        string $name = null,
        string $email = null,
        string $password = null,
        string $image = null,
        int $teamId = null,
        int $teamLeader = 0,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->teamId = $teamId;
        $this->teamLeader = $teamLeader;
        $this->image = $image;
        $this->entity = "users";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTeamLeader(): ?bool
    {
        return $this->teamLeader;
    }

    public function setTeamLeader(?bool $teamLeader): void
    {
        $this->teamLeader = $teamLeader;
    }

    public function getTeamId(): ?int
    {
        return $this->teamId;
    }

    public function setTeamId(?int $teamId): void
    {
        $this->teamId = $teamId;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    // Getter e Setter para 'message'
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    // Getter e Setter para 'image'
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }


    public function insert(): ?int
    {

        $conn = Connect::getInstance();

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->message = "E-mail Inválido!";
            return false;
        }

        $query = "SELECT * FROM users WHERE email LIKE :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $this->message = "E-mail já cadastrado!";
            return false;
        }

        if (7 >= strlen($this->password)) {
            $this->message = "A senha é muito curta, minimo de 8 caracteres";
            return false;
        }

        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (name, email, password,team_leader,team_id) 
                  VALUES (:name, :email, :password,false,null)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        try {
            $stmt->execute();
            return $conn->lastInsertId();
        } catch (PDOException) {
            $this->message = "Por favor, informe todos os campos!";
            return false;
        }
    }

    public function login(string $email, string $password): bool
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $conn = Connect::getInstance();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetch();

        if (!$result) {
            $this->message = "E-mail não cadastrado!";
            return false;
        }

        if (!password_verify($password, $result->password)) {
            $this->message = "Senha incorreta!";
            return false;
        }

        $this->setId($result->id);
        $this->setName($result->name);
        $this->setEmail($result->email);
        $this->setTeamLeader($result->team_leader);
        $this->setTeamId($result->team_id);

        $this->message = "Usuário logado com sucesso!";

        return true;
    }

    public function update(): bool
    {
        $conn = Connect::getInstance();

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->message = "E-mail inválido!";
            return false;
        }

        $query = "SELECT * FROM users WHERE email LIKE :email AND id != :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $this->message = "E-mail já cadastrado!";
            return false;
        }

        $query = "UPDATE users SET name = :name, email = :email, team_id = :team_id, team_leader = :team_leader, image = :image WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":team_id", $this->teamId);
        $stmt->bindParam(":team_leader", $this->teamLeader);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Usuário atualizado com sucesso!";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao atualizar: {$exception->getMessage()}";
            return false;
        }
    }

    public function updatePassword(string $password, string $newPassword, string $confirmNewPassword): bool
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $conn = Connect::getInstance();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $result = $stmt->fetch();

        if (!password_verify($password, $result->password)) {
            $this->message = "Senha incorreta!";
            return false;
        }

        if (7 >= strlen($newPassword)) {
            $this->message = "Nova senha muito curta minimo de 8 caracteres";
            return false;
        }

        if ($newPassword != $confirmNewPassword) {
            $this->message = "As novas senhas não conferem!";
            return false;
        }

        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE users 
                  SET password = :password 
                  WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":password", $newPassword);
        $stmt->bindParam(":id", $this->id);

        try {
            $stmt->execute();
            $this->message = "Senha atualizada com sucesso!";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao atualizar: {$exception->getMessage()}";
            return false;
        }
    }

    public function delete(): ?bool
    {
        $conn = Connect::getInstance();
        $query = "delete from users where id = {$this->id}";
        $stmt = $conn->prepare($query);
        try {
            $stmt->execute();
            $this->message = "Usuario deletado com sucesso";
            return true;
        } catch (PDOException $exception) {
            $this->message = "Erro ao deletar: {$exception->getMessage()}";
            return false;
        }
    }
}
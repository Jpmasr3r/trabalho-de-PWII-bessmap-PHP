<?php

namespace Source\App\Api;

use Source\Core\TokenJWT;
use Source\Models\User;
use Source\Models\Team;

session_start();
class Users extends Api
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listUsers(): void
    {
        $user = new User();
        $allUsers = $user->selectAll();
        $this->back([
            "type" => "success",
            "message" => "listagem de todos os usuarios",
            "data" => $allUsers
        ]);
    }

    public function createUser(array $data): void
    {
        if (in_array("", $data) || in_array(null, $data)) {
            $this->back([
                "type" => "error",
                "message" => "Preencha todos os campos"
            ]);
            return;
        }

        if ($data["password"] != $data["confirmPassword"]) {
            $this->back([
                "type" => "error",
                "message" => "A senhas não correspondem"
            ]);
            return;
        }

        $user = new User(
            null,
            $data["name"],
            $data["email"],
            $data["password"]
        );

        if (!$user->insert()) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Usuário cadastrodo com sucesso!"
        ]);
    }

    public function loginUser(array $data): void
    {
        $user = new User();

        if (!$user->login($data["email"], $data["password"])) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $token = new TokenJWT();
        $this->back([
            "type" => "success",
            "message" => $user->getMessage(),
            "token" => $token->create([
                "id" => $user->getId(),
            ])
        ]);
    }

    public function updateUser(array $data): void
    {
        if (!$this->userAuth) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        $user = new User();
        $userSession = $user->selectById($this->userAuth->id);
        foreach ($data as $key => $value) {
            if ($value == null || $value == "" || $value == "undefined") {
                $data[$key] = $userSession[$key];
            }
        }

        $user = new User(
            $this->userAuth->id,
            $data["name"],
            $data["email"],
            null,
            $data["image"],
            $userSession["team_id"],
        );

        if (!$user->update()) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "sucess",
            "message" => "Usuario atualizado com sucesso"
        ]);
        return;
    }

    public function setPassword(array $data): void
    {
        if (!$this->userAuth) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        $user = new User(
            $this->userAuth->id
        );

        if (!$user->updatePassword($data["password"], $data["newPassword"], $data["confirmNewPassword"])) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => $user->getMessage()
        ]);
    }

    public function deleteUser(): void
    {
        if (!$this->userAuth) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        $user = new User(
            $this->userAuth->id
        );

        if (!$user->delete()) {
            $this->back([
                "type" => "error",
                "message" => $user->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "error",
            "message" => "Usuario deletado com sucesso"
        ]);
    }

    public function logged(): void
    {
        $logged = false;
        if ($this->userAuth) {
            $logged = true;
        }
        $this->back([
            "logged" => $logged
        ]);
    }

    public function getInfs(): void
    {
        if (!$this->userAuth) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }

        $user = new User();
        $userSession = $user->selectById($this->userAuth->id);

        if ($userSession["team_id"] == null) {
            $this->back([
                "type" => "success",
                "data" => [
                    "name" => $userSession["name"],
                    "team_name" => "",
                    "image" => $userSession["image"],
                ]
            ]);
            return;
        }

        $team = new Team();
        $teamSelect = $team->selectById($userSession["team_id"]);

        $this->back([
            "type" => "success",
            "data" => [
                "name" => $userSession["name"],
                "team_name" => $teamSelect["name"],
                "image" => $userSession["image"],
            ]
        ]);
    }
}
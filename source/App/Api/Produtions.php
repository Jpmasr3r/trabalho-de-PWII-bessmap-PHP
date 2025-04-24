<?php

namespace Source\App\Api;

use Source\Models\Prodution;
use Source\Models\User;

class Produtions extends Api
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->userAuth) {
            $this->back([
                "type" => "error",
                "message" => "Você não pode estar aqui.."
            ]);
            return;
        }
    }

    public function listByTeam(): void
    {
        $user = new User();
        $userSession = $user->selectById($this->userAuth->id);
        $prodution = new Prodution();
        $this->back([
            "type" => "success",
            "data" => $prodution->selectBy(
                "team_id",
                $userSession["team_id"]
            )
        ]);
    }

    public function insert(array $data): void
    {
        if (in_array("", $data) || in_array(null, $data)) {
            $this->back([
                "type" => "error",
                "message" => "Preencha todos os campos"
            ]);
            return;
        }

        $user = new User();
        $sessionUser = $user->selectById($this->userAuth->id);

        $prodution = new Prodution(
            null,
            $data["date"],
            $data["amount"],
            $data["area_id"],
            $sessionUser["team_id"]
        );

        if (!$prodution->insert()) {
            $this->back([
                "type" => "error",
                "message" => $prodution->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Produção inseriada com sucesso"
        ]);
    }

    public function delete(array $data): void
    {
        $prodution = new Prodution(
            $data["id"]
        );

        if (!$prodution->delete()) {
            $this->back([
                "type" => "error",
                "message" => $prodution->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Sucesso ao deletar a produção"
        ]);
    }
}

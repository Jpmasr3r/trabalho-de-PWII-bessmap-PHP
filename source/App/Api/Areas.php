<?php

namespace Source\App\Api;

use Source\Models\Area;
use Source\Models\User;

class Areas extends Api
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
        $area = new Area();
        $this->back([
            "type" => "success",
            "data" => $area->selectBy(
                "team_id",
                $userSession["team_id"],
                "name, description, locate, weathered, id"
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

        $area = new Area(
            null,
            $sessionUser["team_id"],
            $data["name"],
            $data["description"],
            false,
            $data["locate"],
        );

        if (!$area->insert()) {
            $this->back([
                "type" => "error",
                "message" => $area->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Area inseriada com sucesso"
        ]);
    }

    public function update(array $data): void
    {
        $area = new Area();
        $areaSelect = $area->selectById($data["id"]);

        foreach ($data as $key => $value) {
            if ($value == "" || $value == null) {
                $data[$key] = $areaSelect[$key];
            }
        }

        $area = new Area(
            $areaSelect["id"],
            $areaSelect["team_id"],
            $data["name"],
            $data["description"],
            $data["weathered"],
            $data["locate"]
        );

        if (!$area->update()) {
            $this->back([
                "type" => "error",
                "message" => $area->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Area atualizada com sucesso"
        ]);
    }

    public function delete(array $data): void
    {
        $area = new Area(
            $data["id"]
        );

        if (!$area->delete()) {
            $this->back([
                "type" => "error",
                "message" => $area->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Sucesso ao deletar a area"
        ]);
    }
}
<?php

namespace Source\App\Api;

use Source\Models\Boxe;
use Source\Models\User;

class Boxes extends Api
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

    public function listByArea(array $data): void
    {
        $boxe = new Boxe();
        $this->back([
            "type" => "success",
            "data" => $boxe->selectBy(
                "area_id",
                $data["area_id"],
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

        $boxe = new Boxe(
            null,
            $data["area_id"],
            $data["identifier"],
            false,
        );

        if (!$boxe->insert()) {
            $this->back([
                "type" => "error",
                "message" => $boxe->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Caixa inserida com sucesso"
        ]);
    }

    public function update(array $data): void
    {
        $boxe = new Boxe();
        $boxeSelect = $boxe->selectById($data["id"]);

        foreach ($data as $key => $value) {
            if ($value == "" || $value == null) {
                $data[$key] = $boxeSelect[$key];
            }
        }

        $boxe = new Boxe(
            $boxeSelect["id"],
            $boxeSelect["area_id"],
            $data["identifier"],
            $data["collect_status"]
        );

        if (!$boxe->update()) {
            $this->back([
                "type" => "error",
                "message" => $boxe->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Caixa atualizada com sucesso"
        ]);
    }

    public function delete(array $data): void
    {
        $boxe = new Boxe(
            $data["id"]
        );

        if (!$boxe->delete()) {
            $this->back([
                "type" => "error",
                "message" => $boxe->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Sucesso ao deletar a area"
        ]);
    }
}
<?php

namespace Source\App\Api;

use Source\Models\User;
use Source\Models\Vehicle;

class Vehicles extends Api
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
        $userSession = $user->selectById($this->userAuth->id);

        $vehicle = new Vehicle(
            null,
            $data["model"],
            $data["availability"],
            $userSession["team_id"]
        );

        if (!$vehicle->insert()) {
            $this->back([
                "type" => "error",
                "message" => $vehicle->getMessage()
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
        $vehicle = new Vehicle();
        $vehicleSelect = $vehicle->selectById($data["id"]);

        foreach ($data as $key => $value) {
            if ($value == "" || $value == null) {
                $data[$key] = $vehicleSelect[$key];
            }
        }

        $vehicle = new Vehicle(
            $vehicleSelect["id"],
            $data["model"],
            $data["availability"],
            $vehicleSelect["team_id"]
        );

        if (!$vehicle->update()) {
            $this->back([
                "type" => "error",
                "message" => $vehicle->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Area atualizada com sucesso"
        ]);
    }

    public function listByTeam(): void
    {
        $user = new User();
        $userSession = $user->selectById($this->userAuth->id);
        $vehicle = new Vehicle();
        $this->back([
            "type" => "success",
            "data" => $vehicle->selectBy(
                "team_id",
                $userSession["team_id"],
                "model, availability"
            )
        ]);
    }

    public function delete(array $data): void 
    {
        $vehicle = new Vehicle(
            $data["id"]
        );

        if(!$vehicle->delete()) {
            $this->back([
                "type" => "error",
                "message" => $vehicle->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Sucesso ao deletar a area"
        ]);
    }
}

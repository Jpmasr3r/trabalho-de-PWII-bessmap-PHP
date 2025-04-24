<?php

namespace Source\App\Api;
use Source\Models\Sale;
use Source\Models\User;

class Sales extends Api
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
        $sale = new Sale();
        $this->back([
            "type" => "success",
            "data" => $sale->selectBy(
                "team_id",
                $userSession["team_id"],
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
        $userSession = $user->selectById($this->userAuth->id);

        $sale = new Sale(
            null,
            $data["date"],
            $data["amount"],
            $data["profit"],
            $data["buyer"],
            $data["prodution_id"],
            $userSession["team_id"]
        );

        if (!$sale->insert()) {
            $this->back([
                "type" => "error",
                "message" => $sale->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Venda inseriada com sucesso"
        ]);
    }

    public function update(array $data): void
    {
        $sale = new Sale();
        $saleSelect = $sale->selectById($data["id"]);

        foreach ($data as $key => $value) {
            if ($value == "" || $value == null) {
                $data[$key] = $saleSelect[$key];
            }
        }

        $sale = new Sale(
            $saleSelect["id"],
            $saleSelect["date"],
            $data["amount"],
            $data["profit"],
            $data["buyer"],
            $saleSelect["prodution_id"],
            $saleSelect["team_id"]
        );


        if (!$sale->update()) {
            $this->back([
                "type" => "error",
                "message" => $sale->getMessage()
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
        $sale = new Sale(
            $data["id"]
        );

        if(!$sale->delete()) {
            $this->back([
                "type" => "error",
                "message" => $sale->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Sucesso ao deletar a area"
        ]);
    }
}

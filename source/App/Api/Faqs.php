<?php

namespace Source\App\Api;

use Source\Models\Faq;

class Faqs extends Api
{

    public function listFaqs(): void
    {
        $faq = new Faq();
        $this->back([
            "type" => "success",
            "message" => "Listagem bem sucedida",
            "data" => $faq->selectAll(),
        ]);
    }

    public function insert(array $data): void
    {

        if(in_array("",$data) || in_array(null,$data)) {
            $this->back([
                "type" => "error",
                "message" => "preencha todos os campos"
            ]);
            return;
        }

        $faq = new Faq(
            null,
            $data["ask"],
            $data["answer"]
        );

        if (!$faq->insert()) {
            $this->back([
                "type" => "error",
                "message" => $faq->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Pergunta inseriada com sucesso"
        ]);
    }

    public function update(array $data): void
    {
        if(in_array("",$data) || in_array(null,$data)) {
            $this->back([
                "type" => "error",
                "message" => "preencha todos os campos"
            ]);
            return;
        }
        
        $faq = new Faq();
        $selectFaq = $faq->selectById($data["id"]);

        foreach ($data as $key => $value) {
            if ($value == "" || $value == null) {
                $data[$key] = $selectFaq[$key];
            }
        }

        $faq = new Faq(
            $data["id"],
            $data["ask"],
            $data["answer"]
        );

        if (!$faq->update()) {
            $this->back([
                "type" => "error",
                "message" => $faq->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Pergunta atualizada com sucesso"
        ]);
    }

    public function delete(array $data): void 
    {
        $faq = new Faq(
            $data["id"]
        );

        if(!$faq->delete()) {
            $this->back([
                "type" => "error",
                "message" => $faq->getMessage()
            ]);
            return;
        }

        $this->back([
            "type" => "success",
            "message" => "Sucesso ao deletar a pergunta"
        ]);
    }
}

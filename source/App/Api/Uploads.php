<?php

namespace Source\App\Api;

use Source\Models\Uploader;

class Uploads extends Api
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

    public function uploadImage()
    {
        // Verifica se todos os campos necessários estão preenchidos
        if (empty($_FILES["image"])) {
            $this->back([
                "type" => "error",
                "message" => "Envie uma imagem"
            ]);
            return;
        }

        // Instancia a classe Uploader e realiza o upload
        $uploader = new Uploader($_FILES["image"]);

        if (!$uploader->uploadImage()) {
            $this->back([
                "type" => "error",
                "message" => $uploader->getMessage()
            ]);
            return;
        }

        // Retorna a mensagem de sucesso e o caminho do arquivo
        $this->back([
            "type" => "success",
            "message" => $uploader->getMessage(),
            "path" => $uploader->getPath()
        ]);
    }
}
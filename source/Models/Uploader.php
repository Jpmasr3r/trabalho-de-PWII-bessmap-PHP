<?php

namespace Source\Models;

use CoffeeCode\Uploader\Image;
use Exception;

class Uploader
{
    private $file;
    private $message;
    private $path;
    private $maxFileSize;

    public function __construct(array $file, int $maxFileSize = 2000000) // Tamanho máximo de 2MB por padrão
    {
        $this->file = $file;
        $this->maxFileSize = $maxFileSize;
    }

    private function validateSize(): bool
    {
        if ($this->file['size'] > $this->maxFileSize) {
            $this->message = "O tamanho do arquivo excede o limite permitido de " . ($this->maxFileSize / 1000000) . "MB.";
            return false;
        }
        return true;
    }

    public function uploadImage(): bool
    {
        if ($this->file) {
            // Verifica o tamanho do arquivo
            if (!$this->validateSize()) {
                return false;
            }

            // Caminho absoluto do diretório de upload
            $uploadDir = dirname(__DIR__, 2) . "/uploads";
            // Caminho relativo ao projeto
            $relativeUploadDir = "uploads";
            $imageTypes = ["image/jpeg", "image/png", "image/jpg"];

            if (in_array($this->file['type'], $imageTypes)) {
                $upload = new Image($uploadDir, "images");
            } else {
                $this->message = "Tipo de arquivo não suportado.";
                return false;
            }
            try {
                $uploaded = $upload->upload($this->file, pathinfo($this->file['name'], PATHINFO_FILENAME), 200);

                $this->path = "http://localhost/trabalho-de-PWII-bessmap-PHP/" . str_replace($uploadDir, $relativeUploadDir, $uploaded);
                $this->message = "Arquivo enviado com sucesso.";
                return true;
            } catch (Exception $e) {
                $this->message = $e->getMessage();
                return false;
            }
        } else {
            $this->message = "Nenhum arquivo enviado.";
            return false;
        }
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }
}
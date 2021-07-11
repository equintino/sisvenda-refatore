<?php

namespace _App;

class FileRegistration extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function init($data): void
    {
        $id = $data["id"];
        $this->view->setPath("Modals")->render("image", [ compact("id") ]);
    }

    public function loadImage($data): void
    {
        $fileRegistration = new \Models\FileRegistration();
        if( isset( $data["id"] ) ) {
            $document = $fileRegistration->showImage($data["id"]);
            if(!$document) {
                echo "<div style='color: red'><blink>Desculpe! Parece que o anexo foi excluído.</blink></div>";
            }
            echo $document;
        } else {
            echo "Nenhum arquivo encontrado!";
        }
    }

    public function delete(array $data)
    {
        $fileRegistration = new \Models\FileRegistration();
        $file = $fileRegistration->load($data["id"]);
        $file->destroy();
        return print(json_encode($file->message()));
    }

}

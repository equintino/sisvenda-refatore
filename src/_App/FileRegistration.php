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
                echo "<h1 style='color: red'><blink>Desculpe! Anexo foi excluído.</blink></h1>";
            }
            echo $document;
        } else {
            echo "Nenhum arquivo encontrado!";
        }
    }

    // public function list(): void
    // {
    //     $groups = $this->group()->all() ?? [];
    //     $screens = Safety::screens("/pages");
    //     $groupId = (new User())->find($_SESSION["login"]->Logon)->Group_id;

    //     $page = "shield";
    //     echo "<script>var identification = 'GRUPO DE ACESSOS'</script>";
    //     $this->view->insertTheme([ compact("page") ]);
    //     $this->view->render("shield", [ compact("groups","screens","groupId") ]);
    // }

    // public function add(): void
    // {
    //     ($this->view->setPath("Modals")->render("group"));
    // }

    // public function save(): void
    // {
    //     $params = $this->getPost($_POST);
    //     $group = $this->group();

    //     $group->bootstrap($params);
    //     $group->save();
    //     echo json_encode($group->message());
    // }

    // public function update(): void
    // {
    //     $params = $this->getPost($_POST);
    //     $group = $this->group()->find($params["name"]);

    //     foreach($params as $key => $value) {
    //         $value = ($key === "access" ? " home, error," . $value : $value);
    //         $group->$key = $value;
    //     }

    //     $group->save();
    //     echo json_encode($group->message());
    // }

    // public function delete(array $data): void
    // {
    //     $group = $this->group()->find($data["name"]);
    //     $group->destroy();
    //     echo json_encode($group->message());
    // }
}

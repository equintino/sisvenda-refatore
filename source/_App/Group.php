<?php

namespace Source\_App;

use Source\Traits\GroupTrait;
use Source\Models\User;

class Group extends Controller
{
    use GroupTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function list(): void
    {
        $groups = $this->group()->all() ?? [];
        $exceptions = [ "home.php", "error.php" ];
        $screens = \Source\Core\Safety::screens("/pages", $exceptions);
        $groupId = (new User())->find($_SESSION["login"]->Logon)->Group_id;

        $page = "shield";
        $this->view->insertTheme([ compact("page") ]);
        $this->view->render("shield", [ compact("groups","screens","groupId") ]);
    }

    public function load(array $data): void
    {
        $dGroup = $this->group()->find($data["groupName"]);
        if($dGroup) {
            $security["access"] = explode(",", $dGroup->access);
            echo json_encode($security);
        }
    }

    public function add(): void
    {
        ($this->view->setPath("Modals")->render("group"));
    }

    public function save(): void
    {
        $params = $this->getPost($_POST);
        $group = $this->group();

        $group->bootstrap($params);
        $group->save();
        echo json_encode($group->message());
    }

    public function update(): void
    {
        $params = $this->getPost($_POST);
        $group = $this->group()->find($params["name"]);

        foreach($params as $key => $value) {
            $value = ($key === "access" ? " home, error," . $value : $value);
            $group->$key = $value;
        }

        $group->save();
        echo json_encode($group->message());
    }

    public function delete(array $data): void
    {
        $group = $this->group()->find($data["name"]);
        $group->destroy();
        echo json_encode($group->message());
    }
}
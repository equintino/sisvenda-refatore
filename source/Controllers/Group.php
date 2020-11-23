<?php

namespace Source\Controllers;

use Source\Controllers\Traits\GroupTrait;
use Source\Models\User;

class Group extends Controller
{
    use GroupTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function list()
    {
        $groups = $this->group()->all() ?? [];
        $exceptions = [ "home.php", "error.php" ];
        $screens = \Source\Core\Safety::screens("/pages", $exceptions);
        $groupId = (new User())->find($_SESSION["login"]->Logon)->Group_id;

        $page = "shield";
        $this->view->insertTheme([ compact("page") ]);
        $this->view->render("shield", [ compact("groups","screens","groupId") ]);
    }

    public function load()
    {
        $groupName = filter_input(INPUT_GET, "groupName", FILTER_SANITIZE_STRIPPED);

        $dGroup = $this->group()->find($groupName);
        $security["access"] = explode(",", $dGroup->access);
        return print(json_encode($security));
    }

    public function add()
    {
        ($this->view->setPath("Modals")->render("group"));
    }

    public function save()
    {
        $params = $this->getPost($_POST);
        $group = $this->group();

        $group->bootstrap($params);
        $group->save();
        return print(json_encode($group->message()));
    }

    public function update()
    {
        $params = $this->getPost($_POST);
        $group = $this->group()->find($params["name"]);

        foreach($params as $key => $value) {
            $value = ($key === "access" ? " home, error," . $value : $value);
            $group->$key = $value;
        }

        $group->save();
        return print(json_encode($group->message()));
    }

    public function delete()
    {
        $params = $this->getPost($_POST);
        $group = $this->group()->find($params["name"]);
        $group->destroy();
        return print(json_encode($group->message()));
    }
}

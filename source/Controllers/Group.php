<?php

namespace Source\Controllers;

//use Source\Classes\AjaxTransaction;

class Group extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function load()
    {
        $groupName = filter_input(INPUT_GET, "groupName", FILTER_SANITIZE_STRIPPED);

        $group = new \Source\Models\Group();
        $dGroup = $group->find($groupName);
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
        $group = new \Source\Models\Group();

        $group->bootstrap($params);
        $group->save();
        return print(json_encode($group->message()));
    }

    public function update()
    {
        $params = $this->getPost($_POST);
        $group = (new \Source\Models\Group())->find($params["name"]);

        foreach($params as $key => $value) {
            $group->$key = $value;
        }

        $group->save();
        return print(json_encode($group->message()));
    }

    public function delete()
    {
        $params = $this->getPost($_POST);
        $group = (new \Source\Models\Group())->find($params["name"]);
        $group->destroy();
        return print(json_encode($group->message()));
    }
}

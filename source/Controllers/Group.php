<?php

namespace Source\Controllers;

use Source\Classes\AjaxTransaction;

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
        $security["access"] = explode(",",$dGroup->access);
        return print(json_encode($security));
    }

    public function add()
    {
        include __DIR__  . "/../Modals/group.php";
    }

    public function save()
    {
        $params = $this->getPost($_POST);
        $class = new \Source\Models\Group();
        echo (new AjaxTransaction($class, $params))->saveData();
    }
}

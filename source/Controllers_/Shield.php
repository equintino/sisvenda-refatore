<?php

namespace Source\Controllers;

use Source\Core\View;
use Source\Core\Safety;
use Source\Models\Group;
use Source\Models\User;

class Shield extends Controller
{
    protected $page = " shield";

    public function __construct()
    {
        parent::__construct();
    }

    // public function list()
    // {
    //     $groups["groups"] = (new Group())->all() ?? [];
    //     $screens["screens"] = Safety::screens(__DIR__ . "/../pages");
    //     $groupId["groupId"] = (new User())->find($_SESSION["login"]->Logon)->Group_id;
    //     $params = [ $groups, $screens, $groupId ];

    //     $page = [ "page" => "shield" ];
    //     $this->view->insertTheme([ $page ]);
    //     $this->view->render("shield", $params);
    // }

}

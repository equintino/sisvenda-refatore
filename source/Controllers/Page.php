<?php

namespace Source\Controllers;

use Source\Pages\View;
use Source\Models\Company;
use Source\Models\User;
use Source\Models\Group;
use Source\Core\Safety;
use Source\Config\Config;
use Source\Core\Session;

class Page extends Controller
{
    public function home()
    {
        (new View())->home();
    }

    public function login()
    {
        $companyId = filter_input(INPUT_GET, "companyId", FILTER_SANITIZE_STRIPPED);
        $companys = (new Company())->all();
        $users = (new User())->find(["IDEmpresa" => $companyId]);
        $groups = (new Group())->all();
        echo "<script>var companyId = '" . $companyId . "' </script>";

        (new View())->login();

    }

    public function shield()
    {
        $groups = (new Group())->all();
        $screens = Safety::screens(__DIR__);
        (new View())->shield($groups, $screens);
    }

    public function config()
    {
        $config = new Config();
        (new View())->config($config);
    }

    public function exit()
    {
        (new Session())->destroy();
        echo "<script>window.location.reload()</script>";
    }
}

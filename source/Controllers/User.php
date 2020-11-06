<?php

namespace Source\Controllers;

use Source\Core\View;
use Source\Classes\AjaxTransaction;

class User extends Controller
{
    protected $page = " login";

    public function __construct()
    {
        parent::__construct();
    }

    public function init()
    {
        $companys = (new \Source\Models\Company())->all();
        $groups = (new \Source\Models\Group())->all();
        $params = [ $companys, $groups ];

        $this->view->insertTheme();
        $this->view->render("login", $params);
        echo "<script>var page='login'</script>";
    }

    public function list()
    {
        require __DIR__ . "/../Modals/login.php";
    }

    public function add()
    {
        require __DIR__ . "/../Modals/login.php";
    }

    public function edit()
    {
        require __DIR__ . "/../Modals/login.php";
    }

    public function save()
    {
        $params = $this->getPost($_POST);
        $class = new \Source\Models\User();
        echo (new AjaxTransaction($class, $params))->saveData();
    }

    public function delete()
    {
        $params = $this->getPost($_POST);
        $class = new \Source\Models\User();
        echo (new AjaxTransaction($class, $params))->saveData();
    }

}

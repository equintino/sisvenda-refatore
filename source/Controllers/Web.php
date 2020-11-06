<?php

namespace Source\Controllers;

use Source\Models\Group;

class Web extends Controller
{
    //public $theme = __DIR__ . "/../layout/index.php";
    //private $access;

    public function __construct()
    {
        parent::__construct();
    }

    public function home()
    {
        $this->view->insertTheme();
        $this->view->render("home");
    }

    public function error()
    {
        echo "erro";
    }

    public function show()
    {
        //$access = $this->access;
        //$this->view->theme(__DIR__ . "/../layout/index.php");
        //require $this->theme;
    }

    // public function getAccess(): ?array
    // {
    //     return $this->access;
    // }
}

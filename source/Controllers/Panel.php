<?php

namespace Source\Controllers;

use Source\Core\View;

class Panel extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard()
    {
        $this->theme->show();
        (new view("home"))->show();
    }

    public function login()
    {
        echo "estou no login";
    }

}

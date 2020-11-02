<?php

namespace Source\Controllers;

use Source\Core\View;

class Panel extends Controller
{
    public function dashboard()
    {
        (new Web())->theme();
        (new view("home"))->show();
    }

}

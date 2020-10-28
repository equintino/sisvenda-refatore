<?php

namespace Source\Controllers;

use Source\Core\View;

class Panel extends Controller
{
    public function dashboard()
    {
        (new view("home"))->show();
    }

}

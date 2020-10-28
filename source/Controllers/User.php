<?php

namespace Source\Controllers;

use Source\Core\View;

class User extends Controller
{
    public function __construct()
    {

    }

    public function init()
    {
        (new View("login"))->show();
        echo "<script>var page='login'</script>";
    }

}

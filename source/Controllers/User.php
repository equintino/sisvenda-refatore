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
        $companys = (new \Source\Models\Company())->all();
        $groups = (new \Source\Models\Group())->all();
        $params = [ $companys, $groups ];
        (new View("login", $params))->show();
        echo "<script>var page='login'</script>";
    }

}

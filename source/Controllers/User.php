<?php

namespace Source\Controllers;

use Source\Core\View;

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
        (new View("login", $params))->show();
        echo "<script>var page='login'</script>";
    }

}

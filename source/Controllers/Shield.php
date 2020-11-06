<?php

namespace Source\Controllers;

use Source\Core\View;
use Source\Core\Safety;
use Source\Models\Group;

class Shield extends Controller
{
    protected $page = " shield";

    public function __construct()
    {
        parent::__construct();
    }

    public function list()
    {
        $groups["groups"] = (new Group())->all();
        $screens["screens"] = Safety::screens(__DIR__ . "/../pages");
        $params = [ $groups, $screens ];

        $this->view->insertTheme();
        $this->view->render("shield", $params);
        echo "<script>var page='shield'</script>";
    }

}

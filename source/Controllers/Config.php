<?php

namespace Source\Controllers;

use Source\Core\View;

class Config extends Controller
{
    protected $page = " config";

    public function __construct()
    {
        parent::__construct();
    }

    public function list()
    {
        $config["config"] = new \Source\Config\Config();
        $this->theme->show();
        (new View("config", [ $config ]))->show();
        echo "<script>var page='config'</script>";
    }

    public function add()
    {
        include __DIR__  . "/../Modals/config.php";
    }

    public function edit()
    {
        include __DIR__ . "/../Modals/config.php";
    }

    public function save($params)
    {

    }
}

<?php

namespace Source\Controllers;

use Source\Core\View;

class Config extends Controller
{
    public function __construct()
    {

    }

    public function list()
    {
        $config["config"] = new \Source\Config\Config();

        (new View("config", [ $config ]))->show();//->config($config);
        echo "<script>var page='config'</script>";
    }

    public function add()
    {
        echo "<style>#boxe_main #topHeader, #boxe_main .identification { display: none }</style>";
        include __DIR__  . "/../Modals/config.php";
    }

    public function edit()
    {
        echo "<style>#boxe_main #topHeader, #boxe_main .identification { display: none }</style>";
        include __DIR__ . "/../Modals/config.php";
    }

    public function save($params)
    {

    }
}

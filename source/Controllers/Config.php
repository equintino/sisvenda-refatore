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
}

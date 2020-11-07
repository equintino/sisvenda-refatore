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

        $page = [ "page" => "config" ];
        $this->view->insertTheme([ $page ]);
        $this->view->render("config", [ $config ]);
    }

    public function add()
    {
        include __DIR__  . "/../Modals/config.php";
    }

    public function edit()
    {
        include __DIR__ . "/../Modals/config.php";
    }

    public function save()
    {
        $params = $this->getPost($_POST);
        $data = $params["data"];
        $config = new \Source\Config\Config();
        parse_str($data, $connectionName);

        $config->setConfConnection($connectionName["connectionName"], $data);
        $config->confirmSave();
        echo json_encode($config->message());
    }

    public function update()
    {
        $params = $this->getPost($_POST);
        $connectionName = $params["connectionName"];
        $data = $params["data"];
        $config = new \Source\Config\Config();

        $config->setConfConnection($connectionName, $data);
        $config->save();
        echo json_encode($config->message());
    }

    public function delete()
    {
        $params = $this->getPost($_POST);
        $config = new \Source\Config\Config();
        $config->delete($params["connectionName"]);
        echo json_encode($config->message());
    }
}

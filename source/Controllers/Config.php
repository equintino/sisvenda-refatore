<?php

namespace Source\Controllers;

use Source\Core\View;
use Source\Controllers\Traits\ConfigTrait;

class Config extends Controller
{
    use ConfigTrait;
    
    protected $page = " config";
    private $config;
    private $types = [ "mysql", "sqlsrv" ];

    public function __construct()
    {
        parent::__construct();
        $this->config = $this->config();
    }

    public function list()
    {
        $config = (object) $this->config;
        $activeConnection = \Source\Core\Connect::getConfConnection();
        $page = "config";
        $this->view->insertTheme( [ compact("page") ] );
        $this->view->render("config", [ compact("config","activeConnection") ]);
    }

    public function add()
    {
        $data = $this->getGet($_GET);
        $types = $this->types;
        $params = [ $data, compact("types") ];

        ($this->view->setPath("Modals")->render("config", $params));
    }

    public function edit()
    {
        $data = $this->getGet($_GET);
        $types = $this->types;
        $connectionName = $data["connectionName"];
        $config = $this->config;
        $config->local = $connectionName;

        ($this->view->setPath("Modals")->render("config", [ compact("config", "types") ]));
    }

    public function save()
    {
        $params = $this->getPost($_POST);
        $data = $params["data"];
        $this->config->save($data);
        echo json_encode($this->config->message());
    }

    public function update()
    {
        $params = $this->getPost($_POST);
        $data = $params["data"];
        $this->config->update($params);
        echo json_encode($this->config->message());
    }

    public function delete()
    {
        $params = $this->getPost($_POST);
        $this->config->delete($params["connectionName"]);
        echo json_encode($this->config->message());
    }
}

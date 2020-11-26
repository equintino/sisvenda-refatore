<?php

namespace Source\_App;

use Source\Core\View;
use Source\Traits\ConfigTrait;

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

    public function list(): void
    {
        $config = (object) $this->config;
        $activeConnection = \Source\Core\Connect::getConfConnection();
        $page = "config";
        $this->view->insertTheme( [ compact("page") ] );
        $this->view->render("config", [ compact("config","activeConnection") ]);
    }

    public function add(): void
    {
        $types = $this->types;
        $act = "add";

        ($this->view->setPath("Modals")->render("config", [ compact("act", "types") ]));
    }

    public function edit(array $data): void
    {
        $types = $this->types;
        $connectionName = $data["connectionName"];
        $config = $this->config;
        $config->local = $connectionName;

        ($this->view->setPath("Modals")->render("config", [ compact("config", "types") ]));
    }

    public function save(): void
    {
        $params = $this->getPost($_POST);
        $data = $params["data"];
        $this->config->save($data);
        echo json_encode($this->config->message());
    }

    public function update(): void
    {
        $params = $this->getPost($_POST);
        $data = $params["data"];
        $this->config->update($params);
        echo json_encode($this->config->message());
    }

    public function delete(array $data): void
    {
        $this->config->delete($data["connectionName"]);
        echo json_encode($this->config->message());
    }
}

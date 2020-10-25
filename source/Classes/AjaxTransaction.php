<?php

namespace Classes;

class AjaxTransaction
{
    private $cleanFields = [ "act", "confSenha", "action" ];
    private $class;
    private $action;
    private $params;
    private $className;
    private $search;
    private $method;

    public function __construct(object $class, array $params)
    {
        $this->setClass($class);
        $this->params = $params;
        $this->action = $params["action"];
    }

    public function loadData()
    {

    }

    public function saveData(): ?string
    {
        $this->cleanFields();
        $className = $this->getClassName();

        if($className === "User") {
            $this->params["USUARIO"] = &$this->params["Logon"];
            $this->search = $this->params["Logon"];
        }
        elseif($className === "Group") {
            unset($this->params["Logon"]);
            $this->search = $this->params["name"]; 
        }
        else {
            unset($this->params["Logon"]);
            $this->search = $this->params["name"];
        }
        $this->setMethodClass();
        $this->setData();

        return $this->run()->message();
    }

    private function cleanFields(): array
    {
        foreach($this->params as $key => $value) {
            if(in_array($key, $this->cleanFields)) {
                unset($this->params[$key]);
            }
        }
        return $this->params;
    }

    private function replaceData($class): object
    {
        foreach($this->params as $key => $value) {
            $class->$key = $value;
        }
        return $class;
    }

    private function getClassName(): string
    {
        return explode("\\",get_class($this->class))[1];
    }

    private function setMethodClass()
    {
        switch($this->action) {
            case "add":
                $this->method = "save";
                break;
            case "change":
                $this->method = "save";
                break;
            case "edit":
                $this->method = "save";
                break;
            case "reset":
                $this->method = "save";
                break;
            case "delete":
                $this->method = "destroy";
        }
    }

    private function getClass(): object
    {
        return $this->class;
    }

    private function setClass(object $class)
    {
        $this->class = $class;
    }

    private function setData()
    {
        switch($this->action) {
            case "add":
                $data = $this->class->bootstrap($this->params);
                $this->class = $data;
                break;
            case "change":
                $data = $this->class->find($this->search);
                $data->Senha = $this->class->crypt($this->params["Senha"]);
                $data->token = null;
                $this->class = $data;
                break;
            case "edit":
                $data = $this->class->find($this->search);
                $data = $this->replaceData($data);
                $this->class= $data;
                break;
            case "reset":
                $data = $this->class->find($this->search);
                $data->token();
                $this->class = $data;
                break;
            case "delete":
                $data = $this->class->find($this->search);
                $this->class = $data;
                break;
        }
    }

    private function run(): object
    {
        $method = $this->method;
        $this->class->$method();
        return $this;
    }

    public function message()
    {
        return json_encode($this->class->message(), 
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}

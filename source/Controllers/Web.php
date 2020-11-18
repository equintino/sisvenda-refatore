<?php

namespace Source\Controllers;

use Source\Classes\Version;
use Source\Config\Config;
//use Source\Models\Group;
use Source\Controllers\Traits\ConfigTrait;

class Web extends Controller
{
    use ConfigTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function start(): void
    {
        $version = new Version();
        $this->setConfig(new Config());
        $config = $this->getConfig();
        //$connectionList = array_keys((new Config())->getFile());
        $connectionList = array_keys($config->getFile());
        $login = filter_input(INPUT_COOKIE, "login", FILTER_SANITIZE_STRIPPED);
        $connectionName= filter_input(INPUT_COOKIE, "connectionName", FILTER_SANITIZE_STRIPPED);
        $checked = filter_input(INPUT_COOKIE, "remember", FILTER_SANITIZE_STRIPPED);

        $this->view->setPath("public")->render("login", [
                compact("version","connectionList","login","connectionName","checked")
            ]);
    }

    public function home(): void
    {
        $title = [ "title" => "Sistema de Venda" ];
        $shortcut = [ "shortcut" => theme("asset/img/logo.png") ];
        $page = [ "page" => "home" ];
        $loading = [ "loading" => theme("asset/img/logo-menu.gif") ];
        $this->view->insertTheme(
                compact("title","shortcut","page","loading")
            );
        $this->view->render("home");
    }

    public function error($data): void
    {
        $errcode = [ "errcode" => $data["errcode"] ];
        $title = [ "title" => "Erro ao carregar página" ];
        $this->view->insertTheme(compact("title"));
        $this->view->render("error", compact("errcode"));
    }
}

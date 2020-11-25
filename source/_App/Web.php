<?php

namespace Source\_App;

use Source\Support\Version;
use Source\Config\Config;

use Source\Traits\ConfigTrait;

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
        $config = $this->config();
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
        $head = $this->seo(
            CONF_SITE_NAME . " - " . CONF_SITE_TITLE,
            CONF_SITE_DESC,
            url(),
            theme("assets/img/loading.png")
        );

        $title = [ "title" => "Sistema de Venda" ];
        $shortcut = [ "shortcut" => theme("assets/img/logo.png") ];
        $page = [ "page" => "home" ];
        $loading = [ "loading" => theme("assets/img/logo-menu.gif") ];
        $this->view->insertTheme(
                compact("shortcut","page","loading","head")
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

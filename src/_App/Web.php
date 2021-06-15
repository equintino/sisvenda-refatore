<?php

namespace _App;

use Config\Config;
use Traits\ConfigTrait;

class Web extends Controller
{
    use ConfigTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function start(): void
    {
        $version = $this->version();
        $config = $this->config();
        $connectionList = array_keys($config->getFile());
        $login = filter_input(INPUT_COOKIE, "login", FILTER_SANITIZE_STRIPPED);
        $connectionName= filter_input(INPUT_COOKIE, "connectionName", FILTER_SANITIZE_STRIPPED);
        $checked = filter_input(INPUT_COOKIE, "remember", FILTER_SANITIZE_STRIPPED);

        $this->view->setPath("public")->render("login", [
                compact("version","connectionList","login","connectionName","checked")
            ]);
    }

    public function init(): void
    {
        //echo "<script>var login='" . ucfirst($_SESSION["login"]->Logon) . "'</script>";
        $this->view->insertTheme();
        //$this->view->render("home");
    }

    public function home(): void
    {
        $page = "home";
        echo "<script>var login='" . ucfirst($_SESSION["login"]->Logon) . "'</script>";
        // $this->view->insertTheme([
        //         compact("page")
        //     ]);
        $this->view->render("home");
    }

    public function error($data): void
    {
        $errcode = $data["errcode"];
        $title = "Erro ao carregar página";
        //$this->view->insertTheme([ compact("title") ]);
        $this->view->render("error", [ compact("errcode") ]);
    }

    public function version(): string
    {
        $file = __DIR__ . "/../../version";
        if(file_exists($file)) {
            foreach(file($file) as $row) {
                if(!preg_match("/^#/", $row)) {
                    return $row;
                }
            }
        }
    }
}

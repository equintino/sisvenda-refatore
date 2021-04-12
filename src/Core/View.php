<?php

namespace Core;

use Models\Group;
//use Controllers\Web;

class View
{
    private $path;
    private $access;
    public $theme;

    public function __construct(string $theme = null)
    {
        $this->theme = $theme;
        $this->path  = __DIR__ . "/../pages";
        $this->validate();
    }

    public function setPath(string $path): View
    {
        $this->path = __DIR__ . "/../{$path}";
        return $this;
    }

    public function render(string $page, array $params = [])
    {
        if(empty($_SESSION["login"])) {
            alertLatch("Necessário entrar novamente", "var(--cor-danger)");
        }

        /** makes variables available to the page */
        if($params) {
            foreach($params as $param) {
                if(!empty($param)) {
                    foreach($param as $key => $values) {
                        $$key = $values;
                    }
                }
            }
        }

        if(!strpos($this->path, "Modals") && !empty($this->access) && !$this->restrictAccess($page)) {
            return print("<h5 align='center' style='color: var(--cor-primary)'>Acesso Restrito</h5>");
        }

        require $this->path . "/{$page}.php";
    }

    public function insertTheme(array $params = null, string $path = null)
    {
        /** makes variables available to the page */
        if($params) {
            foreach($params as $var => $param) {
                if(!empty($param)) {
                    foreach($param as $key => $values) {
                        $$key = $values;
                    }
                }
            }
        }
        $access = $this->access;

        require (!empty($path) ? $path : $this->theme . "/_theme.php");
    }

    public function validate(): void
    {
        if(!empty($_SESSION) && array_key_exists("login", $_SESSION)) {
            $login = $_SESSION["login"];
        }
        /** allows or prohibits access */
        if(!empty($login) && $login->Group_id) {
            $screens = str_replace(" ","",(new Group())->load($login->Group_id)->access);
            $this->access = explode(",", $screens);
        }
    }

    private function restrictAccess(string $page): bool
    {
        if(in_array("*", $this->access) || $page === "home" || $page === "error") {
            return true;
        }
        foreach($this->access as $screen) {
            if(trim($page) !== $screen) {
                return false;
            }
        }
    }
}

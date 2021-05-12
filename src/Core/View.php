<?php

namespace Core;

use Models\Group;

class View
{
    private $path;
    private $access = [];
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
        $logged = $_SESSION["login"]->Logon ?? null;
        if(empty($logged)) {
            alertLatch("Necessário entrar novamente", "var(--cor-danger)");
        } else {
            echo "<script>var logged = '{$logged}'</script>";
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
            $screens = (new Group())->load($login->Group_id)->access;
            foreach(explode(",", $screens) as $screen) {
                array_push($this->access, trim($screen));
            }
        }
    }

    private function restrictAccess(string $page): bool
    {
        if(in_array("*", $this->access) || $page === "home" || $page === "error" || in_array(Safety::renameScreen($page), $this->access)) {
            return true;
        }
        return false;
    }
}

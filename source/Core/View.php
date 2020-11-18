<?php

namespace Source\Core;

use Source\Models\Group;
use Source\Controllers\Web;

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

        if(!strpos($this->path, "Modals") && !empty($this->access) && !in_array(" {$page}", $this->access)) {
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
        require (!empty($path) ? $path : $this->theme . "/theme.php");
    }

    public function validate(): void
    {
        if(!empty($_SESSION) && array_key_exists("login", $_SESSION)) {
            $login = $_SESSION["login"];
        }
        /** allows or prohibits access */
        $group = new Group();
        if(!empty($login) && $login->Group_id) {
            $this->access = explode(",", $group->load($login->Group_id)->access);
        }
    }
}

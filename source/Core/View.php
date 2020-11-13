<?php

namespace Source\Core;

use Source\Models\Group;

class View
{
    private $path = __DIR__ . "/../pages";
    private $access;
    public $theme;

    public function __construct(string $theme = null, string $path = "pages")
    {
        $this->theme = $theme;
        $this->path = __DIR__ . "/../{$path}";
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

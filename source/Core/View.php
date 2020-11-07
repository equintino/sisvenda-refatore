<?php

namespace Source\Core;

use Source\Classes\Version;
use Source\Config\Config;
use Source\Models\Group;

class View
{
    const BASE_DIR = __DIR__ . "/../pages";
    private $access;
    public $theme;

    public function __construct(string $theme = null)
    {
        $this->theme = $theme;
        $this->validate();
    }

    public function start()
    {
        $version =  new Version();
        $login = filter_input(INPUT_COOKIE, "login", FILTER_SANITIZE_STRIPPED);
        $connectionName = filter_input(INPUT_COOKIE, "connectionName", FILTER_SANITIZE_STRIPPED);
        $checked = filter_input(INPUT_COOKIE, "remember", FILTER_SANITIZE_STRIPPED);
        $connectionList = array_keys((new Config())->getFile());

        include self::BASE_DIR . "/index.php";
    }

    public function render(string $page, array $params = [])
    {
        /** makes variables available to the page */
        if($params) {
            for($x = 0; $x < count($params); $x++) {
                if(!empty($params[$x])) {
                    foreach($params[$x] as $key => $param) {
                        $$key = $param;
                    }
                }
            }
        }

        require self::BASE_DIR . "/{$page}.php";
    }

    public function insertTheme(array $params = null, string $path = null)
    {
        /** makes variables available to the page */
        if($params) {
            for($x = 0; $x < count($params); $x++) {
                if(!empty($params[$x])) {
                    foreach($params[$x] as $key => $param) {
                        $$key = $param;
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
        $group = new Group();
        if(!empty($login) && $login->Group_id) {
            $this->access = explode(",", $group->load($login->Group_id)->access);
        }
    }
}

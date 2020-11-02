<?php

namespace Source\Core;

use Source\Classes\Version;
use Source\Config\Config;

class View
{
    const BASE_DIR = __DIR__ . "/../pages";
    private $page;
    private $params;

    public function __construct(string $page = "home", array $params = [])
    {
        $this->page = $page;
        $this->params = $params;
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

    public function show()
    {
        /** makes variables available to the page */
        for($x = 0; $x < count($this->params); $x++) {
            foreach($this->params[$x] as $key => $param) {
                $$key = $param;
            }
        }
        include self::BASE_DIR . "/{$this->page}.php";
    }

}

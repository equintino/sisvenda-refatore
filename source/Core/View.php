<?php

namespace Source\Core;

class View
{
    const BASE_DIR = __DIR__ . "/../pages";
    private $page;
    private $params;

    public function __construct(string $page, array $params = [])
    {
        $this->page = $page;
        $this->params = $params;
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

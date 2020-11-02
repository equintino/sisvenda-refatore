<?php

namespace Source\Controllers;

class Web extends Controller
{
    private $theme;

    public function __construct(string $theme = "layout/index.php")
    {
        $this->theme = $theme;

    }

    public function theme($bool = true)
    {
        if($bool) {
            require __DIR__ . "/../{$this->theme}";
        }
    }
}

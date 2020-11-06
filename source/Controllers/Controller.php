<?php

namespace Source\Controllers;

use Source\Models\Group;
use Source\Core\View;

abstract class Controller
{
    protected $view;
    protected $seo;

    protected $theme;

    public function __construct()
    {
        $this->view = new View();
    }

    protected function getPost($data) {
        foreach($data as $key => $value) {
            $params[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRIPPED);
        }
        return $params;
    }
}

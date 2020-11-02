<?php

namespace Source\Controllers;

use Source\Models\Group;

abstract class Controller
{
    protected $theme;

    public function __construct()
    {
        $this->theme = new Web();
        
        /** Restricted access */
        if(!empty($this->page)) {
            $access = $this->theme->getAccess();
            if(!in_array(" *", $access) && !in_array($this->page, $access)) {
                die("<h2 class='title' style='text-align:center'>Acesso restrito</h2>");
            }
        }
    }
}

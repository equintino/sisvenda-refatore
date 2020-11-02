<?php

namespace Source\Controllers;

abstract class Controller
{
    public function __construct()
    {
        /** Restricted access */
        if(!empty($this->page)) {
            $access = (new Web())->theme()->validate();
            if(!in_array(" *", $access) && !in_array($this->page, $access)) {
                die("<h2 class='title' style='text-align:center'>Acesso restrito</h2>");
            }
        }
    }
}

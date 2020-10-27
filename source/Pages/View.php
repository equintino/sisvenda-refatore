<?php

namespace Source\Pages;

class View
{
    public function home()
    {
        include __DIR__ . "/home.php";
    }

    public function login()
    {
        include __DIR__ . "/login.php";
    }

    public function shield($groups, $screens)
    {
        include __DIR__ . "/shield.php";
    }

    public function config($config)
    {
        include __DIR__ . "/config.php";
    }

}

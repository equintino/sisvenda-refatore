<?php

namespace Source\_App;

class Auth extends Controller
{
    public function login(): void
    {
        if(!empty($_SESSION["login"])) {
            header("Location: " . url());
        }
        (new Web())->start();
    }

    public function forget(): void
    {

    }

    public function register(): void
    {

    }
}

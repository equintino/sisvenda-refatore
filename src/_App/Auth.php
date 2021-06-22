<?php

namespace _App;

class Auth extends Controller
{
    public function login(): void
    {
        if(!empty($_SESSION["login"])) {
            header("Location: " . url());
        }
        (new Web())->start();
    }

    public function token()
    {
        return print(json_decode("estou aqui"));
        //$this->view->setPath("Modals")->render("token");
    }

    public function forget(): void
    {

    }

    public function register(): void
    {

    }
}

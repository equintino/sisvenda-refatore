<?php

namespace Source\Controllers;

use Source\Models\Group;

class Web extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function home(): void
    {
        $title = [ "title" => "Sistema de Venda" ];
        $shortcut = [ "shortcut" => "../asset/img/logo.png" ];
        $page = [ "page" => "home" ];
        $loading = [ "loading" => "../asset/img/logo-menu.gif" ];
        $this->view->insertTheme([ $title, $shortcut, $page, $loading ]);
        $this->view->render("home");
    }

    public function error($data): void
    {
        $errcode = [ "errcode" => $data["errcode"] ];
        $title = [ "title" => "Erro ao carregar página" ];
        $this->view->insertTheme([ $title ]);
        $this->view->render("error", [ $errcode ]);
    }
}

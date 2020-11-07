<?php

namespace Source\Controllers;

use Source\Models\Group;

class Web extends Controller
{
    //public $theme = __DIR__ . "/../layout/index.php";
    //private $access;

    public function __construct()
    {
        parent::__construct();
    }

    public function home(): void
    {
        $title = [ "title" => "Sistema de Venda" ];
        $shortcut = [ "shortcut" => "../web/img/logo.png" ];
        $page = [ "page" => "home" ];
        $loading = [ "loading" => "../web/img/logo-menu.gif" ];
        $this->view->insertTheme([ $title, $shortcut, $page, $loading ]);
        $this->view->render("home");
    }

    public function error($data): void
    {
        $errcode = [ "errcode" => $data["errcode"] ];
        $title = [ "title" => "Erro ao carregar página" ];
        $path = __DIR__ . "/../layout/index.php";
        $this->view->insertTheme([ $title ], $path);
        $this->view->render("error", [ $errcode ]);
    }

    public function show()
    {
        //$access = $this->access;
        //$this->view->theme(__DIR__ . "/../layout/index.php");
        //require $this->theme;
    }

    // public function getAccess(): ?array
    // {
    //     return $this->access;
    // }
}

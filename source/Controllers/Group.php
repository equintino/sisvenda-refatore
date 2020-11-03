<?php

namespace Source\Controllers;

class Group extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add()
    {
        include __DIR__  . "/../Modals/group.php";
    }
}

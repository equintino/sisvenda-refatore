<?php

namespace Source\Controllers;

use Source\Models\Group;

class Web extends Controller
{
    private $theme;
    public $access;

    public function __construct(string $theme = "layout/index.php")
    {
        $this->theme = $theme;

    }

    public function theme($bool = true)
    {
        $access = $this->validate();
        if($bool) {
            require __DIR__ . "/../{$this->theme}";
        }
        return $this;
    }

    public function validate(): ?array
    {
        $login = $_SESSION["login"];
        $group = new Group();
        if($login->Group_id) {
            return explode(",", $group->load($login->Group_id)->access);
        }
        return [];
    }
}

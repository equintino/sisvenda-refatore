<?php

namespace Source\Controllers;

use Source\Models\Group;

class Web extends Controller
{
    public $theme = __DIR__ . "/../layout/index.php";
    private $access;

    public function __construct()
    {
        $this->validate();
    }

    public function show()
    {
        $access = $this->access;
        require $this->theme;
    }

    public function validate(): void
    {
        $login = $_SESSION["login"];
        $group = new Group();
        if($login->Group_id) {
            $this->access = explode(",", $group->load($login->Group_id)->access);
        }
    }

    public function getAccess(): ?array
    {
        return $this->access;
    }
}

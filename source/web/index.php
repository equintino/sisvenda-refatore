<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../Support/Helpers.php";

$session = new Core\Session();

if(!empty($_SESSION["login"])) {
    require __DIR__ . "/../layout/index.php";
}
else {
    header("Location:../../index.php");
}

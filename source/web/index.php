<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../Support/Helpers.php";

use Source\Core\Route;
use Source\Core\Session;

$session = new Session();

if(!empty($_SESSION["login"])) {
    require __DIR__ . "/../layout/index.php";

    Route::get("/", "Page:home");
    Route::get("/login", "Page:login");
    Route::get("/seguranca", "Page:shield");
    Route::get("/configuracao", "Page:config");
    Route::get("/sair", "Page:exit");

    Route::get("/editar", "User:edit");
    Route::get("/rotas", function() {
        var_dump(Route::routes());
    });

}
else {
    header("Location:../../index.php");
}

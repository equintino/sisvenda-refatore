<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../Support/Helpers.php";

use Source\Core\Route;
use Source\Core\Session;

$session = new Session();

if(!empty($_SESSION["login"])) {
    require __DIR__ . "/../layout/index.php";

    Route::get("/", "Panel:dashboard");
    Route::get("/login", "User:init");
    Route::get("/seguranca", "Shield:list");
    Route::get("/configuracao", "Config:list");
    Route::get("/sair", function() {
        (new Session())->destroy();
        echo "<script>window.location.reload()</script>";
    });

    Route::get("/editar", "User:edit");
    Route::get("/rotas", function() {
        var_dump(Route::routes());
    });
}
else {
    header("Location:../../index.php");
}

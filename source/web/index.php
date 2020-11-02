<?php

ob_start();

require __DIR__ . "/../../vendor/autoload.php";

use Source\Core\Route;
use Source\Core\Session;

$session = new Session();

if(!empty($_SESSION["login"])) {
    Route::get(url("/"), "Panel:dashboard");
    Route::get(url("/login"), "User:init");
    Route::get(url("/seguranca"), "Shield:list");
    Route::get(url("/configuracao"), "Config:list");
    Route::get(url("/add"), "Config:add");
    Route::get(url("/edit"), "Config:edit");
    Route::get(url("/sair"), function() {
        (new Session())->destroy();
        echo "<script>window.location.reload()</script>";
    });

    Route::get(url("/rotas"), function() {
        var_dump(Route::routes());
    });

}
else {
    header("Location:../../index.php");
}

ob_end_flush();

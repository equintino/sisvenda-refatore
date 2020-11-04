<?php

ob_start();

require __DIR__ . "/../../vendor/autoload.php";

use Source\Core\Route;
use Source\Core\Session;

$session = new Session();

if(!empty($_SESSION["login"])) {
    Route::group("Panel");
    Route::get(url("/"), "Panel:dashboard");

    Route::group("User");
    Route::get(url("/login"), "User:init");
    Route::get(url("/list-login"), "User:list");
    Route::get(url("/add-login"), "User:add");
    Route::get(url("/edit-login"), "User:edit");
    Route::get(url("/save-login"), "User:save");
    Route::get(url("/delete-login"), "User:delete");

    Route::group("Shield");
    Route::get(url("/seguranca"), "Shield:list");

    Route::group("Group");
    Route::get(url("/add-group"), "Group:add");
    Route::get(url("/load-group"), "Group:load");
    Route::get(url("/save-group"), "Group:save");

    Route::group("Config");
    Route::get(url("/configuracao"), "Config:list");
    Route::get(url("/add-config"), "Config:add");
    Route::get(url("/edit-config"), "Config:edit");
    Route::get(url("/save-config"), "Config:save");
    Route::get(url("/update-config"), "Config:update");
    Route::get(url("/delete-config"), "Config:delete");

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

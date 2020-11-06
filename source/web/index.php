<?php

ob_start();

require __DIR__ . "/../../vendor/autoload.php";

use CoffeeCode\Router\Router;

use Source\Core\Route;
use Source\Core\Session;

$session = new Session();

if(!empty($_SESSION["login"])) {
    $router = new Router(url(), ":");

    /**
     * Web Routes
     */
    $router->namespace("Source\Controllers");
    $router->get("/", "Web:home");

    $router->get("/login", "User:init");
    $router->get("/list-login", "User:list");
    $router->get("/add-login", "User:add");
    $router->get("/edit-login", "User:edit");

    $router->get("/save-login", "User:save");/** testar */
    $router->get("/delete-login", "User:delete");/** testar */

    $router->get("/seguranca", "Shield:list");

    $router->get("/add-group", "Group:add");
    $router->get("/load-group", "Group:load");/** testar */
    $router->get("/save-group", "Group:save");/** testar */

    $router->get("/configuracao", "Config:list");
    $router->get("/add-config", "Config:add");
    $router->get("/edit-config", "Config:edit");
    $router->get("/save-config", "Config:save");/** testar */
    $router->get("/update-config", "Config:update");/** testar */
    $router->get("/delete-config", "Config:delete");/** testar */

    $router->get("/sair", function() {
        (new Session())->destroy();
        echo "<script>window.location.reload()</script>";
    });

    /**
     * Error Routes
     */
    $router->namespace("Source\Controllers")->group("/ops");
    $router->get("/{errcode}", "Web:error");


    /**
     * Routes
     */
    $router->dispatch();


    /**
     * Error Redirect
     */
    if($router->error()) {
        $router->redirect("/ops/{$router->error()}");
    }




    //Route::group("Panel");
    //Route::get(url("/"), "Panel:dashboard");

    // Route::group("User");
    // Route::get(url("/login"), "User:init");
    // Route::get(url("/list-login"), "User:list");
    // Route::get(url("/add-login"), "User:add");
    // Route::get(url("/edit-login"), "User:edit");
    // Route::get(url("/save-login"), "User:save");
    // Route::get(url("/delete-login"), "User:delete");

    // Route::group("Shield");
    // Route::get(url("/seguranca"), "Shield:list");

    // Route::group("Group");
    // Route::get(url("/add-group"), "Group:add");
    // Route::get(url("/load-group"), "Group:load");
    // Route::get(url("/save-group"), "Group:save");

    // Route::group("Config");
    // Route::get(url("/configuracao"), "Config:list");
    // Route::get(url("/add-config"), "Config:add");
    // Route::get(url("/edit-config"), "Config:edit");
    // Route::get(url("/save-config"), "Config:save");
    // Route::get(url("/update-config"), "Config:update");
    // Route::get(url("/delete-config"), "Config:delete");

    // Route::get(url("/sair"), function() {
    //     (new Session())->destroy();
    //     echo "<script>window.location.reload()</script>";
    // });

    // Route::get(url("/rotas"), function() {
    //     var_dump(Route::routes());
    // });

}
else {
    header("Location:../../index.php");
}

ob_end_flush();

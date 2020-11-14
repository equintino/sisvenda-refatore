<?php
    ob_start();

    require __DIR__ . "/vendor/autoload.php";

    use CoffeeCode\Router\Router;
    use Source\Core\Session;
    use Source\Controllers\Web;

    $session = new Session();
    $router = new Router(url(), ":");

    if(!empty($_SESSION["login"])) {
        /**
         * Web Routes
         */
        $router->namespace("Source\Controllers");
        $router->get("/home", "Web:home");
        $router->get("/", "Web:home");

        $router->get("/login", "User:init");
        $router->get("/list-login", "User:list");
        $router->get("/add-login", "User:add");
        $router->get("/edit-login", "User:edit");
        $router->post("/save-login", "User:save");
        $router->post("/update-login", "User:update");
        $router->post("/delete-login", "User:delete");
        $router->post("/reset-login", "User:reset");

        $router->get("/seguranca", "Shield:list");

        $router->get("/add-group", "Group:add");
        $router->post("/load-group", "Group:load");
        $router->post("/save-group", "Group:save");
        $router->post("/update-group", "Group:update");
        $router->post("/delete-group", "Group:delete");

        $router->get("/configuracao", "Config:list");
        $router->get("/add-config", "Config:add");
        $router->get("/edit-config", "Config:edit");
        $router->post("/save-config", "Config:save");
        $router->post("/update-config", "Config:update");
        $router->post("/delete-config", "Config:delete");

        $router->get("/sair", function() {
            (new Session())->destroy();
            echo "<script>window.location.assign('" . url() . "')</script>";
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
    }
    else{
        (new Web())->start();
    }

    ob_end_flush();

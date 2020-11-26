<?php
    ob_start();

    require __DIR__ . "/vendor/autoload.php";

    use CoffeeCode\Router\Router;
    use Source\Core\Session;
    use Source\_App\Web;

    $session = new Session();
    $router = new Router(url(), ":");

    if(!empty($_SESSION["login"])) {
        /**
         * Web Routes
         */
        $router->namespace("Source\_App");
        $router->get("/home", "Web:home");
        $router->get("/", "Web:home");

        /**
         * The Users' Screens
         */
        $router->namespace("Source\_App");
        $router->get("/login", "User:init");
        $router->get("/login/empresa/{companyId}", "User:init");
        $router->get("/lista/usuarios/empresa/{companyId}", "User:list");
        $router->get("/usuario/cadastro", "User:add");
        $router->get("/usuario/{login}", "User:edit");
        $router->post("/exclui/{login}", "User:delete");
        $router->post("/senha/reseta", "User:reset");
        $router->post("/usuario/update", "User:update");
        $router->post("/usuario/save", "User:save");


        /**
         * The Groups' Screens
         */
        $router->namespace("Source\_App");
        $router->get("/seguranca", "Group:list");
        $router->get("/grupo/cadastro", "Group:add");
        $router->post("/grupo/{name}", "Group:load");
        $router->post("/grupo/save", "Group:save");
        $router->post("/grupo/exclui/{name}", "Group:delete");
        $router->post("/grupo/update", "Group:update");


        /**
         * The Config's Screens
         */
        $router->namespace("Source\_App");
        $router->get("/configuracao", "Config:list");
        $router->get("/configuracao/cadastro", "Config:add");
        $router->get("/configuracao/editar/{connectionName}", "Config:edit");
        $router->post("/configuracao/salvar", "Config:save");
        $router->post("/configuracao/atualizar", "Config:update");
        $router->post("/configuracao/excluir/{connectionName}", "Config:delete");


        /**
         * Enter
         */
        $router->namespace("Source\_App");
        $router->get("/entrar", "Auth:login");
        $router->get("/recuperar", "Auth:forget");
        $router->get("/cadastrar", "Auth:register");


        /**
         * Logout
         */
        $router->get("/sair", function() {
            (new Session())->destroy();
            echo "<script>window.location.assign('" . url() . "')</script>";
        });


        /**
         * Error Routes
         */
        $router->namespace("Source\_App")->group("/ops");
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

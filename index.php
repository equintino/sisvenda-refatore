<?php
    ob_start();

    require __DIR__ . "/vendor/autoload.php";

    use CoffeeCode\Router\Router;
    use Core\Session;
    use _App\Web;

    $session = new Session();
    $router = new Router(url(), ":");

    if(!empty($_SESSION["login"])) {
        /**  Web Routes */
        $router->namespace("_App");
        $router->get("/home", "Web:home");
        $router->get("/", "Web:init");


        /**  The Users' Screens */
        $router->namespace("_App");
        $router->get("/login", "User:init");
        $router->get("/login/empresa/{companyId}", "User:init");
        $router->get("/lista/usuarios/empresa/{companyId}", "User:list");
        $router->get("/usuario/cadastro", "User:add");
        $router->get("/usuario/{login}", "User:edit");
        $router->post("/exclui/{login}", "User:delete");
        $router->post("/senha/reseta", "User:reset");
        $router->post("/usuario/update", "User:update");
        $router->post("/usuario/save", "User:save");


        /** The Groups' Screens */
        $router->namespace("_App");
        $router->get("/shield", "Group:list");
        $router->get("/grupo/cadastro", "Group:add");
        $router->post("/grupo/{name}", "Group:load");
        $router->post("/grupo/save", "Group:save");
        $router->post("/grupo/exclui/{name}", "Group:delete");
        $router->post("/grupo/update", "Group:update");


        /** The Config's Screens */
        $router->namespace("_App");
        $router->get("/config", "Config:list");
        $router->get("/configuracao/cadastro", "Config:add");
        $router->get("/configuracao/editar/{connectionName}", "Config:edit");
        $router->post("/configuracao/salvar", "Config:save");
        $router->post("/configuracao/atualizar", "Config:update");
        $router->post("/configuracao/excluir/{connectionName}", "Config:delete");


        /** The Register's Screens */
        $router->namespace("_App");
        $router->get("/cliente", "Register:init");
        $router->post("/cadastro/{}", "Register:load");
        $router->post("/cadastro/atualizar", "Register:update");
        $router->post("/cadastro/salvar", "Register:save");
        $router->get("/transportadora", "Register:transport");
        $router->post("/transportadora/{}", "Register:loadTransport");
        $router->post("/transportadora/atualizar", "Register:updateTransport");
        $router->post("/transportadora/salvar", "Register:saveTransport");
        $router->get("/fornecedor", "Register:supplier");
        $router->post("/fornecedor/{}", "Register:loadSupplier");
        $router->post("/fornecedor/atualizar", "Register:updateSupplier");
        $router->post("/fornecedor/salvar", "Register:saveSupplier");


        /** The Budget's Screens */
        $router->namespace("_App");
        $router->get("/orcamento", "Budget:init");


        /** The Management's Screens */
        $router->get("/gerenciamento", "Management:init");
        $router->get("/vendas", "Management:sale");


        /** Searching data */
        $router->post("/transport/id/{}", "Register:getIdTransport");
        $router->post("/company", "Company:list");
        $router->post("/saleman", "Saleman:load");
        $router->post("/sale", "Sale:init");
        $router->post("/sale/update", "Sale:update");
        $router->post("/sale/delete", "Sale:delete");
        $router->post("/produto", "Product:load");
        $router->post("/transport", "Transport:list");
        /** client/search */
        $router->post("/client/{}", "Client:getClient");
        $router->post("/clients", "Client:list");


        /** Images */
        $router->post("/percent", "Image:percent");
        $router->post("/removeFile/file/{file}", "Image:removeFile");


        /**  Modals */
        $router->get("/image/{id}", "FileRegistration:init");
        $router->get("/image/id/{id}", "FileRegistration:loadImage");
        $router->post("/image/delete/{id}", "FileRegistration:delete");
        $router->post("/print/40", "PrintDoc:init40");
        $router->post("/print/80", "PrintDoc:init80");
        $router->post("/client", "Client:init");
        $router->post("/clientes", "Client:view");


        /** Enter */
        $router->namespace("_App");
        $router->get("/entrar", "Auth:login");
        $router->post("/token/save", "Auth:token");
        $router->get("/recuperar", "Auth:forget");
        $router->get("/cadastrar", "Auth:register");


        /** Logout */
        $router->get("/sair", function() {
            (new Session())->destroy();
            echo "<script>window.location.assign('" . url() . "')</script>";
        });


        /** Error Routes */
        $router->namespace("_App")->group("/ops");
        $router->get("/{errcode}", "Web:error");


        /** Routes */
        $router->dispatch();


        /**  Error Redirect */
        if($router->error()) {
            $router->redirect("../ops/{$router->error()}");
        }

    } else {
        (new Web())->start();
    }

    ob_end_flush();

<!DOCTYPE html>
<html>
    <head>
        <title>Sistema Estruturado de Venda</title>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="source/web/img/logo.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="source/web/css/style.css" rel="stylesheet"/>
        <link href="source/web/css/datatables.css" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <?php
            require __DIR__ . "/vendor/autoload.php";

            use Source\Core\View;
            (new View())->start(); ?>
    </head>
</html>

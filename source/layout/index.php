<!DOCTYPE html>
<html>
    <head>
        <title>Sistema Estruturado de Venda</title>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="../web/img/logo.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../web/css/style.css" rel="stylesheet"/>
        <link href="../web/css/datatables.css" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <script type="text/javascript" src="../web/js/datatables.js"></script>
        <script type="text/javascript" src="../web/js/bootbox.js"></script>


        <!--<link href="https://fonts.googleapis.com/css?family=Open+Sans|Source+Code+Pro&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="../web/css/jquery.modal.min.css" />


        <script src="../web/js/jquery-3.3.1.min.js" type="text/javascript" >
        </script>
        <!--<script src="../web/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="../web/js/datatables.min.js">
        </script>

        <script type="text/javascript" src="../web/js/jquery.mask.js"></script>
        <script type="text/javascript" src="../web/js/qrcode.js" ></script>-->

        <!-- Modal -->
        <!--<script src="../web/js/jquery.modal.min.js"></script>-->

        <?php $page = array_key_exists("pagina",$_GET) ? $_GET['pagina'] : "home"; ?>
    </head>
    <?php
        // include __DIR__ . "/../includes/aguarde.php";
        // include __DIR__ . "/../includes/cache.php";
        // require __DIR__ . "/../../vendor/autoload.php";

        // $search->setArray(array("Logon" => $_SESSION['login']));
        // $dUser = tbUser()->find($search)->first();

        // $search->setArray(array("id" => $dUser->getArray()["Group_id"]));
        // $dGroup = tbGroup()->find($search)->first();

        // $access = $dGroup->getArray()["access"];

        // if($access) {
        //     $paginas = explode(',',$access);
        // }
    ?>
    <body class="body">
        <div id="top"><?php require __DIR__ . "/top.php"; ?></div>
        <div class="content">
            <section class="loading">
                <img class="schedule" src="../web/img/loading.png" alt="reading" height="50px"/>
            </section>
            <p class="text-loading">Texto da ação "loading"</p>
            <div id="flashes">aqui vai sua mensagem...</div>


            <!--<?php if(!empty($access)): ?>
                <?php if(in_array($page, $pages) || $page === 'home' ):
                    include __DIR__ . "/../Pages/" . $page . ".php"; ?>
                <?php else:?>
                    <h3 style="text-align:center;color:#196430;"><i class="fa fa-ban" style="color:red"></i> Acesso não Permitido.</h3>
                <?php endif; ?>
            <?php else:?>
                <?php require __DIR__ . "/../Pages/" . $page . ".php"; ?>
            <?php endif; ?>-->


            <!-- Janelas -->
            <div id="boxe_main" >
                <div id="title"></div>
                <span id="button" class="close"><i class="fa fa-times-circle"></i></span>
                <span id="message"></span>
                <div id="content"></div>
            </div>
            <div id="mask_main"></div>

            <!-- caixa de dialogo -->
            <div id="div_dialogo" >
                <div class="title"></div>
                <span id="message"></span>
            </div>

            <!-- relatório do banco -->
            <div id='ajax' style="display: none">
                <div><h5>Relatório de Resposta do Banco de Dados</h5></div>
                <table id='tabAjax' class='display'></table>
            </div>

        </div><!-- content -->
        <script>var page = "<?= $page ?>";</script>
        <script type="text/javascript" src="../web/js/functions.js"></script>
        <script type="text/javascript" src="../web/js/script.js"></script>
        <script type="text/javascript" src="../web/js/jquery.js"></script>
    </body>
</html>

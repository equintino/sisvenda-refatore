<!DOCTYPE html>
<html>
    <head>
        <title><?= ( $title ?? "Sistema Estruturado de Venda" ) ?></title>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="<?= theme("web/img/logo.png") ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?= theme("web/css/style.css") ?>" rel="stylesheet"/>
        <link href="<?= theme("web/css/datatables.css") ?>" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <script type="text/javascript" src="<?= theme("web/js/datatables.js") ?>"></script>
        <script type="text/javascript" src="<?= theme("web/js/bootbox.js") ?>"></script>
    </head>
    <body class="body">
        <div id="top"><?php require __DIR__ . "/top.php"; ?></div>
        <div class="content">
            <section class="loading">
                <img class="schedule" src="<?= theme("web/img/loading.png") ?>" alt="reading" height="50px"/>
            </section>
            <p class="text-loading">Texto da ação "loading"</p>
            <div id="flashes">aqui vai sua mensagem...</div>


            <!--<?php if(!empty($access)): ?>
                <?php if(in_array($page, $pages) || $page === 'home' ):
                    include __DIR__ . "/../pages/" . $page . ".php"; ?>
                <?php else:?>
                    <h3 style="text-align:center;color:#196430;"><i class="fa fa-ban" style="color:red"></i> Acesso não Permitido.</h3>
                <?php endif; ?>
            <?php else:?>
                <?php require __DIR__ . "/../pages/" . $page . ".php"; ?>
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

        <span id="alert"></span>
        </div><!-- content -->
        <script>var page = "<?= $page ?>";</script>
        <script type="text/javascript" src="<?= theme("web/js/functions.js") ?>" ></script>
        <script type="text/javascript" src="<?= theme("web/js/script.js") ?>" ></script>
    </body>
</html>

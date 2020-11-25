<!DOCTYPE html>
<html>
    <head>
        <title><?= ( $title ?? "Sistema Estruturado de Venda" ) ?></title>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="<?= theme("assets/img/logo.png") ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="<?= theme("assets/style.css") ?>" rel="stylesheet"/>
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    </head>
    <body class="body">
        <!-- <header> -->
            <div id="top">
                <?php require __DIR__ . "/top.php"; ?>
            </div>
        <!-- </header> -->
        <div class="content">
            <section class="loading">
                <img class="schedule" src="<?= theme("assets/img/loading.png") ?>" alt="reading" height="50px"/>
                <p class="text-loading">Texto da ação "loading"</p>
            </section>

            <!-- Janelas -->
            <div id="mask_main"></div>

            <section id="boxe_main" >
                <div id="title"></div>
                <span id="button" class="close"><i class="fa fa-times-circle"></i></span>
                <span id="message"></span>
                <div id="content"></div>
            </section>

            <!-- caixa de dialogo -->
            <section id="div_dialogo" >
                <div class="title"></div>
                <span id="message"></span>
            </section>

            <!-- relatório do banco -->
            <section id='ajax' style="display: none">
                <div><h5>Relatório de Resposta do Banco de Dados</h5></div>
                <table id='tabAjax' class='display'></table>
            </section>

            <span id="alert"></span>

        </div><!-- content -->
        <script>var page = "<?= $page ?>";</script>
        <script type="text/javascript" src="<?= theme("assets/scripts.js") ?>" ></script>
    </body>
</html>

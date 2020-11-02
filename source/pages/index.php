<DOCTYPE html>
<html>
    <head>
        <title>Sistema Estruturado de Venda</title>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="source/web/img/logo.png" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php require __DIR__ . "/../../vendor/autoload.php" ?>
    </head>
    <body class="text-center gradient">
        <div class="mask"></div>
        <div id="flashes"></div>
        <div class="logo"></div>
        <div class="container">
            <div class="login">
                <form class="form-signin" action="#" method="post" >
                    <div class="input-group mt-2">
                        <i class="fa fa-user icon-input" ></i>
                        <input type="text" id="login" class="form-input" name="login" placeholder="login ou e-mail" required="" autofocus="" value="<?= (!empty($login) ? $login : null) ?>" />
                    </div>
                    <div class="input-group">
                        <i class="fa fa-key icon-input"></i>
                        <input id="password" type="password" class="form-input" name="password" placeholder="Senha" />
                    </div>
                    <div class="input-group">
                        <i class="fa fa-building icon-input"></i>
                        <select id="connection-name" class="form-input" name="connection-name" placeholder="Conexão" required />
                            <option value=""></option>
                            <?php foreach($connectionList as $local):
                                $selected = ($local === $connectionName ? "selected" : null)?>
                            <option value="<?= $local ?>" <?= $selected ?>><?= $local ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="checkbox m-2">
                        <label><input type="checkbox" name="remember" value="1" <?= ($checked == 1 ? "checked" : null) ?> > Lembre-me</label>
                    </div>
                    <button class="button-style" type="submit">Entrar</button>
                    <p class="mt-1 text-muted">© 2020 <?= (!empty($version) ? "({$version}v)" : null) ?></p>
                </form>
            </div>
        </div>
        <div id="boxe_main"></div>
        <div id="mask_main"></div>
        <script type="text/javascript" src="source/web/js/datatables.js" ></script>
        <script type="text/javascript" src="source/web/js/functions.js"></script>
        <script type="text/javascript" src="source/web/js/script.js" ></script>
    </body>
</html>

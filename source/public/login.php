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
                        <label><input type="checkbox" name="remember" value="1" <?= (!empty($checked) && $checked == 1 ? "checked" : null) ?> > Lembre-me</label>
                    </div>
                    <button class="button-style" type="submit">Entrar</button>
                    <p class="mt-1 text-muted">© 2020 <?= (!empty($version) ? "({$version}v)" : null) ?></p>
                </form>
            </div>
        </div>
        <div id="boxe_main"></div>
        <div id="mask_main"></div>
        <script type="text/javascript" src="source/public/js/datatables.js" ></script>
        <script type="text/javascript" src="source/public/js/functions.js"></script>
        <script type="text/javascript" src="source/public/js/script.js" ></script>
    </body>

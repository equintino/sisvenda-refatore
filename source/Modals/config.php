<form id="config" class="form-horizontal" action="#" method="POST">
    <?php if(!empty($act) && $act === "add"): ?>
    <div class="form-group">
        <label class="label" for="connectionName">Nome da Conexão: </label>
        <input class="form-input" type="text" name="connectionName" required/>
    </div>
    <?php endif; ?>
    <div class="form-group">
        <label class="label" for="type" >Tipo: </label>
        <select class="form-input" name="type" required>
            <option value=""></option>
            <option value="mysql" <?= (!empty($connectionName) && $config->type() === "mysql" ? "selected" : null) ?>>mysql</option>
            <option value="sqlsrv" <?= (!empty($connectionName) && $config->type() === "sqlsrv" ? "selected" : null) ?>>sqlsrv</option>
        </select>
    </div>
    <div class="form-group">
        <label class="label" for="address">Endereço IP/Porta(000.000.000.000,0000): </label>
        <input class="form-input" type="text" name="address" value="<?= (!empty($connectionName) ? $config->address() : null) ?>" autocomplete="off" required/>
    </div>
    <div class="form-group">
        <label class="label" for="database">Nome do Banco: </label>
        <input class="form-input" type="text" name="database" value="<?= (isset($connectionName) ? $config->database() : null) ?>" autocomplete="off" required/>
    </div>
    <div class="form-group">
        <label class="label" for="user">Usuário do Banco: </label>
        <input class="form-input" type="text" name="user" value="<?= (isset($connectionName) ? $config->user() : null) ?>" autocomplete="off" required/>
    </div>
    <?php if(!isset($connectionName)): ?>
    <div class="form-group">
        <label class="label" for="passwd">Senha: </label>
        <input class="form-input" type="password" name="passwd" autocomplete="off" />
    </div>
    <?php endif ?>
    <div style="text-align: right">
        <button class="button save" >Save</button>
    </div>
</form>

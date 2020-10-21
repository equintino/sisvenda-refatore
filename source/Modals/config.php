<?php

require __DIR__ . "/../../vendor/autoload.php";

$connectionName = filter_input(INPUT_GET, "connectionName", FILTER_SANITIZE_STRIPPED);
$act = filter_input(INPUT_GET, "act", FILTER_SANITIZE_STRIPPED);
$config = new Config\Config();
$config->local = ($act !== "add" ? $connectionName : null); ?>

<form id="config" class="form-horizontal" action="#" method="POST">
    <?php if($act === "add"): ?>
    <div class="form-group">
        <label class="label" for="connectionName">Nome da Conexão: </label>
        <input class="form-input" type="text" name="connectionName" />
    </div>
    <?php endif; ?>
    <div class="form-group">
        <label class="label" for="type" >Tipo: </label>
        <select class="form-input" name="type">
            <option value=""></option>
            <option value="mysql" <?= (!empty($connectionName) && $config->type() === "mysql" ? "selected" : null) ?>>mysql</option>
            <option value="sqlsrv" <?= (!empty($connectionName) && $config->type() === "sqlsrv" ? "selected" : null) ?>>sqlsrv</option>
        </select>
    </div>
    <div class="form-group">
        <label class="label" for="address">Endereço IP/Porta(000.000.000.000,0000): </label>
        <input class="form-input" type="text" name="address" value="<?= (!empty($connectionName) ? $config->address() : null) ?>" autocomplete="off" />
    </div>
    <div class="form-group">
        <label class="label" for="database">Nome do Banco: </label>
        <input class="form-input" type="text" name="database" value="<?= (isset($connectionName) ? $config->database() : null) ?>" autocomplete="off" />
    </div>
    <div class="form-group">
        <label class="label" for="user">Usuário do Banco: </label>
        <input class="form-input" type="text" name="user" value="<?= (isset($connectionName) ? $config->user() : null) ?>" autocomplete="off" />
    </div>
    <div class="form-group">
        <label class="label" for="passwd">Senha: </label>
        <input class="form-input" type="password" name="passwd" autocomplete="off" />
    </div>
    <div style="text-align: right">
        <button class="button save" >Save</button>
    </div>
</form>

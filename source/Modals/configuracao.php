<?php

require __DIR__ . "/../../vendor/autoload.php";

$connectionName = filter_input(INPUT_GET, "connectionName", FILTER_SANITIZE_STRIPPED);
$config = new Config\Config();
$config->local = $connectionName; ?>

<form id="config" class="form-horizontal" action="#" method="POST">
    <div class="form-group">
        <label class="label" for="type" >Tipo: </label>
        <select class="form-input" name="type">
            <option value="mysql" <?= ($config->type() === "mysql" ? "selected" : null) ?>>mysql</option>
            <option value="sqlsrv" <?= ($config->type() === "sqlsrv" ? "selected" : null) ?>>sqlsrv</option>
        </select>
    </div>
    <div class="form-group">
        <label class="label" for="address">Endereço IP/Porta(000.000.000.000,0000): </label>
        <input class="form-input" type="text" name="address" value="<?= $config->address() ?>" autocomplete="off" />
    </div>
    <div class="form-group">
        <label class="label" for="database">Nome do Banco: </label>
        <input class="form-input" type="text" name="database" value="<?= $config->database() ?>" autocomplete="off" />
    </div>
    <div class="form-group">
        <label class="label" for="user">Usuário do Banco: </label>
        <input class="form-input" type="text" name="user" value="<?= $config->user() ?>" autocomplete="off" />
    </div>
    <div class="form-group">
        <label class="label" for="passwd">Senha: </label>
        <input class="form-input" type="password" name="passwd" autocomplete="off" />
    </div>
</form>

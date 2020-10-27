<?php

/** table creation file */
require __DIR__ . "/../autoload.php";

$creation = new Source\Database\CreationProcess();
$creation->define("localMysql");

/** init table tb_usuario */
$user = new Source\Models\User();
var_dump($user->createThisTable());
$data = [
    "Nome" => "Edmilson",
    "Logon" => "edmilson",
    "Senha" => "123",
    "Email" => "edmquintino@gmail.com",
    "IDEmpresa" => 1,
    "Visivel" => 1,
    "USUARIO" => "Edmilson"
];
$user->bootstrap($data);
$user->save();
var_dump(
    $user->message()
);

/** init table tb_group */
$group = new Source\Models\Group();
var_dump(
    $group->createThisTable()
);
$data = [
    "name" => "Administrador",
    "access" => "home,seguranca",
    "active" => 1
];
$group->bootstrap($data);
$group->save();
var_dump($group->message());

/** init table Dados_Empresa */
$company = new Source\Models\Company();
var_dump(
    $company->createThisTable()
);
$data = [
    "NomeFantasia" => "Nome Fantasia",
    "CNPJ" => "56.123.111/1234-25",
    "ATIVO" => 1
];
$company->bootstrap($data);
$company->save();
var_dump(
    $company->message()
);

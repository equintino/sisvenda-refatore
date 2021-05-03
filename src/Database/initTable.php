<?php

/** table creation file */
require __DIR__ . "/../autoload.php";

$creation = new Database\CreationProcess();
$creation->define("local");

/** init table tb_usuario */
$user = new Models\User();
var_dump($user->createThisTable());
$data = [
    "Nome" => "Administrador",
    "Logon" => "admin",
    "Senha" => "admin932",
    "Email" => "edmquintino@gmail.com",
    "IDEmpresa" => 1,
    "Visivel" => 1,
    "USUARIO" => "admin",
    "Group_id" => 1
];
$user->bootstrap($data);
$user->save();
var_dump(
    $user->message()
);

/** init table tb_group */
$group = new Models\Group();
var_dump(
    $group->createThisTable()
);
$data = [
    "name" => "Administrador",
    "access" => " *",
    "active" => 1
];
$group->bootstrap($data);
$group->save();
var_dump($group->message());

/** init table Dados_Empresa */
$company = new Models\Company();
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

/** init table PFisica */
$client = new Models\Client();
var_dump(
    $client->createThisTable()
);
$data = [
    "Nome" => "Edmilson Messias Quintino",
    "CPF" => "956.117.117-15",
    "Email" => "edmquintino@gmail.com"
];
$client->bootstrap($data);
$client->save();
var_dump(
    $client->message()
);

/** init table PJuridica */
$legalPerson = new Models\LegalPerson();
var_dump(
    $legalPerson->createThisTable()
);
$data = [
    "NomeFantasia" => "Minha Empresa",
    "CNPJ" => "11.117.117/0001-15",
    "Email" => "empresa@gmail.com"
];
$legalPerson->bootstrap($data);
$legalPerson->save();
var_dump(
    $legalPerson->message()
);

/** init table Transportadora */
$transport = new Models\Transport();
var_dump(
    $transport->createThisTable()
);
$data = [
    "RasSocial" => "SEM FRETE",
    "Cnpj" => "",
    "IDEmpresa" => 1
];
$transport->bootstrap($data);
$transport->save();
var_dump(
    $transport->message()
);

/** init table Fornecedor */
$supplier = new Models\Supplier();
var_dump(
    $supplier->createThisTable()
);
$data = [
    "RasSocial" => "Minha Empresa",
    "CNPJ" => "11.117.117/0001-15",
    "Email" => "empresa@gmail.com"
];
$supplier->bootstrap($data);
$supplier->save();
var_dump(
    $supplier->message()
);

/** init table Configs */
// $config = new Source\Models\Config();
// var_dump(
//     $config->createThisTable()
// );
// $data = [
//     "name" => "local",
//     "type" => "mysql",
//     "address" => "localhost",
//     "db" => "teste",
//     "user" => "root",
//     "passwd" => ""
// ];
// $config->bootstrap($data);
// $config->save();
// var_dump(
//     $config->message()
// );

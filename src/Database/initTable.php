<?php

/** table creation file */
require_once __DIR__ . "/../Support/FileTransation.php";
require_once __DIR__ . "/../Boot/Helpers.php";
require __DIR__ . "/../autoload.php";

$session = new Core\Session();
$creation = new Database\CreationProcess();
$creation->define("local");

/** init table tb_usuario */
$user = new Models\User();
$user->createThisTable();
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
echo "tb_usuario - " . $user->message() . "<br>";

/** init table tb_group */
$group = new Models\Group();
$group->createThisTable();
$data = [
    "name" => "Administrador",
    "access" => " *",
    "active" => 1
];
$group->bootstrap($data);
$group->save();
echo "tb_group - " . $group->message() . "<br>";

/** init table Dados_Empresa */
$company = new Models\Company();
$company->createThisTable();
$data = [
    "NomeFantasia" => "Nome Fantasia",
    "CNPJ" => "56.123.111/1234-25",
    "ATIVO" => 1
];
$company->bootstrap($data);
$company->save();
echo "Dados_Empresa - " . $company->message() . "<br>";

/** init table PFisica */
$client = new Models\Client();
$client->createThisTable();
$data = [
    "Nome" => "Edmilson Messias Quintino",
    "CPF" => "956.117.117-15",
    "Email" => "edmquintino@gmail.com"
];
$client->bootstrap($data);
$client->save();
echo "PFisica - " . $client->message() . "<br>";

/** init table PJuridica */
$legalPerson = new Models\LegalPerson();
$legalPerson->createThisTable();
$data = [
    "NomeFantasia" => "Minha Empresa",
    "CNPJ" => "11.117.117/0001-15",
    "Email" => "empresa@gmail.com"
];
$legalPerson->bootstrap($data);
$legalPerson->save();
echo "PJuridica - " . $legalPerson->message() . "<br>";

/** init table Transportadora */
$transport = new Models\Transport();
$transport->createThisTable();
$data = [
    "RasSocial" => "SEM FRETE",
    "Cnpj" => " ",
    "IDEmpresa" => 1,
    "Contato" => "Sem Contato"
];
$transport->bootstrap($data);
$transport->save();
echo "Transportadora - " . $transport->message() . "<br>";

/** init table Fornecedor */
$supplier = new Models\Supplier();
$supplier->createThisTable();
$data = [
    "RasSocial" => "Minha Empresa",
    "CNPJ" => "11.117.117/0001-15",
    "Email" => "empresa@gmail.com"
];
$supplier->bootstrap($data);
$supplier->save();
echo "Fornecedor - " . $supplier->message() . "<br>";

/** init table Vendedor */
$saleman = new Models\Saleman();
$saleman->createThisTable();
$data = [
    "LogON" => "edmilson",
    "Senha" => "123",
    "Email" => "vendedor@gmail.com",
    "IDEmpresa" => "1"
];
$saleman->bootstrap($data);
$saleman->save();
echo "Vendedor - " . $saleman->message() . "<br>";

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

<?php

/** table creation file */
require __DIR__ . "/../source/autoload.php";

$creation = new Test\CreationTableTest("localMysql");

//die("altere os nomes das tabelas antes de rodar os testes e depois comente esta linha");

/** table test_user */
$table = new Source\Models\User();
$table::$entity = "test_users";
$data = [
    "Logon" => "edmilson",
    "Senha" => "123",
    "IDEmpresa" => 1,
    "Visivel" => 1,
    "USUARIO" => "Edmilson",
    "Nome" => "Edmilson Messias Quintino",
    "Email" => "edmquintino@gmail.com"
];
$search = [
    "Logon", "Email"
];
echo "<p>Teste tabela usuarios</p>";
$creation->testTable($table, $data, $search);

//////// -------/////////

/** table test_group */
$table = new Source\Models\Group();
$table::$entity = "test_groups";
$data = [
    "name" => "Administrador",
    "access" => "home,cadastro,seguranca",
    "active" => 1
];
$search = [
    "name"
];
echo "<p>Teste tabela grupos</p>";
$creation->testTable($table, $data, $search);

//////// -------/////////


/** table test_Dados_Empresa */
$table = new Source\Models\Company();
$table::$entity = "test_Dados_Empresa";
$data = [
    //"ID" => "Administrador",
    //"RasãoSocial" => "Minha Empresa",
    "NomeFantasia" => "Nome Fantasia",
    "CNPJ" => "12.123.255/1231-54",
    "ATIVO" => true
];
$search = [
    "CNPJ"
];
echo "<p>Teste tabela Dados_Empresa</p>";
$creation->testTable($table, $data, $search);

//////// -------/////////


/** table test_configs */
// $table = new Source\Models\Config();
// $table::$entity = "test_configs";
// $data = [
//     "name" => "teste",
//     "type" => "sqlsrv:Server",
//     "address" => "localhost",
//     "db" => "teste",
//     "user" => "admin"
// ];
// $search = [
//     "name"
// ];
// echo "<p>Teste tabela configs</p>";
// $creation->testTable($table, $data, $search);

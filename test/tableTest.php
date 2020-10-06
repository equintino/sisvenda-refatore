<?php

/** table creation file */
require __DIR__ . "/../source/autoload.php";

$creation = new Test\CreationTableTest("localMysql");

die("altere os nomes das tabelas antes de rodar os testes e depois comente esta linha");

/** table test_user */
$table = new Models\User();
$data = [
    "Logon" => "edmilson",
    "Senha" => "123",
    "IDEmpresa" => 1,
    "Visivel" => 1,
    "USUARIO" => "Edmilson",
    "Nome" => "Edmilson Messias Quintino",
    "Email" => "edmquintino@gmail.com"
];
$busca = [
    "Logon", "Email"
];
echo "<p>Teste tabela usuarios</p>";
$creation->testTable($table, $data, $busca);

//////// -------/////////

/** table test_group */
$table = new Models\Group();
$data = [
    "name" => "Administrador",
    "access" => "home,cadastro,seguranca",
    "active" => 1
];
$busca = [
    "name"
];
echo "<p>Teste tabela grupos</p>";
$creation->testTable($table, $data, $busca);

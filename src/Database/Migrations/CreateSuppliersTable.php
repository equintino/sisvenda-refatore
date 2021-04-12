<?php

namespace Database\Migrations;

use Config\Config;
use Database\CreateTable;
use Database\Schema;
use Database\Blueprint;

class CreateSuppliersTable implements CreateTable
{
    private $type;

    public function __construct()
    {
        $this->type = (new Config())->type();
    }

    public function up(string $entity): string
    {
        $schema = Schema::create($entity, $this->type, function(Blueprint $table) {
            $table->increment("ID");
            $table->string("CNPJ");
            $table->string("NomeFantasia,RasSocial,InscEsdatual,Atividade,Contato")->nullable();
            $table->string("Rua,Num,Complemento,Cep,Bairro,Cidade")->nullable();
            $table->string("UF",2)->nullable();
            $table->string("Fax,Tel01,Tel02,Email,HomePage")->nullable();
            $table->int("IDEmpresa")->default(1);
            $table->timestamps();
            return $table->run();
        });

        return $schema;
    }

    public function down(string $entity)
    {
        return Schema::dropIfExists($entity, $this->type);
    }
}

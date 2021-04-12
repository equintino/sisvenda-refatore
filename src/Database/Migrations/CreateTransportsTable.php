<?php

namespace Database\Migrations;

use Config\Config;
use Database\CreateTable;
use Database\Schema;
use Database\Blueprint;

class CreateTransportsTable implements CreateTable
{
    private $type;

    public function __construct()
    {
        $this->type = (new Config())->type();
    }

    public function up(string $entity): string
    {
        $schema = Schema::create($entity, $this->type, function(Blueprint $table) {
            $table->increment("IDTransportadora");
            $table->string("Cnpj");
            $table->string("RasSocial,InscEsdatual,Contato")->nullable();
            $table->bool("ATIVO")->nullable()->default(1);
            $table->string("Rua,Num,Complemento,CEP,Bairro,Cidade")->nullable();
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

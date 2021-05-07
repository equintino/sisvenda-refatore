<?php

namespace Database\Migrations;

use Config\Config;
use Database\CreateTable;
use Database\Schema;
use Database\Blueprint;

class CreateClientsTable implements CreateTable
{
    private $type;

    public function __construct()
    {
        $this->type = (new Config())->type();
    }

    public function up(string $entity): string
    {
        $schema = Schema::create($entity, $this->type, function(Blueprint $table) {
            $table->increment("id");
            $table->int("ID_PFISICA");
            $table->string("Nome,CPF")->nullable();
            $table->date("DataNasc")->nullable();
            $table->string("Rua,Num,Complemento,CEP,Bairro,Cidade")->nullable();
            $table->string("Sexo,EstCivil")->nullable();
            $table->string("Situação")->default("BOM")->nullable();
            $table->string("UF",2)->nullable();
            $table->string("TelResid,Celular,Email")->nullable();
            $table->bool("StatusAtivo")->default(1)->nullable();
            $table->int("IDEmpresa")->default(1);
            $table->int("IDTransportadora")->nullable();
            $table->int("Vendedor")->nullable();
            $table->string("Bloqueio,Conceito")->nullable();
            $table->bool("Revenda")->nullable();
            $table->decimal("Crédito",18,4)->nullable();
            $table->decimal("Salário",18,4)->nullable();
            $table->bool("BloqueioAVista,BloqueioAPrazo,OBSVENDA")->nullable();
            $table->int("CFOPe,CFOPs")->nullable();
            $table->bool("PersonalizaE,PersonalizaS,EspePagamento,ECF,consumidorFinal")->nullable();
            $table->datetime("DataReg")->nullable();
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

<?php

namespace Database\Migrations;

use Config\Config;
use Database\CreateTable;
use Database\Schema;
use Database\Blueprint;

class CreateClientsTable2 implements CreateTable
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
            $table->int("ID_PJURIDICA");
            $table->string("CNPJ");
            $table->string("RasSocial,NomeFantasia,InscEstadual,Contato,Atividade")->nullable();
            $table->string("Sócio01")->nullable();
            $table->bool("StatusAtivo")->nullable()->default(1);
            $table->string("Rua,Num,Complemento,CEP,Bairro,Cidade")->nullable();
            $table->string("UF",2)->nullable();
            $table->string("FAX,Tel01,Tel02,Email,HomePage")->nullable();
            $table->string("Bloqueio,Conceito")->nullable();
            $table->bool("Revenda")->nullable();
            $table->decimal("Crédito",18,4)->nullable();
            $table->string("Situação")->default("BOM")->nullable();
            $table->bool("BloqueioAVista,BloqueioAPrazo,OBSVENDA")->nullable();
            $table->int("IDEmpresa")->default(1);
            $table->int("IDTransportadora")->nullable();
            $table->int("Vendedor")->nullable();
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

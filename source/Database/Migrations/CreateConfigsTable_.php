<?php

namespace Source\Database\Migrations;

use Source\Config\Config;
use Source\Database\CreateTable;
use Source\Database\Schema;
use Source\Database\Blueprint;

class CreateConfigsTable implements CreateTable
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
            $table->string("name",50)->unique();
            $table->string("type,address,db,user");
            $table->string("passwd")->nullable();
            $table->bool("active")->nullable()->default(1);
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

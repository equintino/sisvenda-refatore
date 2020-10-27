<?php

namespace Source\Database\Migrations;

use Source\Config\Config;
use Source\Database\CreateTable;
use Source\Database\Schema;
use Source\Database\Blueprint;

class CreateGroupsTable implements CreateTable
{
    private $type;

    public function __construct()
    {
        $this->type = (new Config())->type();
    }

    public function up(string $entity)
    {
        $schema = Schema::create($entity, $this->type, function(Blueprint $table) {
            $table->increment("id");
            $table->string("name",100)->unique();
            $table->string("access")->nullable()->default("home");
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

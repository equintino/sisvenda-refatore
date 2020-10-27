<?php

namespace Source\Database;

interface CreateTable
{
    public function __construct();
    public function up(string $entity);
    public function down(string $entity);
}

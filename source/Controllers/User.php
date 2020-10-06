<?php

namespace Controllers;

class User extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new \Models\User();
    }

    public function find(string $login, string $columns = "*"): ?\Models\User
    {
        return $this->user->find($login, $columns);
    }

    public function all(int $limit=30, int $offset=0, string $columns = "*"): ?array
    {
        return $this->user->all($limit, $offset, $columns);
    }

    public function save(): ?\Models\User
    {
        return $this->user->save();
    }
}

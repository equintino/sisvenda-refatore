<?php

namespace Source\Controllers\Traits;

use Source\Models\Group;

trait GroupTrait
{
    private $group;

    public function group()
    {
        return new Group();
    }
}

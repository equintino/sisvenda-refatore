<?php

namespace Source\Traits;

use Source\Models\Group;

trait GroupTrait
{
    private $group;

    public function group()
    {
        return new Group();
    }
}

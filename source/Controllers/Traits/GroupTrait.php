<?php

namespace Source\Controllers\Traits;

use Source\Models\Group;

trait GroupTrait
{
    private $group;

    public function setGroup(Group $group)
    {
        $this->group = $group;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }
}

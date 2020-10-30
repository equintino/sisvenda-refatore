<?php

namespace Source\Controllers;

use Source\Core\View;
use Source\Core\Safety;
use Source\Models\Group;

class Shield extends Controller
{
    public function list()
    {
        $groups["groups"] = (new Group())->all();
        $screens["screens"] = Safety::screens(__DIR__ . "/../pages");
        $params = [ $groups, $screens ];

        (new View("shield", $params))->show();
        echo "<script>var page='shield'</script>";
    }

}

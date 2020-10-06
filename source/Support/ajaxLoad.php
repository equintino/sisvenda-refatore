<?php

require __DIR__ . "/../../vendor/autoload.php";

$groupName = filter_input(INPUT_POST, "groupName", FILTER_SANITIZE_STRIPPED);

$group = new Models\Group();
$dGroup = $group->find("Suporte");
$security["access"] = explode(",",$dGroup->access);
return print(json_encode($security));

<?php

require __DIR__ . "/../../../vendor/autoload.php";

function getPost($data) {
    foreach($data as $key => $value) {
        $params[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRIPPED);
    }
    return $params;
}

$params = (getPost($_POST));

if($params["act"] === "login") {
    $class = new Models\User();
    echo (new Support\AjaxTransaction($class, $params))->saveData();
}

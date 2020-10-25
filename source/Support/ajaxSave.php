<?php

require __DIR__ . "/../../vendor/autoload.php";

function getPost($data) {
    foreach($data as $key => $value) {
        $params[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRIPPED);
    }
    return $params;
}

$params = (getPost($_POST));

/** save configuration file */
if($params["act"] === "connection") {
    if($params["action"] === "add") {
        $data = $params["data"];
        $config = new Config\Config();
        parse_str($data, $connectionName);

        $config->setConfConnection($connectionName["connectionName"], $data);
        $config->confirmSave();
        return print(json_encode($config->message()));
    }
    elseif($params["action"] === "edit" ) {
        $connectionName = $params["connectionName"];
        $data = $params["data"];
        $config = new Config\Config();

        $config->setConfConnection($connectionName, $data);
        $config->save();
        echo json_encode($config->message());
    }
    elseif($params["action"] === "delete") {
        echo json_encode((new Config\Config())->delete($params["connectionName"]));
    }
}
/** modal classes */
elseif($params["act"] === "group") {
    $class = new Models\Group();
    echo (new Classes\AjaxTransaction($class, $params))->saveData();
}
elseif($params["act"] === "login") {
    $class = new Models\User();
    echo (new Classes\AjaxTransaction($class, $params))->saveData();
}

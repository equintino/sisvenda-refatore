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
        $config = new Source\Config\Config();
        parse_str($data, $connectionName);

        $config->setConfConnection($connectionName["connectionName"], $data);
        $config->confirmSave();
        return print(json_encode($config->message()));
    }
    elseif($params["action"] === "edit" ) {
        $connectionName = $params["connectionName"];
        $data = $params["data"];
        $config = new Source\Config\Config();

        $config->setConfConnection($connectionName, $data);
        $config->save();
        echo json_encode($config->message());
    }
    elseif($params["action"] === "delete") {
        $config = new Source\Config\Config();
        $config->delete($params["connectionName"]);
        echo json_encode($config->message());
    }
}
/** modal classes */
elseif($params["act"] === "group") {
    $class = new Source\Models\Group();
    echo (new Source\Classes\AjaxTransaction($class, $params))->saveData();
}
elseif($params["act"] === "login") {
    $class = new Source\Models\User();
    echo (new Source\Classes\AjaxTransaction($class, $params))->saveData();
}

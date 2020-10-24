<?php

require __DIR__ . "/../../vendor/autoload.php";

function getPost($data) {
    foreach($data as $key => $value) {
        $params[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRIPPED);
    }
    return $params;
}

$params = (getPost($_POST));
$act = $params["act"];

/** saving global file */
if($act === "global") {
    $file = __DIR__ . "/../../.env";
    $handle = fopen($file, "r+b");
    $string = "";
    while($row = fgets($handle)) {
        $parter = key($params);
        if(preg_match("/$parter/", $row)) {
            $string .= $parter . "=" . $params[$parter];
        }
        else {
            $string .= $row;
        }
    }

    ftruncate($handle, 0);
    rewind($handle);
    if(!fwrite($handle, $string)) {
        die("Não foi possível alterar o arquivo.");
    }
    else {
        echo json_encode("Arquivo alterado com secesso!");
    }
    fclose($handle);
}
/** save configuration file */
elseif($act === "add") {
    $data = $params["data"];
    $config = new Config\Config();
    parse_str($data, $connectionName);
    
    $config->setConfConnection($connectionName["connectionName"], $data);
    $config->confirmSave();
    echo json_encode($config->message());
}
elseif($act === "edit" ) {
    $connectionName = $params["connectionName"];
    $data = $params["data"];
    $config = new Config\Config();

    $config->setConfConnection($connectionName, $data);
    $config->save();
    echo json_encode($config->message());
}
/** delete configuration */
elseif($act === "delete") {
    echo json_encode((new Config\Config())->delete($params["connectionName"]));
}
elseif($act === "group") {
    $class = new Models\Group();
    echo (new Classes\AjaxTransaction($class, $params))->saveData();
}
elseif($act === "login") {
    $class = new Models\User();
    echo (new Classes\AjaxTransaction($class, $params))->saveData();
}

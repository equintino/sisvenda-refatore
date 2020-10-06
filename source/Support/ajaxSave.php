<?php

require __DIR__ . "/../../vendor/autoload.php";

function getPost($data) {
    foreach($data as $key => $value) {
        $params[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRIPPED);
    }
    return $params;
}

$params = (getPost($_POST));
$group = filter_input_array(INPUT_POST);
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
elseif($act === "connection") {
    $connectionName = $params["connectionName"];
    $data = $params["data"];
    $config = new Config\Config();

    $config->setConfConnection($connectionName, $data);
    echo json_encode($config->save());
}
/** delete configuration */
elseif($act === "delete") {
    echo json_encode((new Config\Config())->delete($params["connectionName"]));
}
elseif($act === "group") {
    $groupName = $group["name"];
    $access = $group["access"];
    
    $group = (new Models\Group())->find($groupName);
    $group->access = implode(",",$access);
    $group->save();
    return print(json_encode($group->message()));
}

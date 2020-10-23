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
    $groupName = (array_key_exists("name", $group) ? $group["name"] : null);
    $access = (array_key_exists("access", $group) ? $group["access"] : ["home"]);
    
    if($group["action"] === "add") {
        $group = new Models\Group();
        $group->bootstrap([
            "name" => $groupName,
            "access" => "home",
            "active" => 1
        ]);
        $group->save();
        return print(json_encode($group->message(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
    elseif($group["action"] === "delete") {
        $group = (new Models\Group())->find($groupName);
        $group->destroy();
        return print(json_encode($group->message(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
    else {
        $dGroup = (new Models\Group())->find($groupName);
        $dGroup->access = implode(",",$access);
        $dGroup->save();
        return print(json_encode($dGroup->message(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}
elseif($act === "login") {
    if($params["action"] === "add") {
        $user = new Models\User();
        unset($params["act"], $params["action"]);
        $params["USUARIO"] = &$params["Logon"];
        $user->bootstrap($params);
        $user->save();
        return print(json_encode($user->message(), 
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
    elseif($params["action"] === "edit") {
        $user = (new Models\User())->find($params["Logon"]);
        $user->Nome = $params["Nome"];
        $user->Email = $params["Email"];
        $user->Cargo = $params["Cargo"];
        $user->Group_id = $params["Group_id"];
        $user->Visivel = $params["Visivel"];
        $user->save();
        return print(json_encode($user->message(), 
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
    elseif($params["action"] === "delete") {
        $user = (new Models\User())->find($params["Logon"]);
        $user->destroy();
        return print(json_encode($user->message(), 
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
    elseif($params["action"] === "reset") {
        $user = (new Models\User())->find($params["Logon"]);
        $user->token();
        return print(json_encode($user->message(),
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
    elseif($params["action"] === "change") {
        $user = (new Models\User())->find($params["login"]);
        $user->Senha = $user->crypt($params["senha"]);
        $user->token = null;
        $user->save();
        return print(json_encode($user->message(),
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}

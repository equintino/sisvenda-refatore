<?php

require __DIR__ . "/../autoload.php";

$login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRIPPED);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRIPPED);
$remember = filter_input(INPUT_POST, "remember", FILTER_SANITIZE_STRIPPED);
$connectionName = filter_input(INPUT_POST, "connection-name", FILTER_SANITIZE_STRIPPED);
$globalEnv = new Config\GlobalEnv();

/** global connection configuration */
$globalEnv->setLocal($connectionName);

if($globalEnv->getLocal()) {
    $user = (new Models\User())->find($login);

    if($user) {  
        if(!empty($user->token)) {
            return print(json_encode(2));
        }
        if($user->validate($password, $user)) {
            if($remember) {
                $time = time() + 60*60*24*7;
                $user = [
                    "id" => $user->id,
                    "name" => $user->Nome,
                    "login" => $user->Logon,
                    "email" => $user->email,
                    "expire" => $time
                ];
                setcookie("user", http_build_query($user), $time, "/");
                setcookie("login", $login, $time, "/");
                setcookie("connectionName", $connectionName, $time, "/");
                setcookie("remember", 1, $time, "/");
            }
            else {
                setcookie("user", null, 0, "/");
                setcookie("login", null, 0, "/");
                setcookie("connectionName", null, 0, "/");
                setcookie("remember", null, 0, "/");
            }
            (new Core\Session())->setLogin($user);
            return print(json_encode(1));
        }
        return print(json_encode("A senha digitada não confere", JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
    else {
        echo json_encode("Não foi encontrado o login informado ou senha incorreta!", JSON_UNESCAPED_UNICODE);
    }
}
else {
    echo json_encode("Confira o arquivo de configuração", JSON_UNESCAPED_UNICODE);
}

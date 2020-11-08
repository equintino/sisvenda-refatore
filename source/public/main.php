<?php

require __DIR__ . "/../autoload.php";

$login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRIPPED);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRIPPED);
$remember = filter_input(INPUT_POST, "remember", FILTER_SANITIZE_STRIPPED);
$connectionName = filter_input(INPUT_POST, "connection-name", FILTER_SANITIZE_STRIPPED);

$confEnv = (new Source\Classes\FileTransation(".env"))->setLocal($connectionName);

if($confEnv->getLocal()) {
    $user = (new Source\Models\User())->find($login);
    if($user) {
        if(!empty($user->token)) {
            return print(json_encode(2));
        }
        if($user->validate($password, $user)) {
            $names = [ "user", "login", "connectionName", "remember" ];
            $data = [ "id", "Nome", "Logon", "Email" ];
            $cookie = (new Source\Classes\Cookies($names, $data))->setCookies($remember, $user, $connectionName);
            (new Source\Core\Session())->setLogin($user);
            return print(json_encode(1));
        }
        return print(json_encode("A senha digitada não confere",
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
    else {
        echo json_encode("Não foi encontrado o login informado",
            JSON_UNESCAPED_UNICODE);
    }
}
else {
    echo json_encode("Confira o arquivo de configuração(.env)",
        JSON_UNESCAPED_UNICODE);
}

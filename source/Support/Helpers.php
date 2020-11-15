<?php

/**
 * Core
 */
$config = function() {
    return new Source\Config\Config();
};

$globalEnv = function() {
    return new Source\Config\GlobalEnv();
};

$user = function() {
    return new Source\Models\User();
};

$group = function() {
    return new Source\Models\Group();
};

/** cookie */
$cookie = filter_input(INPUT_COOKIE, "svlogin", FILTER_SANITIZE_STRIPPED);
parse_str($cookie, $cookie);

$login = base64_decode(filter_input(INPUT_COOKIE, "login", FILTER_SANITIZE_STRIPPED));
//$password = base64_decode(filter_input(INPUT_COOKIE, "password", FILTER_SANITIZE_STRIPPED));
//$remember = filter_input(INPUT_COOKIE, "remember", FILTER_SANITIZE_STRIPPED);

/** set constants */
(new Source\Classes\FileTransation(".env"))->getConst();

/** url */
function url(string $path = "/"): string
{
    if(!$path) {
        return CONF_URL_TEST;
    }
    return CONF_URL_TEST . "/" . str_replace("/", "", $path);
};

function theme(string $path)
{
    if(preg_match("/ops/", $_SERVER["REQUEST_URI"])) {
        return "../themes/" . CONF_VIEW_THEME . "/{$path}";
    }
    else {
        return "themes/" . CONF_VIEW_THEME . "/{$path}";
    }
}

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

/** set constants */
(new Source\Support\FileTransation(".env"))->getConst();

/** message */
function alertLatch(string $text, string $background) {
    echo "<script>alertLatch('{$text}', '{$background}')</script>";
}

/** url */
function url(string $path = "/"): string
{
    if(!$path) {
        return CONF_URL_TEST;
    }
    return CONF_URL_TEST . "/" . str_replace("/", "", $path);
};

function url_back(): string
{
    return $_SERVER["HTTP_REFERER"] ?? url();
}

function theme(string $path)
{
    if(preg_match("/ops/", $_SERVER["REQUEST_URI"])) {
        return "../themes/" . CONF_VIEW_THEME . "/{$path}";
    }
    else {
        return "themes/" . CONF_VIEW_THEME . "/{$path}";
    }
}

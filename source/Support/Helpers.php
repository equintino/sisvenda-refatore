<?php

/**
 * Core
 */
$config = function() {
    return new Config\Config();
};

$globalEnv = function() {
    return new Config\GlobalEnv();
};

$user = function() {
    return new Models\User();
};

$group = function() {
    return new Models\Group();
};

/** cookie */
$cookie = filter_input(INPUT_COOKIE, "svlogin", FILTER_SANITIZE_STRIPPED);
parse_str($cookie, $cookie);

$login = base64_decode(filter_input(INPUT_COOKIE, "login", FILTER_SANITIZE_STRIPPED));
//$password = base64_decode(filter_input(INPUT_COOKIE, "password", FILTER_SANITIZE_STRIPPED));
//$remember = filter_input(INPUT_COOKIE, "remember", FILTER_SANITIZE_STRIPPED);

/** set constants */
(new Classes\FileTransation(".env"))->getConst();

/** Pages access */
$getScreens = function($path) {
    $directory = dir($path);
    while($file = $directory->read()) {
        if($file !==  "." && $file !== "..") {
            $screens[] = substr($file, 0, -4);
        }
    }
    return $screens;
};

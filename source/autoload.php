<?php

spl_autoload_register(function($class) {
    $basedir = __DIR__ . "/";
    $namespace = "Source/";
    $file = $basedir . str_replace("\\","/", substr($class, strlen($namespace))) . ".php";
    if(file_exists($file)) require $file;
});

require __DIR__ . "/../test/CreationTableTest.php";

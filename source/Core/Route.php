<?php

namespace Source\Core;

class Route
{
    protected static $route;
    protected $urlBase = CONF_URL_BASE;
    private static $separator = ":";
    private static $group;

    public static function get(string $route, $handler): void
    {
        // $route = substr($route, (strripos($route, "/")));
        // preg_match_all("~\{\s* ([a-zA-Z_][a-zA-Z0-9_-]*) \}~x", $route, $keys, PREG_SET_ORDER);

        // $route = (!$this->group ? $route : "/{$this->group}{$route}");

        $get = "/" . filter_input(INPUT_GET, "url", FILTER_SANITIZE_SPECIAL_CHARS);
        self::$route = [
            $route => [
                "route" => $route,
                "controller" => (!is_string($handler) ? $handler : strstr($handler, self::$separator, true)),
                "method" => (!is_string($handler) ?: str_replace(self::$separator,"", strstr($handler, self::$separator, false)))
            ]
        ];

        self::dispatch($get);
    }

    public static function dispatch($route): void
    {
        $route = self::$route[$route] ?? [];

        if($route) {
            if($route["controller"] instanceof \closure) {
                call_user_func($route["controller"]);
                return;
            }

            $controller = self::namespace() . $route["controller"];
            $method = $route["method"];

            if(class_exists($controller)) {
                $newController = new $controller();
                if(method_exists($newController, $method)) {
                    $newController->$method();
                }
            }
        }
    }

    public static function routes(): array
    {
        return self::$route;
    }

    public static function group(string $group)
    {
        self::$group = $group;
    }

    public static function redirect($url)
    {
        return header("Location: {$url}");
    }

    private static function namespace(string $nameSpace = null): string
    {
        return "Source\Controllers\\";
    }

    // public static function modal(string $route, $handler)
    // {
    //     $get = "/" . filter_input(INPUT_GET, "url", FILTER_SANITIZE_SPECIAL_CHARS);
    //     self::$route = [
    //         $route => [
    //             "route" => $route,
    //             "controller" => (!is_string($handler) ? $handler : strstr($handler, ":", true)),
    //             "method" => (!is_string($handler) ?: str_replace(":","", strstr($handler, ":", false)))
    //         ]
    //     ];

    //     self::dispatch2($get);
    // }

    // public static function dispatch2($route): void
    // {
    //     $route = self::$route[$route] ?? [];

    //     if($route) {
    //         if($route["controller"] instanceof \closure) {
    //             call_user_func($route["controller"]);
    //             return;
    //         }

    //         $controller = self::namespace2() . $route["controller"];
    //         $method = $route["method"];

    //         if(class_exists($controller)) {
    //             $newController = new $controller();
    //             if(method_exists($newController, $method)) {
    //                 $newController->$method();
    //             }
    //         }
    //     }
    // }

    // private static function namespace2(): string
    // {
    //     return "Source\Controllers\\";
    // }
}

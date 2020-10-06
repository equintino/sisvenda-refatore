<?php

namespace Core;

use \PDO;
use \PDOException;

class Connect
{
    private static $data;
    private static $file;

    private const OPTIONS = [
        //PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    private static $instance;

    /**
     * return PDO
     */
    public static function getInstance(): PDO
    {
        $config = self::getData();
        if(empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    $config["dsn"],
                    $config["user"],
                    self::getPasswd($config["passwd"]),
                    self::OPTIONS
                );
            } 
            catch (\PDOException $exception) {
                die("<div>Whoops, houve algum erro ao conectar com o banco!</div>");
                //;(<i style='font-size: .7em'>" . $exception->getMessage() . "</i>)");
            }
        }

        return self::$instance;
    }

    public static function getConfConnection(): string
    {
        if(!defined("CONF_CONNECTION")) {
            return "local";
        }
        return CONF_CONNECTION;
    }

    public static function getPasswd(string $passwd): ?string
    {
        return Safety::decrypt($passwd);
    }

    public static function getData(): ?array
    {
        if(self::$data !== null) {
            return self::$data[self::getConfConnection()];
        }

        self::$data = parse_ini_file(self::getFile(), true);
        return self::$data[self::getConfConnection()];
    }

    public static function getFile()
    {
        if(file_exists(__DIR__ . "/../config/.config.ini")) {
            return self::$file = __DIR__ . "/../config/.config.ini";
        }
        return "Arquivo de configuração não encontrado!";
    }

    final private function __construct()
    {

    }

    final private function __clone()
    {

    }

}

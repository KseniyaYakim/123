<?php

class Singleton
{
    private static $object = null;
    private $pdo = null;

    protected function __construct()
    {
        $host = '127.0.0.1';
        $db = 'childrens';
        $user = 'root';
        $pass = '';
        $charset = 'utf8';
        #require_once "settings.php";

        $dsn = "mysql:host=$host;dbname=$db;charset=utf8";

        $this->pdo=new PDO($dsn, $user, $pass);
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE ,PDO::FETCH_ASSOC);
        $this->pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES,false);
    }

    public function __wakeup() {}

    private function __clone() {}

    public static function getObject()
    {
        if (self::$object == null) {
            self::$object = new static();
        }
        return self::$object;
    }

    static function connection()
    {
        return (static::getObject())->pdo;
    }

    static function prepare($expression)
    {
        return (static::connection())->prepare($expression);
    }

}
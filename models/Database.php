<?php
    namespace models;
    use PDO;

    class Database{
        // properties :
        protected static $db;

        public static function database(){
            if(is_null(static::$db)){
                static::$db = new PDO("mysql:dbname=restaurant;host=localhost;", "root", "");
            }
            return static::$db;
        }
    }  
?>
<?php
    class Autoloader{
        // autoloading static function 
        public static function autoloading() {
            spl_autoload_register(function($class) {
                $filename = __DIR__ . "/" . str_replace("\\", "/", $class) . ".php";
                if (file_exists($filename)) {
                    require_once $filename;
                } else {
                    echo "Autoloader: File not found - $filename<br>"; // Debugging line
                }
            });
        }
    }
    Autoloader::autoloading();
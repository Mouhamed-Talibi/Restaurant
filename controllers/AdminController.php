<?php
    namespace controllers;
    use models\Admin;
    use models\Database;

    class AdminController extends Admin{
        // registration action 
        public static function registerAction(){
            require "views/admin/register.php";
        }
    }
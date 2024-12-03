<?php
    require "Autoloader.php";
    use controllers\AdminController;

    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }
    // switch action :
    switch ($action){
        case "adminRegistration":
            AdminController::registerAction();
            break;
    }

    
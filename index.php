<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/includes/db_connect.php';

session_start();

use App\Controllers\MainController;

$controller = new MainController($conn);
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    case 'login':
        $controller->login();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'dashboard':
        $controller->dashboard();
        break;
    case 'register':
        $controller->register();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'edit':
        $controller->editUser();
        break;
        case 'daftarMarkah':
            $controller->daftarMarkah();
            break;
    default:
        $controller->home();
        break;
}

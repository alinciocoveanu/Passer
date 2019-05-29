<?php
define('DS8', DIRECTORY_SEPARATOR);
define('ROOT8', dirname(dirname(__FILE__)));

require_once(ROOT8 . DS8 . 'application' . DS8 . 'models' . DS8 . 'UserModel.php');
require_once(ROOT8 . DS8 . 'application' . DS8 . 'controllers' . DS8 . 'UsersController.php');

function badRequest() {
    http_response_code(400);
    die('400 Bad Request');
}


$op = '';

if(isset($_REQUEST['op']))
    $op = $_REQUEST['op'];
else badRequest();

switch($op) {
    case 'login':
        $userController = new UsersController();
        
        if(isset($_POST['username'], $_POST['password'])) {
            if($userController->logUser($_POST['username'], $_POST['password'])) {
                header("Location:/Passer/application/views/account.php");
            } else {
                header("Location:/Passer/application/views/index.php?err=1");
                badRequest();
            }
        } else {
            header("Location:/Passer/application/views/index.php?err=1");
            badRequest();
        }
        break;

    case 'logout':
        $userController = new UsersController();

        $userController->logout();
        header("Location:/Passer/application/views/index.php");
        break;

    case 'register':
        $userController = new UsersController();

        if(isset($_POST['username'], $_POST['email'], $_POST['password'])) {
            $user = new UserModel($_POST['username'], $_POST['email'], NULL);
            $password = $_POST['password'];

            if($userController->createUser($user, $password)) {
                header("Location:/Passer/application/views/account.php");
            } else {
                header("Location:/Passer/application/views/createAccount.php?err=1");
                badRequest();
            }
        } else {
            header("Location:/Passer/application/views/createAccount.php?err=1");
            badRequest();
        }
        break;

    default:
        http_response_code(404);
        die('404 Not Found');
        break;
}
?>
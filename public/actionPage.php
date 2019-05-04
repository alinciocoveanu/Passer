<?php
define('DS7', DIRECTORY_SEPARATOR);
define('ROOT7', dirname(dirname(__FILE__)));

require_once(ROOT7 . DS7 . 'application' . DS7 . 'models' . DS7 . 'UserModel.php');
require_once(ROOT7 . DS7 . 'application' . DS7 . 'models' . DS7 . 'ItemModel.php');
require_once(ROOT7 . DS7 . 'application' . DS7 . 'controllers' . DS7 . 'ItemsController.php');
require_once(ROOT7 . DS7 . 'application' . DS7 . 'controllers' . DS7 . 'UsersController.php');

@$op = $_REQUEST['op'];

switch($op) {
    case 'login':
        $userController = new UsersController();

        if($userController->logUser($_POST['username'], $_POST['password'])) {
            header("Location:/Passer/application/views/account.php");
        } else
            header("Location:/Passer/application/views/index.php?err=1");
        break;
    case 'logout':
        $userController = new UsersController();
        
        $userController->logout();
        header("Location:/Passer/application/views/index.php");
        break;
    case 'register':
        $userController = new UsersController();
        $user = new UserModel($_POST['username'], $_POST['password'], $_POST['email']);

        if($userController->createUser($user))
        {
            header("Location:/Passer/application/views/account.php");
        }
        else{
            header("Location:/Passer/application/views/createAccount.php?err=1");
        }
        break;
}

?>
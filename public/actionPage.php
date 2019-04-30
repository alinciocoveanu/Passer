<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once(ROOT . DS . 'application' . DS . 'models' . DS . 'UserModel.php');
require_once(ROOT . DS . 'application' . DS . 'models' . DS . 'ItemModel.php');
require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . 'ItemsController.php');
require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . 'UsersController.php');

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
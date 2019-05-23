<?php
define('DS8', DIRECTORY_SEPARATOR);
define('ROOT8', dirname(dirname(__FILE__)));

require_once(ROOT8 . DS8 . 'application' . DS8 . 'models' . DS8 . 'UserModel.php');
require_once(ROOT8 . DS8 . 'application' . DS8 . 'controllers' . DS8 . 'UsersController.php');

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
        $user = new UserModel($_POST['username'], $_POST['email'], $userController->getUserId($_POST['username']));
        $password = $_POST['password'];

        if($userController->createUser($user, $password)) {
            header("Location:/Passer/application/views/account.php");
        } else {
            header("Location:/Passer/application/views/createAccount.php?err=1");
        }
        break;
}
?>
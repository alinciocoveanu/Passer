<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once(ROOT . DS . 'application' . DS . 'models' . DS . 'UserModel.php');
require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . 'UsersController.php');

@$op = $_REQUEST['op'];

switch($op) {
    case 'login':
        $userController = new UserController();
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($userController->logUser($username, $password)) {
            header("Location:/Passer/application/views/account.php");
        } else
            header("Location:/Passer/application/views/index.php?err=1");
        break;
    case 'logout':
        $userController = new UserController();
        
        $userController->logout();
        header("Location:/Passer/application/views/index.php");
        break;
    case 'register':
        $userController = new UserController();
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
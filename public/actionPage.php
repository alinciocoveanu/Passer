<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once(ROOT . DS . 'application' . DS . 'models' . DS . 'UserModel.php');
require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . 'UsersController.php');

@$op = $_REQUEST['op'];

$userController = new UserController();

echo $op;

switch($op) {
    case 'login':
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($userController->logUser($username, $password)) {
            header("Location:/Passer/application/views/account.php");
        } else
            header("Location:/Passer/application/views/index.php?err=1");
        break;
    case 'logout':
        $userController->logout();
        header("Location:/Passer/application/views/index.php");
        break;
}

?>
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
    case 'password':
        $itemController = new ItemsController(NULL);
        $length = 16;
        if(isset($_GET['length']))
            $length = $_GET['length'];
        echo $itemController->generatePassword($length);
        break;
    
    case 'add':
        $userId = $_POST['add_uid'];
        $itemController = new ItemsController($userId);
        $item = new ItemModel($_POST['title'], $_POST['username'], $_POST['password'], $_POST['url'], $_POST['comment'], $_POST['maxTime']);
        $response = $itemController->addItem($item);
        
        if($response) {
            header("Location:/Passer/application/views/account.php");
        } else {
            header("Location:/Passer/application/views/createAccount.php?err=1");
        }
        break;

    case 'edit':
        $userId = $_POST['edit_uid'];
        $itemId = $_POST['edit_id'];
        $itemController = new ItemsController($userId);
        $item = new ItemModel($_POST['title'], $_POST['username'], $_POST['password'], $_POST['url'], $_POST['comment'], $_POST['maxTime']);
        $response = $itemController->editItem($itemId, $item);

        if($response) {
            header("Location:/Passer/application/views/account.php");
        } else {
            header("Location:/Passer/application/views/createAccount.php?err=1");
        }
        break;

    case 'delete':
        $userId = $_POST['del_uid'];
        $itemId = $_POST['del_id'];
        $itemController = new ItemsController($userId);
        $response = $itemController->deleteItem($itemId);

        if($response) {
            header("Location:/Passer/application/views/account.php");
        } else {
            header("Location:/Passer/application/views/createAccount.php?err=1");
        }
        break;

    case 'list':
        $orderType = '';
        if(isset($_GET['orderType'])) {
            $orderType = $_GET['orderType'];
        } else {
            $orderType = "default";
        }
        header("Location:/Passer/application/views/account.php?orderType=" . $orderType);
        break;
}

?>
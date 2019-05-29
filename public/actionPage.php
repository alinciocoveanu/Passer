<?php
define('DS7', DIRECTORY_SEPARATOR);
define('ROOT7', dirname(dirname(__FILE__)));

require_once(ROOT7 . DS7 . 'application' . DS7 . 'models' . DS7 . 'ItemModel.php');
require_once(ROOT7 . DS7 . 'application' . DS7 . 'controllers' . DS7 . 'ItemsController.php');

function badRequest() {
    http_response_code(400);
    echo '400 Bad Request';
}

function forbidden() {
    http_response_code(403);
    die('403 Forbidden');
}

session_start();
if(!isset($_SESSION['user'])) 
    forbidden();

$op = '';

if(isset($_REQUEST['op']))
    $op = $_REQUEST['op'];
else badRequest();

switch($op) {
    case 'password':
        $itemController = new ItemsController(NULL);

        if(isset($_GET['length'])) {
            $length = $_GET['length'];
            echo $itemController->generatePassword($length);
        } 
        else echo $itemController->generatePassword();

        break;
    
    case 'add':
        if(isset($_POST['add_uid'])) {
            $userId = $_POST['add_uid'];
            $itemController = new ItemsController($userId);
            if(isset($_POST['title'], $_POST['username'], $_POST['password'], $_POST['url'], $_POST['comment'], $_POST['maxTime'])) {
                $item = new ItemModel($_POST['title'], $_POST['username'], $_POST['password'], $_POST['url'], $_POST['comment'], $_POST['maxTime']);
                $response = $itemController->addItem($item);
            } else $response = false;
            if($response) {
                header("Location:/Passer/public/actionPage.php?op=list&uid=" . $userId);
            } else 
                badRequest();
                header("Location:/Passer/application/views/account.php?addErr=1");
        } else {
            badRequest();
            header("Location:/Passer/application/views/account.php?addErr=1");
        }

        break;

    case 'edit':
        if(isset($_POST['edit_uid'], $_POST['edit_id'])) {
            $userId = $_POST['edit_uid'];
            $itemId = $_POST['edit_id'];
            $itemController = new ItemsController($userId);
            if(isset($_POST['title'], $_POST['username'], $_POST['password'], $_POST['url'], $_POST['comment'], $_POST['maxTime'])) {
                $item = new ItemModel($_POST['title'], $_POST['username'], $_POST['password'], $_POST['url'], $_POST['comment'], $_POST['maxTime']);
                $response = $itemController->editItem($itemId, $item);
            } else $response = false;
            if($response)
                header("Location:/Passer/public/actionPage.php?op=list&uid=" . $userId);
            else {
                badRequest();
                header("Location:/Passer/application/views/account.php?editErr=1");
            }
        } else {
            badRequest();
            header("Location:/Passer/application/views/account.php?editErr=1"); 
        }

        break;

    case 'delete':
        if(isset($_POST['del_uid'], $_POST['del_id'])) {
            $userId = $_POST['del_uid'];
            $itemId = $_POST['del_id'];
            $itemController = new ItemsController($userId);
            $response = $itemController->deleteItem($itemId);

            if($response) {
                header("Location:/Passer/public/actionPage.php?op=list&uid=" . $userId);
            } else {
                badRequest();
                header("Location:/Passer/application/views/account.php?delErr=1");
            }
        } else {
            badRequest();
            header("Location:/Passer/application/views/account.php?delErr=1");
        }

        break;

    case 'list':
        $orderType = '';
        if(isset($_REQUEST['uid'])) {
            $itemsController = new ItemsController($_REQUEST['uid']);
            if(isset($_REQUEST['orderType'])) {
                $items = $itemsController->getAllItems($_REQUEST['orderType']);
            } else {
                $items = $itemsController->getAllItems('default');
            }
            $_SESSION['items'] = $items;
            header("Location:/Passer/application/views/account.php");
        } else {
            badRequest();
            header("Location:/Passer/application/views/account.php?listErr=1");
        }
        break;

    case 'export':
        if(isset($_POST['uid'], $_POST['format'])) {
            $itemController = new ItemsController($_POST['uid']);
            
            if($itemController->exportItems($_POST['format']) == false) {
                badRequest();
                header("Location:/Passer/application/views/account.php?expErr=1");
            }
        } else {
            badRequest();
            header("Location:/Passer/application/views/account.php?expErr=1");
        }
            
        break;
    
    default:
        http_response_code(404);
        die('404 Not Found');
        break;
}
?>
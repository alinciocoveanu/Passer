<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

require_once(ROOT . DS . 'application' . DS . 'models' . DS . 'ItemModel.php');

class ItemsController {
    
    public function __construct() {
        //
    }

    public function getAllItems() {
        //
    }

    public function getItemById($id) {
        //
    }

    public function deleteItem($id) {
        //
    }

    public function editItem($id) {
        //
    }

    //export CSV/JSON/XML
}
?>
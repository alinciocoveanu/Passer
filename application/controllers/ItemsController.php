<?php
define('DS1', DIRECTORY_SEPARATOR);
define('ROOT1', dirname(dirname(__FILE__)));

require_once(ROOT1 . DS1 . 'models' . DS1 . 'ItemModel.php');

class ItemsController {
    
    private $uid;

    public function __construct($userId) {
        $this->uid = $userId;
    }

    public function getAllItems($orderBy) {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        $order = '';
        switch($orderBy) {
            case "titleAZ": $order = "title asc"; break;
            case "titleZA": $order = "title desc"; break;
            case "domain": $order = "SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(url, '/', 3), '://', -1), '/', 1), '?', 1)"; break;
            case "strength": break; // create mysql function to get password strength http://www.passwordmeter.com/
            case "freq": $order = "frequency(password) desc"; break;
            default: $order = "title asc"; break;
        }
        
        // check if query is ok
        $getQuerry = mysqli_query($db, "select * from items where user_id = " . $this->uid . " AND SYSDATE() <= max_time order by " . $order)
                    or die("Failed to query database: " . mysqli_error($db));

        return $getQuerry;
    }

    public function addItem($itemModel) {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        $title = $itemModel->getTitle();
        $username = $itemModel->getUsername();
        $password = $itemModel->getPassword();
        $url = $itemModel->getUrl();
        $comment = $itemModel->getComment();
        $max_time = $itemModel->getMaxTime();

        $addQuery = mysqli_query($db, "insert into items(item_id, user_id, title, username, password, url, comment, max_time) values(NULL, '$this->uid', '$title', '$username', '$password', '$url', '$comment', '$max_time')")
                    or die("Failed to query database: " . mysqli_error($db));

        return $addQuery;
    }

    public function getItemById($id) {
        // add edit logic
    }

    public function deleteItem($id) {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        $deleteQuerry = mysqli_query($db, "delete from items where item_id = " . $id)
                        or die("Failed to delete from database: " . mysqli_error($db));

        return $deleteQuerry;
    }

    public function editItem($id) {
        //
    }

    //export CSV/JSON/XML
    public function exportItems($type) {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");
        // set data
        $dataQuery = mysqli_query($db, "select * from items where user_id = " . $this->uid . "order by 1 asc");

        switch($type) {
            case "csv": CSVExporter::export($dataQuery);
            case "json": JSONExporter::export($dataQuery);
            case "xml": XMLExporter::export($dataQuery);
        }
    }
}
?>
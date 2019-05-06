<?php
define('DS1', DIRECTORY_SEPARATOR);
define('ROOT1', dirname(dirname(__FILE__)));

require_once(ROOT1 . DS1 . 'models' . DS1 . 'ItemModel.php');

class ItemsController {
    
    private $uid;

    public function __construct($userId) {
        $this->uid = $userId;
    }

    public function getAllItems() {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        $getQuerry = mysqli_query($db, "select * from webpageitems where uid = " . $this->uid . " order by title asc")
                    or die("Failed to query database: " . mysqli_error($db));

        if($getQuerry == false) {
            return false;
        }
        
        // trebuie creat un array de rows
        $result = mysql_fetch_array($getQuerry);

        mysqli_close($db);

        return $result;
    }

    public function getItemById($id) {
        //
    }

    public function deleteItem($id) {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        $deleteQuerry = mysqli_query("delete from webpageitems where item_id = " . $id)
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
        $dataQuery = mysqli_query($db, "select * from webpages where uid = " . $this->uid . "order by 1 asc");

        switch($type) {
            case "csv": CSVExporter::export($dataQuery);
            case "json": JSONExporter::export($dataQuery);
            case "xml": XMLExporter::export($dataQuery);
        }
    }
}
?>
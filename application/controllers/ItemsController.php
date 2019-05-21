<?php
define('DS1', DIRECTORY_SEPARATOR);
define('ROOT1', dirname(dirname(__FILE__)));

require_once(ROOT1 . DS1 . 'models' . DS1 . 'ItemModel.php');

require_once(ROOT1 . DS1 . 'exporters' . DS1 . 'CSVExporter.php');
require_once(ROOT1 . DS1 . 'exporters' . DS1 . 'JSONExporter.php');
require_once(ROOT1 . DS1 . 'exporters' . DS1 . 'XMLExporter.php');

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
            case "strength": $order = "strength(AES_DECRYPT(password, UNHEX(SHA2(username, 512)))) desc"; break;
            case "freq": $order = "frequency(AES_DECRYPT(password, UNHEX(SHA2(username, 512)))) desc"; break;
            default: $order = "title asc"; break;
        }
        
        // check if query is ok
        $getQuerry = mysqli_query($db, "select item_id, user_id, title, username, AES_DECRYPT(password, UNHEX(SHA2(username, 512))) as \"password\", url, comment, max_time from items where user_id = " . $this->uid . " order by " . $order)
                    or die("Failed to query database: " . mysqli_error($db));

        mysqli_close($db);
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

                                                                                                            // AES_ENCRYPT('text', UNHEX(SHA2('My secret passphrase',512)))
        $addQuery = mysqli_query($db, "insert into items(item_id, user_id, title, username, password, url, comment, max_time) values(NULL, '$this->uid', '$title', '$username', AES_ENCRYPT('$password', UNHEX(SHA2('$username', 512))), '$url', '$comment', '$max_time')")
                    or die("Failed to query database: " . mysqli_error($db));

        mysqli_close($db);
        return $addQuery;
    }

    public function generatePassword($length = 16) {
        $pass = '';
        $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = mb_strlen($alphabet, 'utf8') - 1;

        for ($i = 0; $i < $length; $i++) {
            $pass .= $alphabet[random_int(0, $max)];
        }
        
        return $pass;
    }

    public function deleteItem($id) {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        $deleteQuerry = mysqli_query($db, "delete from items where item_id = " . $id)
                        or die("Failed to delete from database: " . mysqli_error($db));

        mysqli_close($db);
        return $deleteQuerry;
    }

    public function editItem($id, $item) {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        $title = $item->getTitle();
        $username = $item->getUsername();
        $password = $item->getPassword();
        $url = $item->getUrl();
        $comment = $item->getComment();
        $max_time = $item->getMaxTime();

        $editQuerry = mysqli_query($db, "update items set title = '$title', username = '$username', 
                        password = AES_ENCRYPT('$password', UNHEX(SHA2('$username', 512))),  url = '$url',  comment = '$comment',
                        max_time = ' $max_time' where item_id = $id")
                        or die("Failed to edit from database: " . mysqli_error($db));

        mysqli_close($db);
        return $editQuerry;
    }

    //export CSV/JSON/XML
    public function exportItems($type) {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");
        // set data
        $dataQuery = mysqli_query($db, "select item_id, user_id, title, username, AES_DECRYPT(password, UNHEX(SHA2(username, 512))) as \"password\", url, comment, max_time from items where user_id = " . $this->uid . " order by username asc")
                        or die("Failed to query database: " . mysqli_error($db));

        switch($type) {
            case "csv": CSVExporter::export($dataQuery, $this->uid); break;
            case "json": JSONExporter::export($dataQuery, $this->uid); break;
            case "xml": XMLExporter::export($dataQuery, $this->uid); break;
        }

        mysqli_close($db);
    }
}
?>
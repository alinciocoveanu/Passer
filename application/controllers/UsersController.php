<?php
define('DS2', DIRECTORY_SEPARATOR);
define('ROOT2', dirname(dirname(__FILE__)));

require_once(ROOT2 . DS2 . 'models' . DS2 . 'UserModel.php');
require_once(ROOT2 . DS2 . 'controllers' . DS2 . 'ItemsController.php');

class UsersController {

    private $encryptionMethod = 'aes-256-cbc';

    public function __construct() {
        
    }

    private function encryptPassword($username, $password) {
        $encryptedPassword = "";

        $key = hash('sha256', $username);
        $encryptionKey = base64_decode($key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->encryptionMethod));
        
        $encryptedPassword = openssl_encrypt($password, $this->encryptionMethod, $encryptionKey, 0, $iv);

        return base64_encode($encryptedPassword . '::' . $iv);
    }

    private function decryptPassword($username, $encryptedPassword) {
        $key = hash('sha256', $username);
        $encryptionKey = base64_decode($key);

        list($encryptedData, $iv) = explode('::', base64_decode($encryptedPassword), 2);

        return openssl_decrypt($encryptedData, $this->encryptionMethod, $encryptionKey, 0, $iv);
    }

    public function getUserId($username) {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        $myQuery = mysqli_query($db, "select user_id from users where username = '$username';");

        if($myQuery == false) {
            return false;
        }

        $id = mysqli_fetch_array($myQuery);
        $id = $id['user_id'];

        mysqli_close($db);
        return $id;
    }

    private function insertUser($user, $password, $email) {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        $rezUser = mysqli_query($db, "insert into users(user_id, username, email) values ('NULL', '$user', '$email');");
        
        if($rezUser == false)
            return false;

        $rezSel = mysqli_query($db, "select user_id from users where username = '$user';");

        $id = mysqli_fetch_array($rezSel);
        $id = $id['user_id'];
        
        $password = $this->encryptPassword($user, $password);
        $rezPass = mysqli_query($db, "insert into passwords(user_id, password) values ('$id', '$password');");       
        
        if($rezPass == false)
            return false;

        mysqli_close($db);
        return new UserModel($user, $email, $id);
    }

    private function authenticate($user, $pass) {
        //connect db
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        //sql injection
        $user = stripcslashes($user);
        $pass = stripcslashes($pass);

        $user = mysqli_escape_string($db, $user);
        $pass = mysqli_escape_string($db, $pass);

        $rezUser = mysqli_query($db, "select * from users where username = '$user'")
                    or die("Failed to querry database ".mysqli_error($db));
        
        $row = mysqli_fetch_array($rezUser);

        if($row['username'] != $user){
            mysqli_close($db);
            return false;
        } 

        $uid = $row['user_id'];

        $rezEmail = $row['email'];
        
        $rezPass = mysqli_query($db, "select * from passwords where user_id = '$uid'")
                    or die("Failed to querry database ".mysqli_error($db));

        $row = mysqli_fetch_array($rezPass);

        $password = $row['password'];
        $password = $this->decryptPassword($user, $password);
        if($password != $pass){
            mysqli_close($db);
            return false;
        }

        $user = new UserModel($user, $rezEmail, $uid);

        mysqli_close($db);
        return $user;
    }

    public function createUser($user, $password) {
        //check db
        $rez = $this->insertUser($user->getUsername(), $password, $user->getEmail());
        if($rez != false) {
            //start the session for the user
            session_start();
            //set the user object to the session
            $_SESSION['user'] = $rez;
            return true;
        }
        return false;
    }

    public function logUser($username, $password) {
        //check db
        $rez = $this->authenticate($username, $password);
        if($rez != false) {
            //start the session for the user
            session_start();
            //set the user object to the session
            $_SESSION['user'] = $rez;
            $itemsController = new ItemsController($this->getUserId($username));
            $items = $itemsController->getAllItems('default');
            $_SESSION['items'] = $items;
            return true;
        }
        return false;
    }

    public function logout() {
        session_start();
        session_destroy();
    }
}

?>
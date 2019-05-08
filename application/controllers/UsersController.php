<?php
define('DS2', DIRECTORY_SEPARATOR);
define('ROOT2', dirname(dirname(__FILE__)));

require_once(ROOT2 . DS2 . 'models' . DS2 . 'UserModel.php');

class UsersController {

    public function __construct() {
        // storing passwords - https://zinoui.com/blog/storing-passwords-securely
        // https://dev.mysql.com/doc/refman/5.5/en/encryption-functions.html#function_aes-decrypt
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
        
        $rezPass = mysqli_query($db, "insert into passwords(user_id, password) values ('$id', '$password');");       
        
        if($rezPass == false)
            return false;

        mysqli_close($db);
        return true;
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

        $rezEmail = $row['email'];
        
        $rezPass = mysqli_query($db, "select * from passwords where password = '$pass'")
                    or die("Failed to querry database ".mysqli_error($db));

        $row = mysqli_fetch_array($rezPass);

        if($row['password'] != $pass){
            mysqli_close($db);
           return false;
        }

        $user = new UserModel($user, $pass, $rezEmail);

        mysqli_close($db);
        return $user;
    }

    public function createUser($user) {
        //check db
        if($this->insertUser($user->getUsername(), $user->getPassword(), $user->getEmail())) {
            //start the session for the user
            session_start();
            //set the user object to the session
            $_SESSION['user'] = $user;
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
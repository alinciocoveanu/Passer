<?php

class UserController {

    function __construct(){
        //
    }

    function insertUser($user, $password, $email)
    {
        $db = mysqli_connect("localhost", "root", "", "aplicatietw");

        $rezUser = mysqli_query($db, "insert into users(user_id, username) values ('NULL', '$user');");
        
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

    function createUser($user, $password, $email){
        //check db
        if($this->insertUser($user, $password, $email)) {
            //start the session for the user
            session_start();
            //instantiate user model
            $user = new UserModel($user);
            //set the user object to the session
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    function logUser($username, $password) {
        //check db
        if($this->authentificate($username, $password)) {
            //start the session for the user
            session_start();
            //instantiate user model
            $user = new UserModel($username);
            //set the user object to the session
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    function authentificate($user, $pass) {
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
        
        $rezPass = mysqli_query($db, "select * from passwords where password = '$pass'")
                    or die("Failed to querry database ".mysqli_error($db));

        $row = mysqli_fetch_array($rezPass);

        if($row['password'] != $pass){
            mysqli_close($db);
           return false;
        }
        
        mysqli_close($db);
        return true;
}

    function logout() {
        session_start();
        session_destroy();
    }
}

?>
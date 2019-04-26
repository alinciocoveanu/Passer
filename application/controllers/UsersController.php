<?php

class UserController {

    function __construct(){
        //
    }

    function createUser($user, $password, $email){
        //create a new user
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
        $ok = false;
        if($user == 'admin' && $pass == 'admin')
            $ok = true;
        return $ok;
    }

    function logout() {
        session_start();
        session_destroy();
    }
}

?>
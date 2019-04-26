<?php

class UserModel {
    private $username;

    function __construct($username) {
        $this->username = $username;
    }

    function getUsername() {
        return $this->username;
    }

    function setUsername($username) {
        $this->username = $username;
    }
}

?>
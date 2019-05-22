<?php

class UserModel {
    private $username, $email, $uid;

    public function __construct($username, $email, $uid) {
        $this->username = $username;
        $this->email = $email;
        $this->uid = $uid;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getUid() {
        return $this->uid;
    }

    public function setUid($uid) {
        $this->uid = $uid;
    }
}

?>
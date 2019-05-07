<?php

class ItemModel {
    private $title, $username, $password, $url, $comment, $maxTime;

    public function __construct($title, $username, $password, $url, $comment, $maxTime)
    {
        $this->title = $title;
        $this->username = $username;
        $this->password = $password;
        $this->url = $url;
        $this->comment = $comment;
        $this->maxTime = $maxTime;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function getMaxTime() {
        return $this->maxTime;
    }

    public function setMaxTime($maxTime) {
        $this->maxTime = $maxTime;
    }
}

?>
<?php

require_once("user.php");

class Account {

    public int $idAccount;
    public string $attr_password;
    public array $avatar;
    public User $user ;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function uploadAvatar() {
        // $upload = new Upload();
        // $upload->runUpload($this->avatar);
    }

    public function hash_pass() {
        return password_hash($this->attr_password, PASSWORD_DEFAULT);
    }
}
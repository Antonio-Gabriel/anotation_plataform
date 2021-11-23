<?php

require_once("./src/entities/user.php");
require_once("./src/entities/account.php");
require_once("./src/entities/contact.php");
require_once("./src/entities/location.php");
require_once("./src/helpers/upload.php");
require_once("./src/repositories/accountRepository.php");

$contact = new Contact();
$contact->contact = 989878777;

$location = new Location();
$location->city = "Luanda";
$location->district = "Hoji-ya-henda";
$location->road = "Zango4";

$user = new User($contact, $location);
$user->attr_name = "António Gabriel";
$user->attr_email = "antoniogabriel@hotmail.com";

$account = new Account($user);
$account->attr_password = "antoniocampos";

//$contact->registerContact("998987888", "909788667", "999256333");
// var_dump($user->isValidPhoneNumber());
// var_dump($user->isValidEmailAddress());
// var_dump($user->isNullOrEmptyAttributes());

$accountRepository = new AccountRepository();
if ($accountRepository->create($account)) {
    echo "Account Sucess!";
}
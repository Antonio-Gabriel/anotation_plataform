<?php

require_once("location.php");
require_once("contact.php");

class User {

    public int $idUser;
    public string $attr_name;
    public string $attr_email;
    public bool $stage_area = True;
    public datetime $created_at;
    public datetime $updated_at;

    public Contact $contacts;
    public Location $location;
    
    public function __construct(Contact $contact, Location $location) {
        $this->contacts = $contact;
        $this->location = $location;
    }

    public function isValidPhoneNumber() {
        foreach ($this->contacts->attr_contact as $value) {
            if(strlen($value) < 9) {
                return false;
            } 
        }

        return true;
    }

    public function isValidEmailAddress() {
        // Validação com expressões regulares (REGEX)

        return (
            !preg_match(
                "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", 
                $this->attr_email)) ? false : true;
    }

    public function isNullOrEmptyAttributes() {
        if (
            !$this->attr_name || !$this->attr_email 
            || !$this->contacts->attr_contact  
            || !$this->location->city || !$this->location->district
            || !$this->location->road
        ) return false;

        return true;
    }
}
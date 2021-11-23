<?php

class Contact {

    public int $idContact;
    public array $attr_contact = [];
    public int $contact;

    public function registerContact(...$contact) {
        array_push($this->attr_contact, ...$contact);
    }
}
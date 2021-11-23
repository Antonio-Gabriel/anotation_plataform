<?php

require_once("./keywords.php");

class Anotation {

    public int $idAnnotation;
    public string $attr_banner;
    public string $attr_title;
    public string $attr_description;
    public bool $attr_state = False;
    public datetime $created_at;
    public datetime $updated_at;

    public KeyWords $key_words = new KeyWords();
}
<?php

class Upload
{

    private $uploads_dir;

    public function __construct()
    {
        $this->uploads_dir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "/resource";
    }

    public function runUpload($file) {
        foreach ($file["error"] as $key => $error) {
            if($error == UPLOAD_ERR_OK) {
                $tmp_name = $file["tmp_name"][$key];

                $name = basename($file["name"][$key]);
                move_uploaded_file($tmp_name, "{$this->uploads_dir}/$name");
            }
        }
    }
}


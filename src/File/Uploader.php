<?php namespace Flag\Framework\File;

class Uploader {

    public static function upload(array $file, string $path = 'uploads') {
        $name = uniqid();
        $fileName = "$path/$name.png";
    
        if (!move_uploaded_file($file['tmp_name'], $fileName)) {
            return null;
        }
    
        return $fileName;
    }
}
<?php

session_start();

require_once __DIR__ . '/inc/flash.php';
require_once __DIR__ . '/inc/functions.php';

// Upload using ajax -> https://medium.com/@devblogo/how-to-upload-files-using-ajax-and-php-5731a9a14f76

// dump('files', $_FILES['file']);
// dump(isset($_FILES['file']) == true ? 2 : 1);
// dump(get_mime_type($tmp));

uploadFile();

function uploadFile()
{
    $status = $_FILES['file']['error'];
    $filename = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];

    $success = move_uploaded_file($tmp, 'Uploads/' . $_FILES['file']['name']);
    if ($success) {
        header("Location: index.php", true, 303);
        exit;
    }

    function get_mime_type(string $filename)
    {
        $info = finfo_open(FILEINFO_MIME_TYPE);
        if (!$info) {
            return false;
        }

        $mime_type = finfo_file($info, $filename);
        finfo_close($info);

        return $mime_type;
    }
}
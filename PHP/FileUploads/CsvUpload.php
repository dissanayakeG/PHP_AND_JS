<?php

session_start();

require_once __DIR__ . '/inc/functions.php';

// dump('files', $_FILES['file']);
// dump(isset($_FILES['file']) == true ? 2 : 1);
// dump(get_mime_type($tmp));

putIntoACsv();
readCsv();

function readCsv()
{
    $status = $_FILES['file']['error'];
    $filename = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];

    $success = move_uploaded_file($tmp, 'Uploads/' . $_FILES['file']['name']);

    if ($success) {
        if (($handle = fopen('Uploads/' . $_FILES['file']['name'], 'r')) !== FALSE) {

            // Ignore the first row
            $headers = fgetcsv($handle);
            $toDbData = [];

            // while (!feof($file)) {
            while (($data = fgetcsv($handle, 500, ',')) !== FALSE) { //500 is length of a line, should be equal or greater than longest length of a line
                $saveData[$headers[0]] = $data[0];
                $saveData[$headers[1]] = $data[1];
                $saveData[$headers[2]] = $data[2];
                array_push($toDbData, $saveData);
            }

            dump($toDbData);
        }

        fclose($handle);
    }
}


function putIntoACsv()
{

    $list = array(
        array('aaa', 'bbb', 'ccc', 'dddd'),
        array('123', '456', '789'),
        array('"aaa"', '"bbb"')
    );

    $fp = fopen('Uploads/file.csv', 'w');

    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp);
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

// dump('cookie', $_COOKIE);
// dump('session', $_SESSION);
// dump('server', $_SERVER);
// dump('get', $_GET);
// dump('post', $_POST);

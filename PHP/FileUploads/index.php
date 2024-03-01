<?php
session_start();
require_once __DIR__ . '/inc/flash.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css" />

</head>

<body>
    <?php flash('upload') ?>

    <main>

        FILE UPLOADS
        <form enctype="multipart/form-data" action="FileUpload.php" method="post">
            <div>
                <label for="file">Select a file:</label>
                <input type="file" id="file" name="file" />
            </div>
            <div>
                <button type="submit">Upload</button>
            </div>
        </form>

        CSV UPLOADS
        <form enctype="multipart/form-data" action="CsvUpload.php" method="post">
            <div>
                <label for="file">Select a file:</label>
                <input type="file" id="file" name="file" />
            </div>
            <div>
                <button type="submit">Upload</button>
            </div>
        </form>
    </main>

</body>

</html>
<?php

session_start();

require_once __DIR__ . '/inc/flash.php';
require_once __DIR__ . '/inc/functions.php';

dump('files', $_FILES['file']);
// dump('cookie', $_COOKIE);
// dump('session', $_SESSION);
// dump('server', $_SERVER);
// dump('get', $_GET);
// dump('post', $_POST);

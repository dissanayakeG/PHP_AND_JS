<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\OOP\LateStaticBinding\ClassB;


$classB = new ClassB();

var_dump($classB::myMethod());

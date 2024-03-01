<?php

use App\OOP\Encapsulations\Encapsulations;

require_once __DIR__ . '/../../vendor/autoload.php';

$encapsulations = new Encapsulations();

// var_dump($encapsulations->name); //cant access like this, because properties are private, so we have to set and get them by setters and getters
//this is the encapsulations

$encapsulations->setName('Robert')->setAge(25);
var_dump($encapsulations->getName(), $encapsulations->getAge());

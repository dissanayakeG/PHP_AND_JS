<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\OOP\Polymorphisms\Animals;
use App\OOP\Polymorphisms\Bus;
use App\OOP\Polymorphisms\Car;
use App\OOP\Polymorphisms\Cat;
use App\OOP\Polymorphisms\Lion;

//Polymorphism refers to the ability of objects to take on many forms and different behaviors while sharing same interface

//1. By inheritance
// require 'Animals.php';
// require 'Cat.php';
// require 'Lion.php';

$animals = new Animals();
$cat = new Cat();
$lion = new Lion();

var_dump($animals->makeSound());
var_dump($cat->makeSound());
var_dump($lion->makeSound());

echo PHP_EOL;

//2.interfaces
// require 'Vehicle.php';
// require 'Car.php';
// require 'Bus.php';

$car = new Car();
$bus = new Bus();

var_dump($car->engineType());
var_dump($bus->engineType());

//3.abstract classes
//4.both inheritance and interfaces or both inheritance and abstract classes
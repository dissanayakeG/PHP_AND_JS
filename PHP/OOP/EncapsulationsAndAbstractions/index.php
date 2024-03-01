<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\OOP\EncapsulationsAndAbstractions\Encapsulations;

$encapsulations = new Encapsulations();

// var_dump($encapsulations->internalMethod());//cant access like this, because the method is  private,

// var_dump($encapsulations->name); //cant access like this, because the property is  private,

// so we have to set and get them by setters and getters, but using setters and getters breaks encapsulation principle, so make sure to use them if only required
// this is the encapsulations
// This is not only for properties, we can use private/protected for methods as well, external classes must not be able to use and manipulate internal specific methods directly.

// Encapsulations hide internal state or the information while
// Abstraction hide actual implementation of it. ex) user(index.php) doesn't know the implementation of setName() and setAge() methods.

// setting a property public breaks encapsulation principle, it also breaks the abstraction, because ,
// Think we set a property public, and this property has changes from many other places in the codebase, later we want to set this property to different type,
// like integer/string,this will blow up our code base from many places
// We must plan our code so that any modifications we make to a class won't affect other areas (which use this class) of the code base.

$encapsulations->setName('Robert')->setAge(25);
var_dump($encapsulations->getName(), $encapsulations->getAge());

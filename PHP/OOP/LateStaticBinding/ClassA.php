<?php

namespace App\OOP\LateStaticBinding;

class ClassA
{
    protected static $name = 'ClassA';

    public static function myMethod()
    {
        // return self::$name; //This will print ClassA, even the object is ClassB
        return static::$name; //This will print ClassB, when the object is ClassB
    }
}

<?php

//when the function get completed regular variable get destroyed, but static variables not get destroyed
//So static variables cache values

//when we come into OOP, not like regular variables, static variables are not tight to objects(class can have many objects), 
//but it tight to class itself.
//So, they can access without creating a object/instance of the class


function some()
{
    static $value = null;

    if ($value === null) {
        $value = someExpensiveFunction();
    }

    return $value;
}

function someExpensiveFunction()
{
    sleep(2);
    return rand();
}


echo some();
echo PHP_EOL;
echo some();
echo PHP_EOL;
echo some();
echo PHP_EOL;

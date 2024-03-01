<?php

namespace App\OOP\Polymorphisms;

class Car implements Vehicle
{
    public function engineType()
    {
        return 'Car engine';
    }
}

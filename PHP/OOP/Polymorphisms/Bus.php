<?php

namespace App\OOP\Polymorphisms;

class Bus implements Vehicle
{
    public function engineType()
    {
        return 'Bus engine';
    }
}

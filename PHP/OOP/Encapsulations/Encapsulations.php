<?php

namespace App\OOP\Encapsulations;

class Encapsulations
{

    private $name;
    private $age;

    public function setName(String $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAge(String $age)
    {
        $this->age = $age;
        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }
}

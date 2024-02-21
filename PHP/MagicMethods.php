<?php

class MyClass
{

    public $a;

    public function __construct($b)
    {
        $this->a = $b;
    }

    public function __call($method, $parameters)
    {
        var_dump($method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        var_dump($method, $parameters);
    }

    public function __invoke(...$arguments)
    {
        var_dump('called invoke method', $arguments);
    }
}


$instance = new MyClass('a');

// var_dump($instance->a);
// var_dump($instance->myMethod([1,2,3],'mmm'));
// var_dump($instance::myStaticMethod([1,2,3],'mmm'));
var_dump($instance([1, 2, 3], 'mmm'));

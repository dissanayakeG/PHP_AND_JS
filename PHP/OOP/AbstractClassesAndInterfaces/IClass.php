<?php

include_once 'MyInterface.php';

class IClass implements MyInterface
{

    public function a()
    {
        echo 'calling from public method a in IClass'.PHP_EOL;
    }

    public function b()
    {
        echo 'calling from public method b in IClass'.PHP_EOL;
    }
}
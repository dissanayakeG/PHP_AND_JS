<?php
include_once 'MyAbstractClass.php';

class AClass extends MyAbstractClass
{

    public function c()
    {
        echo 'calling from public method c in AClass'.PHP_EOL;
    }
}
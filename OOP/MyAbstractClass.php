<?php


abstract class MyAbstractClass
{
    public abstract function c();

    public function d(){
        echo 'calling from public method d in MyAbstractClass'.PHP_EOL;
    }

}
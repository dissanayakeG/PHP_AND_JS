<?php

include_once 'AClass.php';
include_once 'IClass.php';

class UseClass
{
    public $AClass;
    public $IClass;

    public function __construct()
    {
        $this->AClass = new AClass();
        $this->IClass = new IClass();
    }

    public function showUse(){
        $this->IClass->a();
        $this->IClass->b();
        $this->AClass->c();
        $this->AClass->d();
    }
}

$obj = new UseClass();
echo $obj->showUse();
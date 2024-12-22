<?php
//1
trait Address{
    public function createAddress(){
        dd('calling...');
    }
}

class Animal{
    use Address;
}

class Dolphine extends Animal{
    public function initialize(){
        parent::createAddress();  // Success: Can call parent because trait is used in the parent class
    }
}

$a = new Dolphine();
$a->initialize();


//2

trait MyTrait {
    public function sayHello() {
        dd('calling2...');
    }
}

class Child {
    use MyTrait;

    public function callParent() {
        //parent::sayHello(); // Error: Cannot call parent because no parent exists
    }
}

$a = new Child();
$a->callParent();
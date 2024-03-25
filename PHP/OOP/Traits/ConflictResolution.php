<?php

namespace App\OOP\Traits;

//Conflict Resolution in Traits

trait A
{
    public function hello()
    {
        echo "Hello from A\n";
    }
}

trait B
{
    public function hello()
    {
        echo "Hello from B\n";
    }
}

class C
{
    use A, B {
        A::hello insteadof B; // Use hello method from trait A
        B::hello as sayHelloFromB; // Rename hello method from trait B
    }
}

$c = new C();
$c->hello(); // Outputs: "Hello from A"
$c->sayHelloFromB(); // Outputs: "Hello from B"
